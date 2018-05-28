@extends('allocation.base')
@section('action-content')
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div>
  <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
          <div class="card">

              <div class="body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group form-float">
                              <div>
                                  <label class="form-label">Users</label>
                                  <select name="user" id="select-user" data-live-search="true">
                                      @foreach($users as $user)
                                          <option value="{{$user->id}}">{{$user->username}}</option>
                                      @endforeach
                                  </select>
                                  <?php $show = 0;?>
                                  @foreach($users as $user)
                                      <img style="{{$show++ > 0 ? 'display: none;' : '' }}" class="users-circle user_{{$user->id}}" src="{{\App\Http\Controllers\HelperController::getAvatar($user->slack_user_id, $user->workspace_id)}}" width="50" height="50" />
                                  @endforeach
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group form-float">
                              <div>
                                  <label class="form-label">Project</label>
                                  <select name="project" id="select-project">
                                      @foreach($projects as $project)
                                          <option value="{{$project->id}}">{{$project->p_name}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                          <div id="origin" class="fbox">
                              @foreach($user_res as $user_re)
                                  <div id="resource_{{$user_re->id}}" data-pr_id="{{$user_re->project_id}}" data-id="{{$user_re->id}}" class="draggable resource-block" >
                                      <div>Project : {{$user_re->pr_name}}</div>
                                      <div>Resource : {{$user_re->title}}</div>
                                  </div>
                              @endforeach
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div id="drop" class="fbox col-md-6">
                              @foreach($project_res as $project_re)
                                  <div id="resource_{{$project_re->id}}" data-pr_id="{{$project_re->project_id}}" data-id="{{$project_re->id}}" class="draggable ui-draggable ui-draggable-handle resource-block" >
                                      <div>Project : {{$project_re->pr_name}}</div>
                                      <div>Resource : {{$project_re->title}}</div>
                                  </div>
                              @endforeach
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 
@endsection