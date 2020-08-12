@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_audit.view_title')  }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('audit') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-header">
                <div class="float-left">
                </div> <!-- ./float-left -->

                <div class="float-right">
                    <a href="{{ route('audit.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i> {{ __('gennix.model_audit.update_screen') }}
                    </a>
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_audit.id') }}</th>
                                <th scope="col">{{ __('gennix.model_audit.operation') }}</th>
                                <th scope="col">{{ __('gennix.model_audit.user') }}</th>
                                <th scope="col">{{ __('gennix.model_audit.model') }}</th>
                                <th scope="col">{{ __('gennix.model_audit.created_at') }}</th>
                                <th scope="col">{{ __('gennix.model_audit.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($audits as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row">{{ $row->id }}</th>
                                <td>
                                    @if($row->description == 'created')
                                    <span class="badge badge-success">{{ __('gennix.model_audit.operation_created') }}</span>
                                    @elseif ($row->description == 'updated')
                                    <span class="badge badge-warning">{{ __('gennix.model_audit.operation_updated') }}</span>
                                    @else
                                    <span class="badge badge-danger">{{ __('gennix.model_audit.operation_deleted') }}</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $row->getCauser($row->causer_id, $row->causer_type, 'name') }}
                                </td>

                                <td>
                                    {{ $row->subject_type }}<br>
                                    <small class="text-muted">ID: {{ $row->subject_id }}</small>
                                </td>

                                <td>{{ $row->created_at->format(env('DATE_FORMAT_LONG')) }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"></i> {{ __('gennix.model_audit.actions') }}
                                        </button>

                                        <!-- dropdown menu -->
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            @can('audit-show')
                                            <!-- details option -->
                                            <a href="{{ route('audit.show', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_audit.more_details') }}
                                            </a>
                                            @endcan
                                        </div> <!-- dropdown-menu -->
                                    </div> <!-- dropdown -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- ./table-responsive -->
            </div> <!-- ./card-body -->
        </div> <!-- ./card -->
    </div> <!-- ./col-md-12 -->
</div> <!-- ./row -->
@stop



@section('adminlte_css_pre')
@stop

@section('css')
@stop

@section('js')
<script>
$(function () {
    $("#datatable").DataTable({
        stateSave: true,
        autoWidth: false,
        lengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "{{ __('gennix.all') }}"]
        ],
        language: {
            url: "{{ asset('vendor/datatables/js/i18n') . '/' . app()->getLocale() . '.json' }}",
        },
        columns: [
            { width: '3em' },
            null,
            null,
            null,
            null,
            { orderable: false, searchable: false, width:'6em' },
        ],
    });
});
</script>
@stop
