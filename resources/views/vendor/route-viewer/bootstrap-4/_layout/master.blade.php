<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>RouteViewer - @lang('Created by ARCANEDEV')</title>
    <meta name="description" content="Routes Viewer package for Laravel">
    <meta name="author" content="ARCANEDEV">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
        }

        .badge.badge-inverse {
            background-color: #2D2D2D;
            color: #fff;
        }
    </style>
</head>
<body>
    @include('route-viewer::bootstrap-4._layout.navigation')

    <div class="container-fluid">
        @yield('content')
    </div>
</body>
</html>
