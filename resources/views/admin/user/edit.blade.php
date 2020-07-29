@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-users"></i> {{ __('gennix.model_user.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('user_edit') }}
</div>
@stop

@section('content')
<form method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{ $user->id }}">

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 border-right border-light">
                            <div class="text-center">
                                <label for="avatar">{{ __('gennix.model_user.avatar') }} <small class="text-red text-bold">{{ __('gennix.optional') }}</small></label><br/>
                                <div class="image-text-center">
                                    <img src="{{ $user->getAvatar($user->id) }}" id="img-avatar" name="img-avatar"
                                    class="profile-user-image img-fluid img-circle img-bordered-sm shadow" width="140px">
                                </div>

                                <div class="row">&nbsp;</div>

                                <div class="btn btn-primary div-avatar">
                                    <input type="file" id="avatar" name="avatar" class="input-avatar" onchange="changeAvatar(event);">
                                    <span><i class="fas fa-upload"></i> {{ __('gennix.model_user.new_photo') }}</span>
                                </div>
                                <br>
                                <small class="text-muted">{{ __('gennix.model_user.avatar_format') }}</small>
                            </div> <!-- ./text-center-->
                        </div> <!-- ./col-md-2 -->

                        <div class="col-md-10">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="id">{{ __('gennix.model_user.details_id') }}</label><br>
                                    <input type="text" class="form-control text-right" readonly id="id" value="{{ $user->id }}">
                                </div> <!-- ./id field -->

                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-md-7">
                                    <label for="name">{{ __('gennix.model_user.details_name')}}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $user->name }}">

                                    @if($errors->has('name'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('name') }}
                                    </small>
                                    @endif
                                </div> <!-- ./name field -->

                                <div class="form-group col-md-2">
                                    <label for="active">{{ __('gennix.model_user.active') }}</label>
                                    <select name="active" id="active" class="form-control select2" style="width: 100%">
                                        <option value=0 @if ($user->active==0) selected @endif>{{ __('gennix.no') }}</option>
                                        <option value=1 @if ($user->active==1) selected @endif>{{ __('gennix.yes') }}</option>
                                    </select>

                                    @if($errors->has('active'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('active') }}
                                    </small>
                                    @endif
                                </div> <!-- ./active field -->

                            </div> <!-- ./row -->

                            <div class="row">
                                <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }} col-md-4">
                                    <label for="position">{{ __('gennix.model_user.details_position')}}</label>
                                    <input type="text" class="form-control" id="position" name="position" value="{{ old('position') ? old('position') : $user->position }}">

                                    @if($errors->has('position'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('position') }}
                                    </small>
                                    @endif
                                </div> <!-- ./position field -->

                                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }} col-md-5">
                                    <label for="email">{{ __('gennix.model_user.details_email')}}</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : $user->email }}">

                                    @if($errors->has('email'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('email') }}
                                    </small>
                                    @endif
                                </div> <!-- ./email field -->

                                <div class="form-group col-md-3">
                                    <label for="gender">{{ __('gennix.model_user.details_gender') }}</label>
                                    <select name="gender" id="gender" class="form-control select2" style="width: 100%">
                                        <option value='M' @if ($user->gender=='M') selected @endif>{{ __('gennix.model_user.details_gender_male') }}</option>
                                        <option value='F' @if ($user->gender=='F') selected @endif>{{ __('gennix.model_user.details_gender_femme') }}</option>
                                        <option value='N' @if ($user->gender=='N') selected @endif>{{ __('gennix.model_user.details_gender_undefined') }}</option>
                                    </select>

                                    @if($errors->has('gender'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('gender') }}
                                    </small>
                                    @endif
                                </div> <!-- ./gender field -->
                            </div> <!-- ./row -->

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="is_superadmin">{{ __('gennix.model_user.is_superadmin') }}</label>
                                    <select name="is_superadmin" id="is_superadmin" class="form-control select2" style="width: 100%" onchange="selectRole();">
                                        <option value=0 @if ($user->is_superadmin==0) selected @endif>{{ __('gennix.no') }}</option>
                                        <option value=1 @if ($user->is_superadmin==1) selected @endif>{{ __('gennix.yes') }}</option>
                                    </select>

                                    @if($errors->has('is_superadmin'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('is_superadmin') }}
                                    </small>
                                    @endif
                                </div> <!-- ./is_superadmin field -->

                                <div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }} col-md-5">
                                    <label for="roles">{{ __('gennix.model_user.role') }}</label>
                                    <select name="roles" id="roles" class="form-control select2" style="width: 100%" @if ($user->is_superadmin) disabled @endif>
                                        @foreach($roles as $id => $role)
                                        <option value="{{ $id }}" {{ (in_array($id, old('role', [])) || isset($user) && $user->roles->contains($id)) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if($errors->has('roles'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('roles') }}
                                    </small>
                                    @endif
                                </div> <!-- ./roles field -->

                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} col-md-5">
                                    <label for="password">{{ __('gennix.model_user.details_password')}}</label>
                                    <input type="password" class="form-control" id="password" name="password">

                                    @if($errors->has('password'))
                                    <small class="form-text text-red text-bold">
                                        {{ $errors->first('password') }}
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
                            <i class="fas fa-arrow-circle-left"> {{ __("gennix.back") }}</i>
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
<script>
    $(function() {
        $("#roles").select2();
        $("#active").select2();
        $("#is_superadmin").select2();
        $("#gender").select2();
    });

    function selectRole() {
        var isSuperadmin = document.getElementById('is_superadmin');
        var optionValue = isSuperadmin.options[isSuperadmin.selectedIndex].value;

        if (optionValue == 1) {
            document.getElementById('roles').disabled = true;
        } else {
            document.getElementById('roles').disabled = false;
        }
    }

    function changeAvatar(e) {
        var selectedFile = e.target.files[0];
        var reader = new FileReader();
        var imgTag = document.getElementById("img-avatar");

        imgTag.title = selectedFile.name;

        reader.onload = function(e) {
            imgTag.src = e.target.result;
        }
        reader.readAsDataURL(selectedFile);
    }
</script>
@stop
