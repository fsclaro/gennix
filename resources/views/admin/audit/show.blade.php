@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-user-tag"></i> {{ __('gennix.model_audit.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('audit_show') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_audit.details_id') }}</label><br>
                        <input type="text" class="form-control text-right bg-red" readonly id="id" value="{{ $audit->id }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="user">{{ __('gennix.model_audit.details_user') }}</label><br>
                        <input type="text" class="form-control" readonly id="user" value="{{ $audit->getCauser($audit->causer_id, $audit->causer_type, 'name') }}">
                    </div>

                    @php
                        if ($audit->description == 'created') {
                            $color = 'success';
                            $description = __('gennix.model_audit.operation_created');
                        } elseif ($audit->description == 'updated') {
                            $color = 'warning';
                            $description = __('gennix.model_audit.operation_updated');
                        } else {
                            $color = 'danger';
                            $description = __('gennix.model_audit.operation_deleted');
                        }
                    @endphp

                    <div class="form-group col-md-4">
                        <label for="description">{{ __('gennix.model_audit.details_operation') }}</label><br>
                        <input type="text" class="form-control bg-{{ $color}}" readonly id="description" value="{{ $description }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="subject_id">{{ __('gennix.model_audit.details_model_id') }}</label><br>
                        <input type="text" class="form-control text-right" readonly id="subject_id" value="{{ $audit->subject_id }}">
                    </div>

                    <div class="form-group col-md-7">
                        <label for="model_type">{{ __('gennix.model_audit.details_model') }}</label><br>
                        <input type="text" class="form-control" readonly id="model_type" value="{{ $audit->subject_type }}">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="created_at">{{ __('gennix.model_audit.details_created_at') }}</label><br>
                        @if($audit->created_at)
                        <input type="text" class="form-control" readonly id="created_at" value="{{ $audit->created_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="created_at">
                        @endif
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="properties">{{  __('gennix.model_audit.details_properties')}}</label>
                        <textarea id="properties" class="form-control" readonly>{{ $audit->prettyPrint($properties) }}</textarea>
                    </div>
                </div> <!-- ./row -->
            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('audit.index') }}" class="btn btn-default">
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
<link rel="stylesheet" href="{{ asset('/vendor/summernote/summernote-bs4.min.css') }}">
@stop


@section('js')
<script src="{{ asset('/vendor/summernote/summernote-bs4.min.js') }}"></script>

@if (app()->getLocale() != 'en')
<script src="{{ asset('') . '/vendor/summernote/lang/summernote-' . app()->getLocale() . '.min.js' }}"></script>
@endif

<script>
    $(function() {
        $('#properties').summernote({toolbar: []});
        $('#properties').summernote('disable', true);
    });
</script>
@stop
