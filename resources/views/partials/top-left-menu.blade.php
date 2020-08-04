    <li class="nav-item">
        <a  href="{{ route('home') }}" class="nav-link">
            Dashboard
        </a>
    </li>

    @can('contacts-access')
    <li class="nav-item">
        <a  href="{{ route('contact.index') }}" class="nav-link">
            {{ __('gennix.menu_left.contacts') }}
        </a>
    </li>
    @endcan
