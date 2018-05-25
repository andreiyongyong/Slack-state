@extends('slack.base')
@section('action-content')

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
                                        <select name="project" id="project" class="project">
                                            <option value="0">All</option>
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
                                            <option value="">All</option>
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

                        <div class="row">
                            @foreach($data as $user)
                            <div class="col-12 col-sm-6 col-md-2 filter-field" user-id="{{$user['id']}}" project="{{$user['projects']}}" type="{{$user['type']}}">
                                <div class="slack-card" data-slack_id="{{$user['id']}}">                                    
                                    <div class="row">
                                        <div class="col-md-6" style="padding: .1em .1em .1em .5em;">
                                            <div class="row slack-card-row">
                                                <div class="slack-card-title">
                                                    <span id = "{{$user['id']}}" status="away" data-slack_id="{{$user['id']}}" class="slack-status"></span><span>{{$user['workspace_id']}}</span>
                                                </div>
                                            </div>
                                            <div class="image-container">
                                                <img width="60" height="auto" src="{{(isset($user['profile']['image_original']) ? $user['profile']['image_original']: '')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding:0">                                            
                                            <div class="content-container">
                                                <p class="user-name"> {{$user['display_name']}} </p>
                                                @foreach($user['project'] as $project)
                                                <p>{{$project}}</p>
                                                @endforeach
                                                <p>task name</p>                                            
                                                <p>track</p>                                            
                                                <p>Today 8 hours</p>                                            
                                                <p>Week 35 hours</p>                                                
                                            </div>
                                        </div>
                                    </div>
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
<script type="text/javascript">
    var selected_project = 0;
    var selected_type = '';
    var selected_user_status = '';
    $(document).ready(function(){
        $("select.project").change(function(){
            filter();                    
        });
    
        $("select.type").change(function(){
            filter();
        });
        $("select.userStatus").change(function(){
            filter();
        });
    });

    function filter(){
        selected_project = parseInt($(".project option:selected").val());
        selected_type = $(".type option:selected").val();
        selected_user_status =  $("#userStatus").val();;

        var current_project = [];
        var current_type = '';
        var current_user_status = '';
        for (i = 0; i < $(".filter-field").length; i++){
            var userObj = $(".filter-field").eq(i);
            var userId = userObj.attr('user-id');

            current_project = JSON.parse($(".filter-field").eq(i).attr('project'));
            current_type = $(".filter-field").eq(i).attr('type');
            current_user_status = $('#' + userId).attr('status');

            $(".filter-field").eq(i).show();
            if (selected_user_status == ''){
                if (selected_project == 0){
                    if (selected_type != '' && selected_type != current_type){
                        $(".filter-field").eq(i).hide();
                        continue;
                    }
                } else {
                    var k = $.inArray(selected_project, current_project);
                    if ($.inArray(selected_project, current_project) == -1){
                        $(".filter-field").eq(i).hide();
                        continue;
                    } else if (selected_type != '' && selected_type != current_type){
                        $(".filter-field").eq(i).hide();
                        continue;
                    }
                }
            } else {
                if (selected_user_status != current_user_status) {
                    $(".filter-field").eq(i).hide();
                    continue;
                } else {
                    if (selected_project == 0){
                        if (selected_type != '' && selected_type != current_type){
                            $(".filter-field").eq(i).hide();
                            continue;
                        }
                    } else {
                        if ($.inArray(selected_project, current_project) == -1){
                            $(".filter-field").eq(i).hide();
                            continue;
                        } else if (selected_type != '' && selected_type != current_type){
                            $(".filter-field").eq(i).hide();
                            continue;
                        }
                    }
                }
            }    
        }
    }
</script>

