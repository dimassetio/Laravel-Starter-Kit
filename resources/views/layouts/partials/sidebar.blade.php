<div class="navbar-default sidebar hidden-print" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
        @can('manage_users')
        <li><a href="{{ route('users.index') }}"><i class="fa fa-users fa-fw"></i> {{ trans('user.users') }}</a></li>
        <li><a href="{{ route('roles.index') }}"><i class="fa fa-roles fa-fw"></i> {{ trans('role.roles') }}</a></li>
        <li><a href="{{ route('permissions.index') }}"><i class="fa fa-permissions fa-fw"></i> {{ trans('permission.permissions') }}</a></li>
        @endcan
        @can('manage_backups')
        <li><a href="{{ route('backups.index') }}"><i class="fa fa-refresh fa-fw"></i> Backup/Restore Database</a></li>
        @endcan
        @can('manage_options')
        <li><a href="{{ route('options.index') }}"><i class="fa fa-gears fa-fw"></i> Options</a></li>
        @endcan
        <li><a href="{{ route('auth.change-password') }}"><i class="fa fa-lock fa-fw"></i> {{ trans('auth.change_password') }}</a></li>
        <li><a href="{{ route('auth.logout') }}"><i class="fa fa-sign-out fa-fw"></i> {{ trans('auth.logout') }}</a></li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->

