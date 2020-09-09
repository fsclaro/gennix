@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
<span style="font-size:20px">
    <i class="fa fa-bullhorn"></i> {{ __('gennix.model_notification.view_title') }}
</span>

<div class="float-right">
    {{ Breadcrumbs::render('notification_show') }}
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline shadow">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_notification.details_id') }}</label><br>
                        <input type="text" class="form-control text-right" readonly id="id" value="{{ $notification->id }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="id">{{ __('gennix.model_notification.details_user_name_from') }}</label><br>
                        <input type="text" class="form-control" readonly id="user_id" value="{{ App\User::find($notification->user_id)->name  }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="id">{{ __('gennix.model_notification.details_user_name_to') }}</label><br>
                        <input type="text" class="form-control" readonly id="user_id" value="{{ App\User::find($notification->user_id_to)->name  }}">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="id">{{ __('gennix.model_notification.details_notification_type') }}</label><br>
                        <input type="text" class="form-control bg-{{ $notification->notification_type }}" readonly id="notification_type" value="{{ $notification->notification_type  }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id">{{ __('gennix.model_notification.subject') }}</label><br>
                        <input type="text" class="form-control" readonly id="subject" value="{{ $notification->subject }}">
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="id">{{ __('gennix.model_notification.message') }}</label><br>
                        <textarea id="message" class="form-control" readonly rows="5" wrap="soft">
{!! $notification->message !!}
                        </textarea>
                    </div>
                </div> <!-- ./row -->

                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="created_at">{{ __('gennix.model_notification.details_created_at') }}</label><br>
                        @if($notification->created_at)
                        <input type="text" class="form-control" readonly id="created_at" value="{{ $notification->created_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="created_at" value="">
                        @endif
                    </div>

                    <div class="form-group col-md-3">
                        <label for="updated_at">{{ __('gennix.model_notification.details_updated_at') }}</label><br>
                        @if($notification->updated_at)
                        <input type="text" class="form-control" readonly id="updated_at" value="{{ $notification->updated_at->format(env('DATE_FORMAT_LONG')) }}">
                        @else
                        <input type="text" class="form-control" readonly id="updated_at" value="">
                        @endif
                    </div>

                </div> <!-- ./row -->
            </div> <!-- ./card-body -->

            <div class="card-footer">
                <a href="{{ route('notification.index') }}" class="btn btn-default">
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
@stop

@section('js')
@stop
