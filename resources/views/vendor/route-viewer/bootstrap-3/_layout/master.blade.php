<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RouteViewer - @lang('Created by ARCANEDEV')</title>
    <meta name="description" content="Routes Viewer package for Laravel">
    <meta name="author" content="ARCANEDEV">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
        }

        .navbar-static-top {
            margin-bottom: 19px;
        }

        .label.label-inverse {
            background-color: #2D2D2D;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@include('route-viewer::bootstrap-3._layout.navigation')

<div class="container-fluid">
    @yield('content')
</div>
</body>
</html>
