@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-key"></i> {{ __('gennix.model_permission.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('permission_show') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_permission.details_id') }}</label><br>
                        <input type="text" class="form-control text-right" readonly id="id" value="{{ $permission->id }}">
                    </div>
                    <div class="form-group col">
                        <label for="title">{{ __('gennix.model_permission.details_title')}}</label>
                        <input type="text" class="form-control" readonly id="title" value="{{ $permission->title }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="slug">{{ __('gennix.model_permission.slug') }}</label><br>
                        <input type="text" class="form-control" readonly id="slug" value="{{ $permission->slug }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="slug">{{ __('gennix.model_permission.roles') }}
                            <small class="text-red text-bold">
                                (
                                    @if (count($permission->roles) == 0)
                                    {{ __('gennix.model_permission.zero_roles') }}
                                    @elseif (count($permission->roles) == 1)
                                    {{ count($permission->roles) }} {{ __('gennix.model_permission.one_role') }}
                                    @else
                                    {{ count($permission->roles) }} {{ __('gennix.model_permission.more_roles') }}
                                    @endif
                                )
                            </small>
                        </label>
                        <div class="card card-outline card-danger" style="background-color: #E9ECEF;margin-top: -1px;">
                            <div class="card-header">
                                @foreach($permission->roles as $key => $role)
                                <span class="badge badge-primary">
                                    {{ $role->title }}
                                </span>&nbsp;
                                @endforeach
                            </div> <!-- ./card-header-->
                        </div> <!-- ./card -->
                    </div> <!-- ./form-group-->
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="created_at">{{ __('gennix.model_permission.details_created_at') }}</label><br>
                        @if($permission->created_at)
                        <input type="text" class="form-control" readonly id="created_at" value="{{ $permission->created_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="created_at" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="updated_at">{{ __('gennix.model_permission.details_updated_at') }}</label><br>
                        @if($permission->updated_at)
                        <input type="text" class="form-control" readonly id="updated_at" value="{{ $permission->updated_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="updated_at" value="">
                        @endif
                    </div>
                </div> <!-- ./row -->


            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('permission.index') }}" class="btn btn-default"><i class="fas fa-arrow-circle-left"> {{ __("gennix.back") }}</i></a>
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
