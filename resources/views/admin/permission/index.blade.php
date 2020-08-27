@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-key"></i> {{ __('gennix.model_permission.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('permission') }}
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
                                <i class="fas fa-download"></i> {{ __('gennix.model_permission.export') }}
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownOperationsButton">
                                <a href="{{ route('permission.export', 'xlsx') }}" class="dropdown-item">
                                    <i class="fas fa-file-excel"></i> {{ __('gennix.model_permission.export_excel') }}
                                </a>

                                <a href="{{ route('permission.export', 'csv') }}" class="dropdown-item">
                                    <i class="fas fa-file-alt"></i> {{ __('gennix.model_permission.export_csv') }}
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('permission.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-sync"></i> {{ __('gennix.model_permission.update_screen') }}
                        </a>
                        <a href="{{ route('permission.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ __('gennix.model_permission.insert_new') }}
                        </a>
                    </div> <!-- ./row -->
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_permission.id') }}</th>
                                <th scope="col">{{ __('gennix.model_permission.title') }}</th>
                                <th scope="col">{{ __('gennix.model_permission.slug') }}</th>
                                <th scope="col">{{ __('gennix.model_permission.roles') }}</th>
                                <th scope="col">{{ __('gennix.model_permission.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($permissions as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row">{{ $row->id }}</th>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->slug }}</td>
                                <td>
                                    @foreach($row->roles as $key => $role)
                                    <span class="badge badge-success">
                                        {{ $role->title }}
                                    </span>&nbsp;
                                    @endforeach
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"></i> {{ __('gennix.model_permission.actions') }}
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('permission.show', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_permission.more_details') }}
                                            </a>

                                            <a href="{{ route('permission.edit', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-edit"></i> {{ __('gennix.model_permission.edit') }}
                                            </a>

                                            @if (count($row->roles) == 0)
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript;" class="dropdown-item text-red" id="deleteRecord" onclick="deleteRecord(event, {{ $row->id }});">
                                                <i class="fas fa-fw fa-trash"></i> {{ __('gennix.model_permission.exclude_record') }}
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
            { width: '3em' },   // id
            { width: '25em' },  // Description/title
            { width: '20em'},   // Slug
            { width: '17em'},   // Roles
            { orderable: false, searchable: false, width:'6em' }, // Actions
        ],
    });
});

function deleteRecord(e, id) {
    e.preventDefault();

    var data = id;
    var url = "{{ url('/permission') }}" + '/' + id

    Swal.fire({
        icon: 'warning',
        title: '{{ __("gennix.model_permission.confirm_action") }}',
        text: '{{ __("gennix.model_permission.confirm_text") }}',
        showCancelButton: true,
        confirmButtonText: '{{ __("gennix.model_permission.yes") }}',
        cancelButtonText: '{{  __("gennix.model_permission.no") }}',
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
