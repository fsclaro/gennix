@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-key"></i> {{ __('gennix.model_permission.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('permission_edit') }}
</div>
@stop

@section('content')
<form method="post" action="{{ route('permission.update', $permission) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="title">{{ __('gennix.model_permission.details_id')}}</label>
                            <input type="text" class="form-control text-right" id="id" name="id"
                                value="{{ $permission->id }}" readonly>
                        </div>

                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-10">
                            <label for="title">{{ __('gennix.model_permission.details_title')}}</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title') ? old('title') : $permission->title }}">

                            @if($errors->has('title'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('title') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- ./row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }} col-md-12">
                            <label for="slug">{{ __('gennix.model_permission.slug') }}</label>
                            <br>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $permission->slug }}">

                            @if($errors->has('slug'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('slug') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- ./row -->
                </div> <!-- ./card-body -->

                <div class="card-footer">
                    <div class="float-left">
                        <a href="{{ route('permission.index') }}" class="btn btn-default">
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
        </div> <!-- ./col-md-12 -->
    </div> <!-- ./row -->
</form>
@stop



@section('adminlte_css_pre')
@stop

@section('css')
@stop

@section('js')
@stop
