<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
    </a>
</li>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        <span class="badge badge-success navbar-badge">9+</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 4 new messages
        <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 8 friend requests
        <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
        <i class="fas fa-file mr-2"></i> 3 new reports
        <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-flag"></i>
    </a>

    <div class="dropdown-menu dropdown-menu dropdown-menu-right">
        <a href="{{ route('language', 'pt-BR') }}" class="dropdown-item">
            <img src="{{ asset('img/flags/brazil.png') }}" width="20px"> Brazilian Portuguese
        </a>
        <a href="{{ route('language', 'en') }}" class="dropdown-item">
            <img src="{{ asset('img/flags/united-states-of-america.png') }}" width="20px"> USA
        </a>
    </div>
</li>
