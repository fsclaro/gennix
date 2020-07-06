<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">RouteViewer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="@lang('Toggle navigation')">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a href="/" class="nav-item nav-link">@lang('Home')</a>
            <a href="{{ route('route-viewer::index') }}" class="nav-item nav-link active">
                @lang('Routes') <span class="sr-only">(current)</span>
            </a>
        </div>
    </div>
</nav>
