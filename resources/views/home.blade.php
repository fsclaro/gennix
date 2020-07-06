@extends('adminlte::page')

@section('title', 'gennix')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">{{ __('adminlte::menu.you_are_logged') }} <i class="far fa-laugh-beam"></i></p>
                </div>
            </div>
        </div>
    </div>
@stop
