<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image pull-right" style = "padding-top:15px;"> 
            <img src="{{ asset ("/image/".Auth::user()->image) }}" width="90" height="90" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}</div>
            <div class="email">{{ Auth::user()->email }}</div> 
        </div> 
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                         Project
                        </a>
                    </p>
                </div>
                <div id="collapseOne" class="panel-collapse collapse {{(in_array(Request::segment(1),['project', "resource-management", "allocation", 'messaging', 'forum-master', 'member-log','' ]) ? 'in' : '')}}">
                    <div class="panel-body">
                        <ul class="list">
                            <li class="{{ Request::segment(1) == "project" ? "active" : "" }}" >
                                <a href="{{ route('project.index') }}">
                                    <i class="material-icons">filter_b_and_w</i>
                                    <span>Projects</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "resource-management" ? "active" : "" }}" >
                                <a href="{{ url('resource-management') }}">
                                    <i class="material-icons">filter_tilt_shift</i>
                                    <span>Resources</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "allocation" ? "active" : "" }}" >
                                <a href="{{ route('allocation.index') }}">
                                    <i class="material-icons">touch_app</i>
                                    <span>Allocation</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "messaging" ? "active" : "" }}" >
                                <a href="{{ route('messaging.index') }}">
                                    <i class="material-icons">forum</i>
                                    <span>Message</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "forum-master" ? "active" : "" }}" >
                                <a href="{{ route('forum-master.index') }}">
                                    <i class="material-icons">forum</i>
                                    <span>Forum</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "member-log" ? "active" : "" }}">
                                <a href="{{ url('member-log') }}">
                                    <i class="material-icons">access_time</i>
                                    <span>Tracks</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "git-manage" ? "active" : "" }}">
                                <a href="{{ route('git-manage.index') }}">
                                    <i class="material-icons">touch_app</i>
                                    <span>Github</span>
                                </a>
                            </li>     

                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            Slack
                        </a>
                    </p>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse {{(in_array(Request::segment(1),['slack', 'workspaces', 'slack-chat-pair', 'slack-chat' ]) ? 'in' : '')}}">
                    <div class="panel-body">
                        <ul class="list">
                            <li class="{{ Request::segment(1) == "slack" ? "active" : "" }}" >
                                <a href="{{ route('slack.index') }}">
                                    <i class="material-icons">forum</i>
                                    <span>Slack</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "workspaces" ? "active" : "" }}" >
                                <a href="{{ route('workspaces.index') }}">
                                    <i class="material-icons">forum</i>
                                    <span>Workspace</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "slack-chat-pair" ? "active" : "" }}" >
                                <a href="{{ route('slack-chat-pair.index') }}">
                                    <i class="material-icons">forum</i>
                                    <span>Slack Chat Pair</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Users
                        </a>
                    </p>
                </div>
                <div id="collapseThree" class="panel-collapse collapse {{(in_array(Request::segment(1),['applicants', 'user-management' ]) ? 'in' : '')}}">
                    <div class="panel-body">
                        <ul class="list">
                            <li class="{{ Request::segment(1) == "applicants" ? "active" : "" }}" >
                                <a href="{{ route('applicants.index') }}">
                                    <i class="material-icons">touch_app</i>
                                    <span>Applicants</span>
                                </a>
                            </li>
                            <li class="{{ Request::segment(1) == "user-management" ? "active" : "" }}" >
                                <a href="{{ route('user-management.index') }}">
                                    <i class="material-icons">group</i>
                                    <span>Users</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            Marketing
                        </a>
                    </p>
                </div>
                <div id="collapseFour" class="panel-collapse collapse {{(in_array(Request::segment(1),['upwork', 'allocateprodects' ]) ? 'in' : '')}}">
                    <div class="panel-body">
                        <ul class="list">
                            <li class="{{ Request::segment(1) == "upwork" ? "active" : "" }}" >
                                <a href="{{ route('upwork.index') }}">
                                    <i class="material-icons">play_for_work</i>
                                    <span>Upwork</span>
                                </a>
                            </li>

                            {{--<li class="" >--}}
                            {{--<a href="{{ route('user-management.index') }}">--}}
                            {{--<i class="material-icons">dashboard</i>--}}
                            {{--<span>QA View</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li class="{{ Request::segment(1) == "aws-master" ? "active" : "" }}" >--}}
                            {{--<a href="{{ route('aws-master.index') }}">--}}
                            {{--<i class="material-icons">cloud</i>--}}
                            {{--<span>AWS</span>--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            <li class="{{ Request::segment(1) == "allocateprodects" ? "active" : "" }}" >
                                <a href="{{ route('allocate-projects.index') }}">
                                    <i class="material-icons">filter_b_and_w</i>
                                    <span>Projects Allocation</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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