@extends('slack.base')
@section('action-content')

    <style>
        .slack-user-info {
            width: calc(100% - 100px);
            float: left;
            padding: 5px;
            padding-top: 40px;
        }

        .slack-status-info {
            width: 100px;
            // overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            float: left;
        }

        .filter-field {
            min-width: 250px !important;
            margin-bottom: 0px !important;
        }

        .slack-users {
            display: flex;
            align-content: space-between;
            flex-wrap: wrap;
        }
    </style>
    <div class="row clearfix">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
            <div class="card">
                <div class="header">
                    <h2>
                        Slack State
                    </h2>
                </div>
                <form class="form-horizontal">
                    <div class="body">                    
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select name="project" id="project" class="form-control show-tick project" data-live-search="true">
                                            <option value="" selected>All</option>
                                            @foreach($projects as $project)                                                            
                                            <option value="{{$project['id']}}">{{$project->p_name}}</option>                                            
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select name="type" class="type">
                                            <option value="" selected>All</option>
                                            <option value="2">Developer</option>
                                            <option value="1">Member</option>
                                            <option value="0">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select id="userStatus" class="userStatus">
                                            <option value="" selected>All</option>
                                            <option value="active">Online</option>
                                            <option value="away">Offline</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                        </div> 

                        <div class="row slack-users">
                            @foreach($data as $user)

                                @php($project_list = '')
                                @foreach($user['projects'] as $p)
                                    @php($project_list .= $p['project_id'].",")
                                @endforeach

                                <div class="col-md-12 col-sm-12 col-xs-12 col-sm-4 col-md-2 filter-field" 
                                    user-id="{{$user['id']}}" 
                                    project-list="{{$project_list}}" 
                                    user-type="{{$user['type']}}"
                                    slack-id = "{{$user['id']}}"
                                    token="{{$user['token']}}"
                                    presence="away">

                                    <div class="slack-card">
                                        <div class="slack-status-info">
                                            <div class="row slack-card-row">
                                                <div class="slack-card-title">
                                                    <span id = "{{$user['id']}}" status="away" data-slack_id="{{$user['id']}}" class="slack-status"></span>
                                                    <span>{{$user['workspace_id']}}</span>
                                                </div>
                                            </div>
                                            <div class="image-container">
                                                <img width="60" height="auto" src="{{(isset($user['profile']['image_original']) && $user['profile']['image_original'] != '') ? $user['profile']['image_original']: 'image/user.png'}}" />
                                            </div>
                                        </div>
                                        <div class="slack-user-info">                                            
                                            <p class="user-name"> {{$user['display_name']}} </p>
                                            @foreach($user['projects'] as $p)
                                            
                                                @foreach($projects as $project)
                                                    @if($p['project_id'] == $project['id'])
                                                        <p>{{$project->p_name}}</p>
                                                    @endif
                                                @endforeach

                                                @foreach($tasks as $task)
                                                    @if($p['project_id'] == $task['project_id'])
                                                        @foreach($user['tasks'] as $t)
                                                            @if($t['task_id'] == $task['id'])
                                                                <p style='padding-left:10px;'>{{$task->task_name}}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endforeach                                
                                            <p>track</p>                                            
                                            <p>Today 8 hours</p>                                            
                                            <p>Week 35 hours</p>                                                
                                        </div>
                                        <div style='clear:both;'></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php echo '<script type="text/javascript">var developerList = '.json_encode($data).';</script>'; ?>
<script type="text/javascript">
    var selected_project = 0;
    var selected_type = '';
    var selected_user_status = '';
    $(document).ready(function(){
        $("select.project").change(function(){
            filterUsers();
        });
    
        $("select.type").change(function(){
            filterUsers();
        });
        $("select.userStatus").change(function(){
            filterUsers();
        });

        getPreferences();
    });

    function filterUsers() {
        var project = $("select.project").val();
        var type = $("select.type").val();
        var presence = $("select.userStatus").val();

        var cards = $('.slack-users').children();
        for (var i = 0; i < cards.length; i++) {
            var card = cards.eq(i);
            var projectList = card.attr('project-list');
            var userType = card.attr('user-type');
            var userPresence = card.attr('presence');
            
            if (project != '' && projectList.indexOf(project + ",") == -1) {
                card.hide();
            } else {

                if (type != '' && userType != type) {
                    card.hide();
                } else {

                    if (presence != '' && presence != userPresence) {
                        card.hide();
                    } else {
                        card.show();
                    }
                }
            }
        }
    }

    function getPreferences() {
        var cards = $('.slack-users').children();
        for (var i = 0; i < cards.length; i++) {
            var card = cards.eq(i);
            var token = card.attr('token');
            var slackId = card.attr('slack-id');
            
            $.ajax({
                type: "POST",
                url: "slack/presence",
                data: {
                    token: token,
                    slack_id: slackId
                },
                cache: false,
                success: function(data) {
                    
                    var slackId = data.slack_id;
                    if (data.response.ok) {
                        if (data.response.presence == 'active') {
                            $('#' + slackId).addClass('active');
                            $("[slack-id=" + slackId + "]").attr('presence', 'active');
                            $("[slack-id=" + slackId + "]").children().eq(0).addClass('active');
                        } else {
                            $('#' + slackId).removeClass('active');
                            $("[slack-id=" + slackId + "]").attr('presence', 'away');
                            $("[slack-id=" + slackId + "]").children().eq(0).removeClass('active');
                        }
                    }
                    
                    console.log(data);
                }
            });
        }

        setTimeout(getPreferences, 20000)
    }
</script>

