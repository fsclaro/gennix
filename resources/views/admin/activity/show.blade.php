@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-clipboard-check"></i> {{ __('gennix.model_activity.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('activity_show') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-body">

                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_activity.details_id') }}</label><br>
                        <input type="text" class="form-control text-right" readonly id="id" value="{{ $activity->id }}">
                    </div>
                    <div class="form-group col">
                        <label for="username">{{ __('gennix.model_activity.details_username')}}</label>
                        <input type="text" class="form-control" readonly id="username" value="{{ $activity->user->name }}">
                    </div>
                    <div class="col-md-2">
                        <label for="is_read">{{ __('gennix.model_activity.details_isread') }}</label>
                        @if ($activity->is_read)
                        <input type="text" class="form-control bg-primary" readonly id="is_read" value="{{ __('gennix.yes') }}">
                        @else
                        <input type="text" class="form-control bg-danger" readonly id="is_read" value="{{ __('gennix.no') }}">
                        @endif
                    </div>

                    <div class="col-md-2">
                        <label for="type">{{ __('gennix.model_activity.details_type') }}</label>
                        @if ($activity->type == 'success')
                        <input type="text" class="form-control bg-success" readonly id="type" value="{{ __('gennix.model_activity.success') }}">
                        @elseif ($activity->type == 'error')
                        <input type="text" class="form-control bg-danger" readonly id="type" value="{{ __('gennix.model_activity.error') }}">
                        @elseif ($activity->type == 'info')
                        <input type="text" class="form-control bg-info" readonly id="type" value="{{ __('gennix.model_activity.info') }}">
                        @elseif ($activity->type == 'warning')
                        <input type="text" class="form-control bg-warning" readonly id="type" value="{{ __('gennix.model_activity.warning') }}">
                        @else
                        <input type="text" class="form-control bg-secondary" readonly id="type" value="{{ __('gennix.model_activity.undefined') }}">
                        @endif
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="url">{{ __('gennix.model_activity.details_url') }}</label><br>
                        <input type="text" class="form-control" readonly id="url" value="{{ $activity->url }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="useragent">{{ __('gennix.model_activity.details_useragent') }}</label><br>
                        <textarea id="useragent" readonly wrap rows="2" class="form-control">{{ $activity->useragent }}</textarea>
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="title">{{ __('gennix.model_activity.details_title') }}</label><br>
                        <textarea id="title" readonly wrap rows="2" class="form-control"">{{ $activity->title }}</textarea>
                    </div>
                </div> <!-- ./row -->

                @if($activity->details)
                <div class="row">
                    <div class="form-group col-md-12" contenteditable="true">
                        <label for="details">{{ __('gennix.model_activity.details_details') }}</label><br>
                        <textarea id="details" name="details" readonly wrap rows="4" class="form-control">{!! $activity->details !!}</textarea>
                    </div>
                </div> <!-- ./row -->
                @endif

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="ipaddress">{{ __('gennix.model_activity.details_ipaddress') }}</label><br>
                        @if ($activity->ipaddress)
                        <input type="text" class="form-control" readonly id="ipaddress" value="{{ $activity->ipaddress }}">
                        @else
                        <input type="text" class="form-control text-red" readonly id="ipaddress" value="{{ __('gennix.undefined') }}">
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="externalip">{{ __('gennix.model_activity.details_externalip') }}</label><br>
                        @if ($activity->externalip)
                        <input type="text" class="form-control" readonly id="externalip" value="{{ $activity->externalip }}">
                        @else
                        <input type="text" class="form-control text-red" readonly id="externalip" value="{{ __('gennix.undefined') }}">
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="created_at">{{ __('gennix.model_activity.details_created_at') }}</label><br>
                        @if($activity->created_at)
                        <input type="text" class="form-control" readonly id="created_at" value="{{ $activity->created_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="created_at" value="">
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="updated_at">{{ __('gennix.model_activity.details_updated_at') }}</label><br>
                        @if($activity->updated_at)
                        <input type="text" class="form-control" readonly id="updated_at" value="{{ $activity->updated_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="updated_at" value="">
                        @endif
                    </div>
                </div> <!-- ./row -->
            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('activity.index') }}" class="btn btn-default"><i class="fas fa-arrow-circle-left"> {{ __("gennix.back") }}</i></a>
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
<script>
    $(function() {
        $('#details').summernote({toolbar: []});
        $('#details').summernote('disable', true);
        $summernotes.find('.note-toolbar').hide();
    });
</script>
@stop
