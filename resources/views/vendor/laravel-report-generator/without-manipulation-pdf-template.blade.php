<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }
            .wrapper {
                margin: 0 -20px 0;
                padding: 0 15px;
            }
            .middle {
                text-align: center;
            }
            .title {
                font-size: 35px;
            }
            .pb-10 {
                padding-bottom: 10px;
            }
            .pb-5 {
                padding-bottom: 5px;
            }
            .head-content{
                padding-bottom: 4px;
                border-style: none none ridge none;
                font-size: 18px;
            }
            thead { display: table-header-group; }
            tfoot { display: table-row-group; }
            tr { page-break-inside: avoid; }
            table.table {
                font-size: 13px;
                border-collapse: collapse;
            }
            .page-break {
                page-break-after: always;
                page-break-inside: avoid;
            }
            tr.even {
                background-color: #eff0f1;
            }
            table .left {
                text-align: left;
            }
            table .right {
                text-align: right;
            }
            table .bold {
                font-weight: 600;
            }
            .bg-black {
                background-color: #000;
            }
            .f-white {
                color: #fff;
            }
        </style>
    </head>
    <body>
        <?php
        $ctr = 1;
        $no = 1;
        $total = [];
        $grandTotalSkip = 1;
        $currentGroupByData = [];
        $isOnSameGroup = true;

        foreach ($showTotalColumns as $column => $type) {
            $total[$column] = 0;
        }

        if ($showTotalColumns != []) {
            foreach ($columns as $colName => $colData) {
                if (!array_key_exists($colName, $showTotalColumns)) {
                    $grandTotalSkip++;
                } else {
                    break;
                }
            }
        }

        $grandTotalSkip = !$showNumColumn ? $grandTotalSkip - 1 : $grandTotalSkip;
        ?>
        <div class="wrapper">
            <div class="pb-5">
                <div class="middle pb-10 title">
                    {{ $headers['title'] }}
                </div>
                @if ($showMeta)
                <div class="head-content">
                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                        <?php $metaCtr = 0; ?>
                        @foreach($headers['meta'] as $name => $value)
                            @if ($metaCtr % 2 == 0)
                            <tr>
                            @endif
                                <td><span style="color:#808080;">{{ $name }}</span>: {{ ucwords($value) }}</td>
                            @if ($metaCtr % 2 == 1)
                            </tr>
                            @endif
                            <?php $metaCtr++; ?>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
            <div class="content">
                <table width="100%" class="table">
                    @if ($showHeader)
                    <thead>
                        <tr>
                            @if ($showNumColumn)
                                <th class="left">No</th>
                            @endif
                            @foreach ($columns as $colName => $colData)
                                <th class="left">{{ $colName }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    @endif
                    <?php
                    $__env = isset($__env) ? $__env : null;
                    ?>
                    @foreach($query->when($limit, function($qry) use($limit) { $qry->take($limit); })->cursor() as $result)
                        <?php
                            if ($limit != null && $ctr == $limit + 1) return false;
                            if ($groupByArr) {
                                $isOnSameGroup = true;
                                foreach ($groupByArr as $groupBy) {
                                    if (is_object($columns[$groupBy]) && $columns[$groupBy] instanceof Closure) {
                                        $thisGroupByData[$groupBy] = $columns[$groupBy]($result);
                                    } else {
                                        $thisGroupByData[$groupBy] = $result->{$columns[$groupBy]};
                                    }

                                    if (isset($currentGroupByData[$groupBy])) {
                                        if ($thisGroupByData[$groupBy] != $currentGroupByData[$groupBy]) {
                                            $isOnSameGroup = false;
                                        }
                                    }

                                    $currentGroupByData[$groupBy] = $thisGroupByData[$groupBy];
                                }

                                if ($isOnSameGroup === false) {
                                    echo '<tr class="bg-black f-white">';
                                    if ($showNumColumn || $grandTotalSkip > 1) {
                                        echo '<td colspan="' . ($grandTotalSkip) . '"><b>Grand Total</b></td>';
                                    }
                                    $dataFound = false;
                                    foreach ($columns as $colName => $colData) {
                                        if (array_key_exists($colName, $showTotalColumns)) {
                                            if ($showTotalColumns[$colName] == 'point') {
                                                echo '<td class="left"><b>' . number_format($total[$colName], 2, '.', ',') . '</b></td>';
                                            } else {
                                                echo '<td class="left"><b>' . strtoupper($showTotalColumns[$colName]) . ' ' . number_format($total[$colName], 2, '.', ',') . '</b></td>';
                                            }
                                            $dataFound = true;
                                        } else {
                                            if ($dataFound) {
                                                echo '<td></td>';
                                            }
                                        }
                                    }
                                    echo '</tr>';

                                    // Reset No, Reset Grand Total
                                    $no = 1;
                                    foreach ($showTotalColumns as $showTotalColumn => $type) {
                                        $total[$showTotalColumn] = 0;
                                    }
                                    $isOnSameGroup = true;
                                }
                            }
                        ?>
                        <tr align="center" class="{{ ($no % 2 == 0) ? 'even' : 'odd' }}">
                            @if ($showNumColumn)
                                <td class="left">{{ $no }}</td>
                            @endif
                            <?php
                                $data = $result->toArray();
                                if (count($data) > count($columns)) array_pop($data);
                            ?>
                            @foreach ($data as $rowData)
                                <td class="left">{{ $rowData }}</td>
                            @endforeach
                        </tr>
                        <?php
                            foreach ($showTotalColumns as $colName => $type) {
                                $total[$colName] += $result->{$columns[$colName]};
                            }
                            $ctr++; $no++;
                        ?>
                    @endforeach
                    @if ($showTotalColumns != [] && $ctr > 1)
                        <tr class="bg-black f-white">
                            @if ($showNumColumn || $grandTotalSkip > 1)
                                <td colspan="{{ $grandTotalSkip }}"><b>Grand Total</b></td> {{-- For Number --}}
                            @endif
                            <?php $dataFound = false; ?>
                            @foreach ($columns as $colName => $colData)
                                @if (array_key_exists($colName, $showTotalColumns))
                                    <?php $dataFound = true; ?>
                                    @if ($showTotalColumns[$colName] == 'point')
                                        <td class="left"><b>{{ number_format($total[$colName], 2, '.', ',') }}</b></td>
                                    @else
                                        <td class="left"><b>{{ strtoupper($showTotalColumns[$colName]) }} {{ number_format($total[$colName], 2, '.', ',') }}</b></td>
                                    @endif
                                @else
                                    @if ($dataFound)
                                        <td></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <script type="text/php">
            @if (strtolower($orientation) == 'portrait')
            if ( isset($pdf) ) {
                $pdf->page_text(30, ($pdf->get_height() - 26.89), "Date Printed: " . date('d M Y H:i:s'), null, 10);
                $pdf->page_text(($pdf->get_width() - 84), ($pdf->get_height() - 26.89), "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10);
            }
            @elseif (strtolower($orientation) == 'landscape')
            if ( isset($pdf) ) {
                $pdf->page_text(30, ($pdf->get_height() - 26.89), "Date Printed: " . date('d M Y H:i:s'), null, 10);
                $pdf->page_text(($pdf->get_width() - 84), ($pdf->get_height() - 26.89), "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10);
            }
            @endif
        </script>
    </body>
</html>
