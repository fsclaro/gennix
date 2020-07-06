<?php /** @var  Arcanedev\RouteViewer\Entities\RouteCollection  $routes */ ?>

@extends('route-viewer::bootstrap-4._layout.master')

@section('content')
    <div class="card my-4 shadow-sm">
        <div class="card-header">
            @lang('Routes') <small class="text-muted">(@lang(':count registered', ['count' => $routes->count()]))</small>
        </div>
        <table class="table table-condensed table-hover mb-0">
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
                            <span class="badge badge-{{ $method['color'] }}">{{ $method['name'] }}</span>
                        @endforeach
                    </td>
                    <td>
                        <small>{!! preg_replace('#({[^}]+})#', '<span class="text-danger">$1</span>', $route->uri) !!}<br></small>
                        @if ($route->domain)
                            {{ $route->domain }}
                        @else
                            <span class="badge badge-secondary">--</span>
                        @endif
                    </td>
                    <td>
                        <b>N: </b>
                        @if ($route->hasName())
                            <span class="badge badge-primary">{{ $route->name }}</span>
                        @else
                            <span class="badge badge-secondary">--</span>
                        @endif

                        <br>

                        <b>A: </b>
                        @if ($route->isClosure())
                            <span class="badge badge-secondary">{{ $route->action }}</span>
                        @else
                            <small>{!! preg_replace('#(@.*)$#', '<span class="text-success">$1</span>', $route->action) !!}</small>
                        @endif
                    </td>
                    <td>
                        @foreach($route->middleware as $middleware)
                            <span class="badge badge-inverse">{{ $middleware }}</span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
