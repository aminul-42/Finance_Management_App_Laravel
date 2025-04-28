<div class="sidebar" id="sidebar" data-collapsed="false">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link" id="toggle-sidebar">
                <i class="bi bi-list"></i><span>Toggle Sidebar</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i><span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.installments.index') }}"
               class="nav-link {{ Route::is('user.installments.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i><span>Contributions</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('user.profile') }}" class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><span>Profile</span>
            </a>
        </li>
      
        <li class="nav-item">
            <a href="{{ route('user.logout') }}" class="nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>