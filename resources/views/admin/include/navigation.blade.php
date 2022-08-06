<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img src="" onerror="this.src='{{ url('assets/admin/images/default.jpg') }}'"
                        class="rounded-circle bg-light" style="width: 48px;height: 48px; object-fit: contain;" />
                    <a data-bs-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::guard('admin')->user()->name }}</strong>
                            </span>
                            <span
                                class="text-muted text-xs block">{{Auth::guard('admin')->user()->getRoleNames()->first()}}
                                <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('admin::password.change') }}">Change Password</a></li>
                        <li><a href="{{ route('admin::logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">LS</div>
            </li>
            <li class="{{ isActiveRoute('admin::dashboard.index') }}">
                <a href="{{ url(config('settings.ADMIN_PREFIX').'dashboard') }}"><i class="fa fa-dashboard"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>
            @role('super_admin')
            <li
                class="{{ isActiveRoute(['roles.index','roles.create','roles.edit','permission.index','permission.create','permission.edit','role-permission.index','role-permission.edit']) }}">
                <a href="javascript:;">
                    <i class="fa fa-cog"></i>
                    <span class="nav-label">Settings</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li class="{{ isActiveRoute(['roles.index','roles.create','roles.edit']) }}">
                        <a href="{{ url(config('settings.ADMIN_PREFIX').'rightsmanagement/roles') }}"><i
                                class="fa fa-tasks"></i>
                            Roles</a>
                    </li>
                    <li class="{{ isActiveRoute(['permission.index','permission.create','permission.edit']) }}">
                        <a href="{{ url(config('settings.ADMIN_PREFIX').'rightsmanagement/permission') }}"><i
                                class="fa fa-lock"></i>
                            Permission</a>
                    </li>
                    <li class="{{ isActiveRoute(['role-permission.index','role-permission.edit']) }}">
                        <a href="{{ url(config('settings.ADMIN_PREFIX').'rightsmanagement/role-permission') }}"><i
                                class="fa fa-address-book-o"></i> Role
                            Permission</a>
                    </li>
                </ul>
            </li>
            @endrole
            @role('super_admin')
            @can('admin_view')
            <li class="{{ isActiveRoute(['admin::admins.index', 'admin::admins.create', 'admin::admins.edit']) }}">
                <a href="{{ url(config('settings.ADMIN_PREFIX').'admins') }}"><i class="fa fa-user-secret"
                        aria-hidden="true"></i><span class="nav-label">Admins</span></a>
            </li>
            @endcan
            @endrole
            @can('user_view')
            <li class="{{ isActiveRoute(['admin::users.index', 'admin::users.create', 'admin::users.edit']) }}">
                <a href="{{ url(config('settings.ADMIN_PREFIX').'users') }}"><i class="fa fa-users"
                        aria-hidden="true"></i><span class="nav-label">Users</span></a>
            </li>
            @endcan
            @can('user_view')
            <li class="{{ isActiveRoute(['admin::users.index', 'admin::users.create', 'admin::users.edit']) }}">
                <a href="{{ url(config('settings.ADMIN_PREFIX').'users') }}"><i class="fa fa-users"
                        aria-hidden="true"></i><span class="nav-label">Users</span></a>
            </li>
            @endcan
        </ul>
    </div>
</nav>
