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
                        <!-- <div class="row">
                            <div class="table-responsive">
                                <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-statuses dataTable">
                                    <thead>
                                    <tr>
                                        <th>Workspace Id</th>
                                        <th>Project</th>
                                        <th>STATUS</th>
                                        <th>NAME</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $user)
                                        <tr>
                                            <td>{{$user['workspace_id']}}</td>
                                            <th>{{$user['project']}}</th>
                                            <td><span data-slack_id="{{$user['id']}}" class="slack-status"></span></td>
                                            <td><img width="60" height="60" src="{{(isset($user['profile']['image_original']) ? $user['profile']['image_original']: '')}}"> {{$user['display_name']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select name="project" id="project" >
                                            <option value=" ">All</option>                                            
                                            <option value="1">Project 1</option>
                                            <option value="2">Project 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group form-float">
                                    <div>
                                        <select name="type">
                                            <option value=" ">All</option>
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
                            <div class="col-12 col-sm-6 col-md-3">
                                <div class="slack-card">
                                    <div class="row slack-card-row">
                                        <div class="slack-card-title">
                                        <span class="dot"></span> <span>{{$user['workspace_id']}}  {{$user['project']}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="image-container">
                                                <img width="120" height="160" src="{{(isset($user['profile']['image_original']) ? $user['profile']['image_original']: '')}}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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