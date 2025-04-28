<div class="sidebar" id="sidebar" data-collapsed="false">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="#" class="nav-link" id="toggle-sidebar">
                <i class="bi bi-list"></i><span>Toggle Sidebar</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i><span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.profile') }}" class="nav-link {{ Route::is('admin.profile') ? 'active' : '' }}">
                <i class="bi bi-person"></i><span>Profile Settings</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.overview') }}" class="nav-link {{ Route::is('admin.users.overview') ? 'active' : '' }}">
                <i class="bi bi-people"></i><span>Users Overview</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.contributions.index') }}" class="nav-link {{ Route::is('admin.contributions.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i><span>Contributions</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.profits.index') }}" class="nav-link {{ Route::is('admin.profits.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i><span>Profits</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.logout') }}" class="nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>