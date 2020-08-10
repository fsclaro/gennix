@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ??
config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
@stack('css')
@yield('css')

<style type="text/css">
.facebook-color {
    background-color: #1877f2;
    color: white;
}

.facebook-color:hover {
    background-color: #3B5998;
    color: white;
}

.twitter-color {
    background-color: #187bb9;
    color: #fff;
}

.twitter-color:hover {
    background-color: #00aced;
    color: white;
}

.github-color {
    background-color: rgb(95, 95, 95);
    color: #fff;
}

.github-color:hover {
    background-color: #000;
    color: white;
}

.linkedin-color {
    background-color: #1791ca;
    color: #fff;
}

.linkedin-color:hover {
    background-color: #007bb6;
    color: white;
}

.google-color {
    background-color: #ff0000;
    color: #fff;
}

.google-color:hover {
    background-color: #dd4b39;
    color: white;
}

.background {
    background-image: url('{{ asset("img/background/background01.jpg") }}');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
}

@if (env('MULTI_LANGUAGE'))
.selectLanguage {
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0.2rem;
}

.selectLanguage  a:first-child {
    margin-right: 0.5rem;
}
@endif

</style>
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page background' }}@stop

@section('body')
<div class="{{ $auth_type ?? 'login' }}-box">

    {{-- Card Box --}}
    <div
         class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">

        {{-- Logo --}}
        <div class="{{ $auth_type ?? 'login' }}-logo"
             style="margin-top:10px;">
            <a href="{{ $dashboard_url }}">
                <img src="{{ asset(config('adminlte.logo_img')) }}" height="50">
                {!! config('adminlte.logo', 'gennix') !!}
            </a>
        </div>

        @if (env('MULTI_LANGUAGE'))
        <div class="selectLanguage">
            <a href="{{ route('language', 'pt-BR') }}">
                <img src="{{ asset('img/flags/pt-BR.png') }}" width="35px" alt="Brazilian Portuguese">
            </a>

            <a href="{{ route('language', 'en') }}">
                <img src="{{ asset('img/flags/en.png') }}" width="35px" alt="English">
            </a>
        </div>
        @endif

        {{-- Card Header --}}
        @hasSection('auth_header')
        <div
             class="card-header {{ config('adminlte.classes_auth_header', '') }}">

            <h3 class="card-title float-none text-center">
                @yield('auth_header')
            </h3>
        </div>
        @endif

        {{-- Card Body --}}
        <div
             class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
            @yield('auth_body')
        </div>

        {{-- Card Footer --}}
        @hasSection('auth_footer')
        <div
             class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
            @yield('auth_footer')
        </div>
        @endif

    </div>
</div>
@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop
