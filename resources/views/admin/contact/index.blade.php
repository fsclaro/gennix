@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_contact.view_title')  }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('contact') }}
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
                    <a href="{{ route('contact.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-sync"></i> {{ __('gennix.model_contact.update_screen') }}
                    </a>
                </div> <!-- ./float-right -->
            </div> <!-- ./card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('gennix.model_contact.id') }}</th>
                                <th scope="col"> {{ __('gennix.model_contact.name') }}</th>
                                <th scope="col"> {{ __('gennix.model_contact.email') }}</th>
                                <th scope="col"> {{ __('gennix.model_contact.phone') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($contacts as $row)
                            <tr data-entry-id="{{ $row->id }}">
                                <th scope="row">{{ $row->id }}</th>

                                <td class="d-flex align-items-center">
                                    <img src="{{ $row->getAvatar($row->id) }}" class="img-circle img-bordered-sm shadow" width="50px">
                                    <div class="ml-2">
                                        {{ $row->name }}<br>
                                        <small class="text-muted">{{ $row->position }}</small>
                                    </div>
                                </td>

                                <td>
                                    <a href="mailto:{{ $row->email }}">{{ $row->email }}</a>
                                </td>

                                <td>
                                    <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a>
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
            null
        ],
    });
});
</script>
@stop
