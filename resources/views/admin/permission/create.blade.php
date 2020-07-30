@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-key"></i> {{ __('gennix.model_permission.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('permission_create') }}
</div>
@stop

@section('content')
<form method="post" action="{{ route('permission.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} col-md-12">
                            <label for="title">{{ __('gennix.model_permission.details_title')}}</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : '' }}" onblur="sluggenerate();">

                            @if($errors->has('title'))
                            <small class="form-text text-red text-bold">
                                {{ $errors->first('title') }}
                            </small>
                            @endif
                        </div>
                    </div> <!-- ./row -->

                    <div class="row">
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }} col-md-12">
                            <label for="slug">{{ __('gennix.model_permission.slug') }}
                                <small class="text-red">(preview)</small>
                            </label><br>
                            <input type="text" class="form-control" id="slug" name="slug" readonly>

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
<script>

function sluggenerate() {
    var title = document.getElementById('title').value;

    if (title != '') {
        var slug = slugify(title);
        document.getElementById('slug').value = slug;
    }
}

function slugify(text) {
  return text
    .toString()                 // Cast to string
    .toLowerCase()              // Convert the string to lowercase letters
    .normalize('NFD')           // The normalize() method returns the Unicode Normalization Form of a given string.
    .trim()                     // Remove whitespace from both sides of a string
    .replace(/\s+/g, '-')       // Replace spaces with -
    .replace(/[^\w\-]+/g, '')   // Remove all non-word chars
    .replace(/\-\-+/g, '-');    // Replace multiple - with single -
}
</script>
@stop
