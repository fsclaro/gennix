<?php /** @var  Arcanedev\RouteViewer\Entities\RouteCollection  $routes */ ?>

@extends('route-viewer::bootstrap-3._layout.master')

@section('content')
    <div class="page-header">
        <h1>Routes <small>| {{ $routes->count() }} routes registered</small></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>@lang('Methods')</th>
                    <th>@lang('URI') / @lang('Domain')</th>
                    <th>@lang('Name') / @lang('Action')</th>
                    <th style="width: 20%;">@lang('Middleware')</th>
                </tr>
            </thead>
            @foreach ($routes as $route)
                <?php /** @var  Arcanedev\RouteViewer\Entities\Route  $route */ ?>
                <tr>
                    <td>
                        @foreach ($route->methods as $method)
                            <span class="label label-{{ $method['color'] }}">{{ $method['name'] }}</span>
                        @endforeach
                    </td>
                    <td>
                        <small>{!! preg_replace('#({[^}]+})#', '<span class="text-danger">$1</span>', $route->uri) !!}<br></small>
                        @if ($route->domain)
                            {{ $route->domain }}
                        @else
                            <span class="label label-default">--</span>
                        @endif
                    </td>
                    <td>
                        <b>N: </b>
                        @if ($route->hasName())
                            <span class="label label-primary">{{ $route->name }}</span>
                        @else
                            <span class="label label-default">--</span>
                        @endif

                        <br>

                        <b>A: </b>
                        @if ($route->isClosure())
                            <span class="label label-default">{{ $route->action }}</span>
                        @else
                            {!! preg_replace('#(@.*)$#', '<span class="text-success">$1</span>', $route->action) !!}
                        @endif
                    </td>
                    <td>
                        @foreach($route->middleware as $middleware)
                            <span class="label label-inverse">{{ $middleware }}</span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
