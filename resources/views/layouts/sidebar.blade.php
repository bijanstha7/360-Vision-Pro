<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" key="t-menu">Menu</li>

        <li>
            <a href="@if(Auth::user()->role_as == 1){{ route('dashboard') }}@else{{ route('user.dashboard') }}@endif" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                <span >Dashboards</span>
            </a>
        </li>
        @if(Auth::user()->role_as == 1)
        <li>
            <a href="{{ route('users.index') }}" class="waves-effect">
                <i class="fas fa-users"></i>
                <span >Total Users</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->role_as == 2)
        <li>
            <a href="{{ route('users.visulize') }}" class="waves-effect">
                <i class="fas fa-eye"></i>
                <span >visulize</span>
            </a>
        </li>
        @endif
        <li>
            <a href="#" class="waves-effect">
                <i class="bx bx-copy-alt"></i>
                <span >Total Reports</span>
            </a>
        </li>
        <li>
            <a href="@if(Auth::user()->role_as == 1){{ route('setting') }}@else{{ route('user.setting') }}@endif" class="waves-effect">
                <i class="bx bx-cog"></i>
                <span >Setting</span>
            </a>
        </li>
    </ul>
</div>