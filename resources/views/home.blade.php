@extends('adminlte::page')

@section('title', env('APP_NAME'))

@section('content_header')
    <span style="font-size:20px">
        <i class="fa fa-tachometer-alt"></i>
        {{ __('gennix.dashboard.view_title') }}
    </span>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert bg-indigo shadow" role="alert">
                <h4 class="alert-heading">
                    {{ __('gennix.dashboard.view_wellcome') }}
                </h4>
                <hr>
                <p>
                    {{ __('gennix.dashboard.view_hello') . Auth::user()->firstName() }}.
                    {{ __('gennix.today_is') }}
                    {{  App\Helper\GennixHelper::dateFullFormat() }} -
                    <span id="timer"></span>
                </p>
            </div> <!-- ./alert -->
        </div> <!-- ./col-12 -->
    </div> <!-- ./row -->

    @if(Auth::user()->is_superadmin)
        <div class="row">
            @widget('UsersActives')
            @widget('Permissions')
            @widget('Roles')
            @widget('ActivitiesErrors')
        </div>
    @endif
@stop

@section('js')
<script>
window.onload = function() {
    setInterval(function() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();

        h = checkTime(h);
        m = checkTime(m);
        s = checkTime(s);

        document.getElementById("timer").innerHTML = h + ":" + m + ":" + s;
    }, 500);
}

function checkTime(i)
{
    if (i < 10)
    {
        i = "0" + i;
    }

    return i;
}
</script>

@stop

@section('css')
<style>
.alert-bg {
    background-color: #009EC4;
    color: white;
}
</style>
@stop
