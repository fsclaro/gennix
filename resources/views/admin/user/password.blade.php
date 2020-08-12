@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-users"></i> {{ __('gennix.model_user.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('user_password') }}
</div>
@stop

@section('content')
<form method="post" action="{{ route('user.password.store', $user) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $user->id }}">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 border-right border-light">
                            <div class="text-center">
                                <label for="avatar">{{ __('gennix.model_user.avatar') }}</label><br/>
                                <div class="image-text-center">
                                    <img src="{{ $user->getAvatar($user->id) }}" id="img-avatar" name="img-avatar"
                                    class="profile-user-image img-fluid img-circle img-bordered-sm shadow" width="140px">
                                </div>
                            </div> <!-- ./text-center-->
                        </div> <!-- ./col-md-2 -->

                        <div class="col-md-10">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="id">{{ __('gennix.model_user.details_id') }}</label><br>
                                    <input type="text" class="form-control text-right" readonly id="id" value="{{ $user->id }}">
                                </div> <!-- ./id field -->

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-9">
                                    <label for="name">{{ __('gennix.model_user.details_name')}}</label>
                                    <input type="text" class="form-control" id="name" name="name" readonly value="{{ $user->name }}">
                                </div> <!-- ./name field -->
                            </div> <!-- ./row -->

                            <div class="row">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} col-md-6">
                                    <label for="password">{{ __('gennix.model_user.new_password')}}</label>
                                    <input type="password" class="form-control" id="password" name="password">

                                    @if($errors->has('password'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('password') }}
                                    </small>
                                    @endif
                                </div> <!-- ./password field -->

                                <div class="form-group {{ $errors->has('retype_password') ? 'has-error' : '' }} col-md-6">
                                    <label for="retype_password">{{ __('gennix.model_user.retype_password')}}</label>
                                    <input type="password" class="form-control" id="retype_password" name="retype_password">

                                    @if($errors->has('retype_password'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('retype_password') }}
                                    </small>
                                    @endif
                                </div> <!-- ./password field -->

                            </div> <!-- ./row -->
                        </div> <!-- ./col-md-10 -->
                    </div> <!-- ./row -->
                </div> <!-- ./card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('user.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left"></i> {{ __("gennix.back") }}
                        </a>
                    </div>

                    <div class="float-right">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ __("gennix.save") }}
                        </button>
                    </div>
                </div> <!-- ./card-footer-->
            </div> <!-- ./card -->
        </div> <!-- ./col-md-12-->
    </div> <!-- ./row -->
</form>
@stop



@section('adminlte_css_pre')
@stop

@section('css')
<style>
    .div-avatar {
        position: relative;
        overflow: hidden;
    }

    .input-avatar {
        position: absolute;
        font-size: 20px;
        opacity: 0;
        right: 0;
        top: 0;
    }
</style>
@stop

@section('js')
@stop
