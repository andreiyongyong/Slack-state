<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image"> 
            <img src="{{ asset ("/image/".Auth::user()->image) }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}</div>
            <div class="email">{{ Auth::user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li> 
                    <li role="seperator" class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i>Sign Out</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">NAVIGATION</li>
            <li class="active">
                <a href="{{ url('member-log') }}">
                    <i class="material-icons">assignment</i>
                    <span>Projects</span>
                </a>
            </li> 
            </li>  
            <li>
                <a href="{{ url('member-log') }}">
                    <i class="material-icons">assignment</i>
                    <span>Resource Management</span>
                </a>
            </li>  
            <li>
                <a href="{{ route('user-management.index') }}">
                    <i class="material-icons">assignment</i>
                    <span>User Management</span>
                </a>
            </li>  
        </ul>
    </div> 
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; 2018 - 2018 <a href="javascript:void(0);">SQ Tec</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.5
        </div>
    </div>
    <!-- #Footer -->
</aside>