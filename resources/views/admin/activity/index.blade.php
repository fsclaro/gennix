@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-clipboard-check"></i> {{ __('gennix.model_activity.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('activity') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-header">
                <div class="float-left">
                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bolt"> {{ __('gennix.model_activity.actions') }}</i>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="#" class="dropdown-item" onclick="processRecords(event, 0);">
                                <i class="fas fa-fw fa-check"></i> {{ __('gennix.model_activity.mark_all_read') }}
                            </a>

                            <a href="#" class="dropdown-item" onclick="processRecords(event, 1);">
                                <i class="fas fa-fw fa-times"></i> {{ __('gennix.model_activity.mark_all_unread') }}
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-red" onclick="processRecords(event, 2);">
                                <i class="fas fa-fw fa-trash"></i> {{ __('gennix.model_activity.delete_selected') }}
                            </a>
                        </div>
                    </div>
                </div> <!-- ./float-left -->

                <div class="float-right">
                    <a href="{{ route('activity.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i> {{ __('gennix.model_activity.update_screen') }}
                    </a>
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <div class="icheck-primary icheck-inline">
                                        <input type="checkbox" name="chk-column" id="chk-column"
                                            onchange="changeCheckbox();" value="">
                                        <label for="chk-column"</label>
                                    </div>
                                </th>
                                <th scope="col">{{ __('gennix.model_activity.id') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.user') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.title') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.read') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.when') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.details_type') }}</th>
                                <th scope="col">{{ __('gennix.model_activity.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($activities as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <td class="align-middle">
                                    <div class="icheck-primary icheck-inline">
                                        <input type="checkbox" name="ids[]" id="chk-{{ $row->id }}" value="{{ $row->id }}"">
                                        <label for="chk-{{ $row->id }}"></label>
                                    </div>
                                </td>
                                <th scope="row">{{ $row->id }}</th>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->title }}</td>
                                <td>
                                    @if ($row->is_read)
                                    <span
                                        class="badge badge-primary">{{ __('gennix.yes') }}</span>
                                    @else
                                    <span
                                        class="badge badge-danger">{{ __('gennix.no') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->created_at)
                                    {{ $row->created_at->format(env("DATE_FORMAT_LONG")) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($row->type == 'success')
                                    <span class="badge badge-success">{{ __('gennix.model_activity.success') }}</span>
                                    @elseif ($row->type == 'error')
                                    <span class="badge badge-danger">{{ __('gennix.model_activity.error') }}</span>
                                    @elseif ($row->type == 'info')
                                    <span class="badge badge-info">{{ __('gennix.model_activity.info') }}</span>
                                    @elseif ($row->type == 'warning')
                                    <span class="badge badge-warning">{{ __('gennix.model_activity.warning') }}</span>
                                    @else
                                    <span class="badge badge-secondary">{{ __('gennix.model_activity.undefined') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"> {{ __('gennix.model_activity.actions') }}</i>
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('activity.details', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_activity.more_details') }}
                                            </a>

                                            @if (Auth::user()->is_superadmin)
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript;" class="dropdown-item text-red" onclick="deleteRecord(event, {{ $row->id }});">
                                                <i class="fas fa-fw fa-trash"></i> {{ __('gennix.model_activity.exclude_record') }}
                                            </a>
                                            @endif
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
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
            url: "{{ asset('') . env('DATATABLE_LANGUAGE') }}",
        },
        columns: [
            { orderable: false, searchable: false, width: '2em' },
            { width: '3em'},
            null,
            null,
            null,
            null,
            null,
            { orderable: false, searchable: false, width: '6em' },
        ],
        order: [
            [1, "desc"]
        ],
    });
});

function generateArray() {
    var ids = document.getElementsByName('ids[]');
    var arrIDs = new Array();
    var j = 0;

    for(let i = 0; i < ids.length; i++) {
        if (ids[i].checked) {
            arrIDs[j] = ids[i].value;
            j++;
        }
    }

    return arrIDs;
}

function verifySelected() {
    var ids = document.getElementsByName('ids[]');

    for (let i = 0; i < ids.length; i++) {
        if (ids[i].checked) {
            return true;
        }
    }

    Swal.fire({
        icon: 'error',
        title: '{{ __("gennix.opps") }}',
        text: '{{ __("gennix.no_selected_rows") }}',
        showConfirmButton: true,
        confirmButtonText: '<i class="fas fa-check"></i> {{ __("gennix.understood") }}',
        timer: 5000,
    });

    return false;
}

function processRecords(e, type) {
    e.preventDefault();

    if (! verifySelected()) {
        return false;
    }

    var data = generateArray();
    var route = '{{ url("activity/process") }}' + '/' + type;

    Swal.fire({
        icon: 'warning',
        title: '{{ __("gennix.model_activity.confirm_action") }}',
        text: '{{ __("gennix.model_activity.confirm_text") }}',
        showCancelButton: true,
        confirmButtonText: '{{ __("gennix.model_activity.yes") }}',
        cancelButtonText: '{{ __("gennix.model_activity.no") }}',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        focusCancel: true,
        width: '35rem',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "POST",
                    data: data,
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    location.reload();
                },
            })
        } else {
            location.reload();
        }
    });
}


function deleteRecord(e, id) {
    e.preventDefault();

    var url = "{{ url('activity') }}" + '/' + id

    Swal.fire({
        icon: 'warning',
        title: '{{ __("gennix.model_activity.confirm_action") }}',
        text: '{{ __("gennix.model_activity.exclude_confirm") }}',
        showCancelButton: true,
        confirmButtonText: '{{ __("gennix.model_activity.yes") }}',
        cancelButtonText: '{{ __("gennix.model_activity.no") }}',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        focusCancel: true,
        width: '35rem',
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'DELETE',
                },
                success: function() {
                    location.reload();
                },
                error: function() {
                    location.reload();
                },
            })
        } else {
            location.reload();
        }
    });
};


function changeCheckbox() {
    var checkBox = document.getElementById('chk-column');
    var allCheckBox = document.getElementsByName('ids[]');

    for (let i = 0; i < allCheckBox.length; i++) {
        allCheckBox[i].checked = checkBox.checked;
    }
}

</script>
@stop
