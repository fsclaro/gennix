@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_role.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('role_show') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_role.details_id') }}</label><br>
                        <input type="text" class="form-control text-right" readonly id="id" value="{{ $role->id }}">
                    </div>
                    <div class="form-group col">
                        <label for="title">{{ __('gennix.model_role.details_title')}}</label>
                        <input type="text" class="form-control" readonly id="title" value="{{ $role->title }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="slug">{{ __('gennix.model_role.permissions') }}
                            <small class="text-red text-bold">
                                (
                                    @if (count($role->permissions) == 0)
                                    {{ __('gennix.model_role.zero_permissions') }}
                                    @elseif (count($role->permissions) == 1)
                                    {{ count($role->permissions) }} {{ __('gennix.model_role.one_permission') }}
                                    @else
                                    {{ count($role->permissions) }} {{ __('gennix.model_role.more_permissions') }}
                                    @endif
                                )
                            </small>
                        </label>
                        <div class="card card-outline card-danger" style="background-color: #E9ECEF;margin-top: -1px;">
                            <div class="card-header">
                                @foreach($role->permissions as $key => $permission)
                                <span class="badge badge-primary">
                                    {{ $permission->title }}
                                </span>&nbsp;
                                @endforeach
                            </div> <!-- ./card-header-->
                        </div> <!-- ./card -->
                    </div> <!-- ./form-group-->
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="slug">{{ __('gennix.model_role.details_users') }}
                            <small class="text-red text-bold">
                                (
                                    @if (count($role->users) == 0)
                                    {{ __('gennix.model_role.zero_users') }}
                                    @elseif (count($role->users) == 1)
                                    {{ count($role->users) }} {{ __('gennix.model_role.one_user') }}
                                    @else
                                    {{ count($role->users) }} {{ __('gennix.model_role.more_users') }}
                                    @endif
                                )
                            </small>
                        </label>
                        <div class="card card-outline card-success" style="background-color: #E9ECEF;margin-top: -1px;">
                            <div class="card-header">
                                @foreach($role->users as $key => $user)
                                <span class="badge badge-primary">
                                    {{ $user->name }}
                                </span>&nbsp;
                                @endforeach
                            </div> <!-- ./card-header-->
                        </div> <!-- ./card -->
                    </div> <!-- ./form-group-->
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="created_at">{{ __('gennix.model_role.details_created_at') }}</label><br>
                        @if($role->created_at)
                        <input type="text" class="form-control" readonly id="created_at" value="{{ $role->created_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="created_at" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="updated_at">{{ __('gennix.model_role.details_updated_at') }}</label><br>
                        @if($role->updated_at)
                        <input type="text" class="form-control" readonly id="updated_at" value="{{ $role->updated_at->format(env('DATE_FORMAT_LONG)) }}">
                        @else
                        <input type="text" class="form-control" readonly id="updated_at" value="">
                        @endif
                    </div>

                </div> <!-- ./row -->
            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('role.index') }}" class="btn btn-default"><i class="fas fa-arrow-circle-left"> {{ __("gennix.back") }}</i></a>
            </div> <!-- ./card-footer-->
        </div> <!-- ./card -->
    </div> <!-- ./col-md-12 -->
</div> <!-- ./row -->

@stop



@section('adminlte_css_pre')
@stop

@section('css')
@stop

@section('js')
@stop
