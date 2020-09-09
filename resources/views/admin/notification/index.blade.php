@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-bullhorn"></i> {{ __('gennix.model_notification.view_title')  }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('notification') }}
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
                    <a href="{{ route('notification.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i> {{ __('gennix.model_notification.update_screen') }}
                    </a>
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_notification.id') }}</th>
                                <th scope="col">{{ __('gennix.model_notification.user_from') }}</th>
                                @if (Auth::user()->is_superadmin)
                                <th scope="col">{{ __('gennix.model_notification.user_to') }}</th>
                                @endif
                                <th scope="col">{{ __('gennix.model_notification.subject') }}</th>
                                <th scope="col">{{ __('gennix.model_notification.is_read') }}</th>
                                <th scope="col">{{ __('gennix.model_notification.datetime_send') }}</th>
                                <th scope="col">{{ __('gennix.model_notification.actions') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($notifications as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row">{{ $row->id }}</th>
                                <td scope="row">
                                    <img src="{{ App\User::find($row->user_id)->getAvatar($row->user_id) }}" class="img-circle img-bordered-sm shadow" width="36px">
                                    {{ Str::limit(App\User::find($row->user_id)->name,12) }}
                                </td>
                                @if (Auth::user()->is_superadmin)
                                <td scope="row">
                                    <img src="{{ App\User::find($row->user_id_to)->getAvatar($row->user_id_to) }}" class="img-circle img-bordered-sm shadow" width="36px">
                                    {{ Str::limit(App\User::find($row->user_id_to)->name,12) }}
                                </td>
                                @endif
                                <td scope="row">
                                    @if ($row->notification_type == "info")
                                    <i class="fas fa-info-circle text-blue mr-1"></i>
                                    @elseif ($row->notification_type == "danger")
                                    <i class="fas fa-exclamation-triangle text-red mr-1"></i>
                                    @else
                                    <i class="fas fa-bullhorn mr-1"></i>
                                    @endif
                                    {{ Str::limit($row->subject,50) }}
                                </td>
                                <td scope="row">
                                    @if ($row->is_read)
                                    <span class="badge badge-success">Sim</span>
                                    @else
                                    <span class="badge badge-danger">Não</span>
                                    @endif
                                </td>
                                <td scope="row">
                                    @if($row->created_at)
                                    {{ $row->created_at->format(env('DATE_FORMAT_LONG')) }}
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-bolt"></i> {{ __('gennix.model_notification.actions') }}
                                        </button>

                                        <!-- dropdown menu -->
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                            @can('notification-show')
                                            <!-- details option -->
                                            <a href="{{ route('notification.show', $row->id) }}" class="dropdown-item">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('gennix.model_notification.more_details') }}
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
            @if (Auth::user()->is_superadmin)
            null,
            @endif
            null,
            null,
            { orderable: false, searchable: false, width:'6em' },
        ],
    });
});
</script>
@stop
