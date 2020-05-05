<div class="sidebar">
    <div class="sidebar-menu">
        <h2 class="mt-5 col-12">Dashboard</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('/') ? ' active' : '' }}" href="{{ route('home') }}"><i class="fas fa-home"></i><span class="ml-3">Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('admin/users/*/edit') ? ' active' : '' }}" href="{{ route('admin.users.edit', Auth::user()->id ) }}"><i class="fas fa-user-alt"></i><span class="ml-3">Profile</span></a>
            </li>
            @role('Administrator')
            <li class="nav-item">
                <a class="nav-link{{ Request::is('admin/users') ? ' active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span class="ml-3">Users</span></a>
            </li>
            <h2 class="mt-5 col-12">Roles&Permissions</h2>
            
            <li class="nav-item">
                <a class="nav-link pl-5{{ Request::is('admin/roles') ? ' active' : '' }}" href="{{ route('admin.roles.index') }}"><i class="fas fa-user-tag"></i><span class="ml-3">Roles</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link pl-5{{ Request::is('admin/permissions') ? ' active' : '' }}" href="{{ route('admin.permissions.index') }}"><i class="fas fa-user-lock"></i><span class="ml-3">Permissions</span></a>
            </li>
            @endrole
        </ul>
    </div>
</div>