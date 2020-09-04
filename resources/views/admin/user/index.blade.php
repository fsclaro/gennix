@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-users"></i> {{ __('gennix.model_user.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('user') }}
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
                    <div class="row">
                        <div class="dropdown mr-1">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                id="dropdownOperationsButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-download"></i> {{ __('gennix.model_user.export') }}
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownOperationsButton">
                                <a href="{{ route('user.export', 'xlsx') }}" class="dropdown-item">
                                    <i class="fas fa-file-excel text-green"></i> {{ __('gennix.model_user.export_excel') }}
                                </a>

                                <a href="{{ route('user.export', 'csv') }}" class="dropdown-item">
                                    <i class="fas fa-file-alt"></i> {{ __('gennix.model_user.export_csv') }}
                                </a>

                                <a href="{{ route('user.export', 'pdf') }}" target="_blank" class="dropdown-item">
                                    <i class="fas fa-file-pdf text-red"></i> {{ __('gennix.model_user.export_pdf') }}
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm mr-1">
                            <i class="fas fa-sync"></i> {{ __('gennix.model_user.update_screen') }}
                        </a>

                        <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ __('gennix.model_user.insert_new') }}
                        </a>
                    </div> <!-- ./row -->
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_user.id') }}</th>
                                <th scope="col">{{ __('gennix.model_user.name') }}</th>
                                <th scope="col">{{ __('gennix.model_user.email') }}</th>
                                <th scope="col">{{ __('gennix.model_user.active') }}</th>
                                <th scope="col">{{ __('gennix.model_user.is_superadmin') }}</th>
                                <th scope="col">{{ __('gennix.model_user.role') }}</th>
                                <th scope="col">{{ __('gennix.model_user.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row" class="align-middle">{{ $row->id }}</th>
                                <td class="d-flex align-items-center">
                                    <img src="{{ $row->getAvatar($row->id) }}" class="img-circle img-bordered-sm shadow" width="50px">
                                    <div class="ml-2">
                                        {{ $row->name }}<br>
                                        <small class="text-muted">
                                            {{ $row->position }}
                                        </small>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $row->email }}</td>
                                <td class="align-middle">
                                    @if ($row->active)
                                    <span class="badge badge-success">
                                        {{ __('gennix.yes') }}
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        {{ __('gennix.no') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($row->is_superadmin)
                                    <span class="badge badge-success">
                                        {{ __('gennix.yes') }}
                                    </span>
                                    @else
                                    <span class="badge badge-danger">
                                        {{ __('gennix.no') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if ($row->is_superadmin)
                                        <span class="badge badge-primary">
                                            {{ __('gennix.superadmin') }}
                                        </span>
                                    @else
                                        @foreach($row->roles as $key => $role)
                                        <span class="badge badge-success">
                                            {{ $role->title }}
                                        </span>&nbsp;
                                        @endforeach
                                    @endif
                                </td>

                                <td class="align-middle">
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"></i> {{ __('gennix.model_user.actions') }}
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('user.show', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_user.more_details') }}
                                            </a>

                                            @if($row->id != Auth::user()->id)
                                            <a href="{{ route('user.edit', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-edit"></i> {{ __('gennix.model_user.edit') }}
                                            </a>

                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('user.password.change', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-key"></i> {{ __('gennix.model_user.change_password') }}
                                            </a>
                                            @endif

                                            @if (! $row->is_superadmin)
                                                @if ($row->active)
                                                    <a href="{{ route('user.deactive', $row->id) }}" class="dropdown-item">
                                                        <i class="fas fa-fw fa-user-times"></i> {{ __('gennix.model_user.deactivated') }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('user.active', $row->id) }}" class="dropdown-item">
                                                        <i class="fas fa-fw fa-user-check"></i> {{ __('gennix.model_user.activated') }}
                                                    </a>
                                                @endif

                                                <div class="dropdown-divider"></div>
                                                <a href="javascript;" class="dropdown-item text-red" id="deleteRecord" onclick="deleteRecord(event, {{ $row->id }});">
                                                    <i class="fas fa-fw fa-trash"></i> {{ __('gennix.model_user.exclude_record') }}
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
            url: "{{ asset('vendor/datatables/js/i18n') . '/' . app()->getLocale() . '.json' }}",
        },
        columns: [
            { width: '3em' },
            { width: '16em' },
            null,
            { width: '5em' },
            { width: '8em' },
            { width: '10em' },
            { orderable: false, searchable: false, width:'6em' },
        ],
    });
});

function deleteRecord(e, id) {
    e.preventDefault();

    var data = id;
    var url = "{{ url('/user') }}" + '/' + id

    Swal.fire({
        icon: 'warning',
        title: '{{ __("gennix.model_user.confirm_action") }}',
        text: '{{ __("gennix.model_user.confirm_text") }}',
        showCancelButton: true,
        confirmButtonText: '{{ __("gennix.model_user.yes") }}',
        cancelButtonText: '{{ __("gennix.model_user.no") }}',
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

</script>
@stop
