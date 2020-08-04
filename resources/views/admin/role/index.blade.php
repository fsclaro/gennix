@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_role.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('role') }}
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
                    <a href="{{ route('role.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i> {{ __('gennix.model_role.update_screen') }}
                    </a>
                    <a href="{{ route('role.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> {{ __('gennix.model_role.insert_new') }}
                    </a>
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_role.id') }}</th>
                                <th scope="col">{{ __('gennix.model_role.title') }}</th>
                                <th scope="col">{{ __('gennix.model_role.permissions') }}</th>
                                <th scope="col">{{ __('gennix.model_role.users') }}</th>
                                <th scope="col">{{ __('gennix.model_role.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($roles as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row">{{ $row->id }}</th>
                                <td>{{ $row->title }}</td>
                                <td>
                                    @foreach($row->permissions as $key => $permission)
                                    <span class="badge badge-primary">
                                        {{ $permission->title }}
                                    </span>&nbsp;
                                    @endforeach
                                </td>

                                <td>
                                    @foreach($row->users as $key => $user)
                                    <span class="badge badge-success">
                                        {{ $user->name }}
                                    </span>&nbsp;
                                    @endforeach
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"> {{ __('gennix.model_role.actions') }}</i>
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('role.show', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_role.more_details') }}
                                            </a>

                                            <a href="{{ route('role.edit', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-edit"></i> {{ __('gennix.model_role.edit') }}
                                            </a>

                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('role.clone', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-copy"></i> {{ __('gennix.model_role.clone_role') }}
                                            </a>

                                            @if (count($row->users) == 0)
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript;" class="dropdown-item text-red" id="deleteRecord" onclick="deleteRecord(event, {{ $row->id }});">
                                                <i class="fas fa-fw fa-trash"></i> {{ __('gennix.model_role.exclude_record') }}
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
            { width: '10em' },
            null,
            { width: '10em'},
            { orderable: false, searchable: false, width:'6em' },
        ],
    });
});

function deleteRecord(e, id) {
    e.preventDefault();

    var data = id;
    var url = "{{ url('/role') }}" + '/' + id

    Swal.fire({
        icon: 'warning',
        title: '{{ __("gennix.model_role.confirm_action") }}',
        text: '{{ __("gennix.model_role.confirm_text") }}',
        showCancelButton: true,
        confirmButtonText: '{{ __("gennix.model_role.yes") }}',
        cancelButtonText: '{{ __("gennix.model_role.no") }}',
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
