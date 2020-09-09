<?php

$notificationsTo = App\Notification::where('user_id_to', Auth::user()->id)
    ->where('is_read', false)
    ->orderBy('created_at', 'desc')
    ->get();
$nroNotifications = count($notificationsTo);

?>


<!-- comment icon -->
<!-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
    </a>
</li> -->


<!-- notification icon -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        @if ($nroNotifications >= 1)
        <span class="badge badge-success navbar-badge">
            @if ($nroNotifications >=1 && $nroNotifications <= 15)
            {{ $nroNotifications }}
            @elseif($nroNotifications> 15)
                15+
            @endif
        </span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <span class="dropdown-item dropdown-header">
            @if ($nroNotifications <= 0)
            {{ __('gennix.model_notification.you_dont_have_notifications') }}
            @elseif ($nroNotifications==1)
            {{ __('gennix.model_notification.you_have_one_notification') }}
            @else
            {{ __('gennix.model_notification.you_have_notifications', ['number' => $nroNotifications]) }}
            @endif
        </span>

        @foreach($notificationsTo as $n)
        <div class="dropdown-divider"></div>
        <a href="{{ route('notification.show', $n->id) }}" class="dropdown-item">
            <div class="row">
                <div class="col-sm-2">
                    <img src="{{ App\User::find($n->user_id)->adminlte_image() }}"
                        class="img-circle elevation-2" width="36px">

                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <small class="col-sm-6">
                            {{ Str::limit(App\User::find($n->user_id)->name,18) }}
                        </small>
                        <small class="col-sm-6 text-right text-red">
                            @if ($n->created_at)
                            <small>{{ $n->created_at->format(env("DATE_FORMAT") . " H:i") }}</small>
                            @endif
                        </small>
                    </div>
                    <div class="row">
                        <small class="col-sm-12 text-muted">
                            @if ($n->notification_type == "info")
                            <i class="fas fa-info-circle text-blue"></i>
                            @elseif ($n->notification_type == "danger")
                            <i class="fas fa-exclamation-triangle text-red"></i>
                            @else
                            <i class="fas fa-bullhorn"></i>
                            @endif
                            {{ Str::limit($n->subject,28) }}
                        </small>
                    </div>
                </div>
            </div>
        </a>
        @endforeach

        <div class="dropdown-divider"></div>
        <a href="{{ route('notification.index') }}" class="dropdown-item dropdown-footer">{{ __('gennix.model_notification.show_all_notifications') }}</a>
    </div>
</li>


@if (env('MULTI_LANGUAGE'))
<!-- language icon -->
<li class="nav-item dropdown">
    <a class="nav-link"
       data-toggle="dropdown"
       href="#"
       aria-expanded="false">
        <img src="{{ asset('img/flags/' . app()->getLocale() . '.png') }}"
             class="user-image img-circle mb-4"
             width="20px">
    </a>

    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
        <a href="{{ route('language', 'pt-BR') }}"
           class="dropdown-item">
            <img src="{{ asset('img/flags/pt-BR.png') }}"
                 width="20px"> Brazilian Portuguese
        </a>
        <a href="{{ route('language', 'en') }}"
           class="dropdown-item">
            <img src="{{ asset('img/flags/en.png') }}"
                 width="20px"> English
        </a>
    </div>
</li>
@endif
