@extends('slack-chat-pair.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new Chat Pair</h2>
            </div>
            <div class="body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('slack-chat-pair.store') }}">
                    {{ csrf_field() }} 
                    <div class="row offset">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Project </label>
                                            <select name="project_id">
                                               @foreach($projects as $project)
                                                <option value="{{$project->id}}">{{$project->p_name}}</option>
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="name" id="name" value=""  min="1" max="200" required>
                                            <label class="form-label">Chat Pair Name</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Workspace 1 </label>
                                            <select name="workspace_id_1">
                                                @foreach($workspaces as $workspace)
                                                    <option value="{{$workspace->id}}">{{$workspace->id_}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Workspace 2 </label>
                                            <select name="workspace_id_2">
                                                @foreach($workspaces as $workspace)
                                                    <option value="{{$workspace->id}}">{{$workspace->id_}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">User 1 </label>
                                            <select name="user_id_1">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">User 2 </label>
                                            <select name="user_id_2">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Admin 1 </label>
                                            <select name="admin_id_1">
                                                @foreach($admins as $admin)
                                                    <option value="{{$admin->id}}">{{$admin->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Admin 2 </label>
                                            <select name="admin_id_2">
                                                @foreach($admins as $admin)
                                                    <option value="{{$admin->id}}">{{$admin->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">Create</button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
