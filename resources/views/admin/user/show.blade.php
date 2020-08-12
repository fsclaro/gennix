@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-users"></i> {{ __('gennix.model_user.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('user_show') }}
</div>
@stop

@section('content')
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

                            <div class="form-group col-md-7">
                                <label for="name">{{ __('gennix.model_user.details_name')}}</label>
                                <input type="text" class="form-control" readonly id="name" value="{{ $user->name }}">
                            </div> <!-- ./name field -->

                            <div class="form-group col-md-2">
                                <label for="active">{{ __('gennix.model_user.details_active') }}</label><br>
                                @if($user->active)
                                <button class="btn btn-default btn-block btn-text-left" disable style="background-color: #E9ECEF">
                                    <span class="badge badge-primary text-left">{{ __('gennix.yes') }}</span>
                                </button>
                                @else
                                <button class="btn btn-default btn-block btn-text-left" disable style="background-color: #E9ECEF">
                                    <span class="badge badge-danger text-left">{{ __('gennix.no') }}</span>
                                </button>
                                @endif
                            </div> <!-- ./active field -->
                        </div> <!-- ./row -->

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="position">{{ __('gennix.model_user.details_position') }}</label><br>
                                <input type="text" class="form-control" readonly id="position" value="{{ $user->position }}">
                            </div> <!-- ./position fields -->

                            <div class="form-group col-md-5">
                                <label for="email">{{ __('gennix.model_user.details_email') }}</label><br>
                                <input type="text" class="form-control" readonly id="email" value="{{ $user->email }}">
                            </div> <!-- ./email field -->

                            <div class="form-group col-md-3">
                                <label for="gender">{{ __('gennix.model_user.details_gender') }}</label><br>
                                @if ($user->gender == 'M')
                                    <button class="btn btn-default btn-block btn-text-left" id="gender" disable style="background-color: #E9ECEF">
                                        <span class="badge badge-primary text-left">{{ __('gennix.model_user.details_gender_male') }}</span>
                                    </button>
                                @else
                                    @if ($user->gender == 'F')
                                    <button class="btn btn-default btn-block btn-text-left" id="gender" disable style="background-color: #E9ECEF">
                                        <span class="badge badge-primary text-left">{{ __('gennix.model_user.details_gender_femme') }}</span>
                                    </button>
                                    @else
                                    <button class="btn btn-default btn-block btn-text-left" id="gender"  disable style="background-color: #E9ECEF">
                                        <span class="badge badge-danger text-left">{{ __('gennix.model_user.details_gender_undefined') }}</span>
                                    </button>
                                    @endif
                                @endif
                            </div> <!-- ./gender field -->
                        </div> <!-- ./row -->

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="phone">{{ __('gennix.model_contact.details_phone') }}</label><br>
                                <input type="text" class="form-control" readonly id="phone" value="{{ $user->phone }}">
                            </div> <!-- ./email field -->

                            <div class="form-group col-md-3">
                                <label for="is_superadmin">{{ __('gennix.model_user.details_is_superadmin') }}</label><br>
                                @if ($user->is_superadmin)
                                    <button class="btn btn-default btn-block btn-text-left" id="is_superadmin" disable style="background-color: #E9ECEF">
                                        <span class="badge badge-primary text-left">{{ __('gennix.yes') }}</span>
                                    </button>
                                @else
                                    <button class="btn btn-default btn-block btn-text-left" id="is_superadmin" disable style="background-color: #E9ECEF">
                                        <span class="badge badge-danger text-left">{{ __('gennix.no') }}</span>
                                    </button>
                                @endif
                            </div> <!-- ./gender field -->

                            <div class="form-group col-md-5">
                                <label for="roles">{{ __('gennix.model_user.details_roles') }}</label>
                                <button class="btn btn-default btn-block btn-text-left" id="roles" style="background-color: #E9ECEF">
                                    @if ($user->is_superadmin)
                                        <span class="badge badge-primary text-left">{{ __('gennix.model_user.superadmin_role') }}</span>
                                    @else
                                        @foreach($user->roles as $key => $role)
                                            <span class="badge badge-primary text-left">{{ $role->title }}</span>
                                        @endforeach
                                    @endif
                                </button>
                            </div> <!-- ./roles field -->
                        </div> <!-- ./row -->

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="last_login">{{ __('gennix.model_user.details_last_login') }}</label>
                                @if($user->last_login)
                                <input type="text" class="form-control" readonly id="last_login" value="{{ $user->last_login->format(env('DATE_FORMAT_LONG')) }}">
                                @else
                                <input type="text" class="form-control" readonly id="last_login">
                                @endif
                            </div> <!-- ./roles field -->

                            <div class="form-group col-md-3">
                                <label for="created_at">{{ __('gennix.model_user.details_created_at') }}</label><br>
                                @if($user->created_at)
                                <input type="text" class="form-control" readonly id="created_at" value="{{ $user->created_at->format(env('DATE_FORMAT_LONG')) }}">
                                @else
                                <input type="text" class="form-control" readonly id="created_at">
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="updated_at">{{ __('gennix.model_user.details_updated_at') }}</label><br>
                                @if($user->updated_at)
                                <input type="text" class="form-control" readonly id="updated_at" value="{{ $user->updated_at->format(env('DATE_FORMAT_LONG')) }}">
                                @else
                                <input type="text" class="form-control" readonly id="updated_at">
                                @endif
                            </div>
                        </div> <!-- ./row -->
                    </div>
                </div>
            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('user.index') }}" class="btn btn-default">
                    <i class="fas fa-arrow-circle-left"></i> {{ __("gennix.back") }}
                </a>
            </div> <!-- ./card-footer-->
        </div> <!-- ./card -->
    </div> <!-- ./col-md-12 -->
</div> <!-- ./row -->

@stop



@section('adminlte_css_pre')
@stop

@section('css')
<style>
.btn-text-left {
    text-align: left !important;
}
</style>
@stop

@section('js')
@stop
