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
                        Send message
                    </h2>
                </div>
                <form class="form-horizontal">
                    <div class="body">                    
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select name="project" id="project" class="project">
                                            <option value="">All</option>
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
                        </div> 

                        <div class="row">
                            @foreach($data as $user)
                            <div class="col-12 col-sm-6 col-md-3 filter-field" project="{{$user['project']}}" type="2">
                                <div class="slack-card">
                                    <div class="row slack-card-row">
                                        <div class="slack-card-title">
                                            <span data-slack_id="{{$user['id']}}" class="slack-status"></span><span>{{$user['workspace_id']}}  {{$user['project']}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="image-container">
                                                <img width="60" height="auto" src="{{(isset($user['profile']['image_original']) ? $user['profile']['image_original']: '')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding:0">
                                            <div class="content-container">
                                                <p class="user-name"> {{$user['display_name']}} </p>
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
            var selected_project = '';
            var selected_type = '';
            
            $(document).ready(function(){
                $("select.project").change(function(){
                    selected_project = $(".project option:selected").val();
                    filter();                    
                });
            
                $("select.type").change(function(){
                    selected_type = $(".type option:selected").val();
                    filter();
                });
            });

            function filter(){
                var current_project = '';
                var current_type = '';
                for (i = 0; i < $(".filter-field").length; i++){
                    current_project = $(".filter-field").eq(i).attr('project');
                    current_type = $(".filter-field").eq(i).attr('type');    
                    $(".filter-field").eq(i).show();
                    if (selected_project == ''){
                        if (selected_type != '' && selected_type != current_type){
                            $(".filter-field").eq(i).hide();
                            continue;
                        }
                    } else {
                        if (selected_project != current_project){
                            $(".filter-field").eq(i).hide();
                            continue;
                        } else if (selected_type != '' && selected_type != current_type){
                            $(".filter-field").eq(i).hide();
                            continue;
                        }
                    }
                }
            }
        </script>

