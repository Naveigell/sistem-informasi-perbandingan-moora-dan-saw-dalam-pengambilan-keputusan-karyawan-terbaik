
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Cuti</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">Ct</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Users</li>
            <li class="@if (request()->routeIs('admin.employees.*')) active @endif"><a class="nav-link" href="{{ route('admin.employees.index') }}"><i class="fas fa-users"></i> <span>Karyawan</span></a></li>
            <li class="menu-header">Calculation</li>
            <li class="@if (request()->routeIs('admin.calculations.*')) active @endif"><a class="nav-link" href="{{ route('admin.calculations.index') }}"><i class="fas fa-trophy"></i> <span>Perhitungan</span></a></li>
        </ul>
    </aside>
</div>
