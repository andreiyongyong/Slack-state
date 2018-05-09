@extends('slack-workspace.base')
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
                      User invitation
                  </h2>
                  @if($data['error'])
                      <h6 style="color: red">{{$data['message']}}</h6>
                  @endif
              </div> 
              <div class="body">
                  @if($data['view'] == 'no_invited')
                      <form class="form-horizontal" role="form" method="POST" action="{{ route('workspaces.invite') }}" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          {{ csrf_field() }}
                          <input type="hidden" name="user_id" value="{{$data['user']->id}}">
                          <div class="row offset">
                              <div class="col-md-12">
                                  <div class="row clearfix">
                                      <div class="col-md-6 col-xs-12">
                                          <div class="form-group form-float">
                                              <label for="workspace"></label>
                                              <select name="workspace_id" id="workspace">
                                                  @foreach($data['workspaces'] as $workspace)
                                                      <option value="{{$workspace['id']}}">{{$workspace['name']}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <div class="col-md-6 col-xs-12">
                                          <div class="form-group form-float">
                                              <button class="btn btn-primary waves-effect" type="submit">Invite</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-1"></div>
                          </div>
                      </form>
                  @elseif($data['view'] == 'invited_sent')
                      <div class="row offset">
                          <div class="col-md-12">
                              <h5>Already invited to <a href="#">{{$data['workspace']->name}}</a> WorkSpace</h5>
                          </div>
                          <div class="col-md-1"></div>
                      </div>
                  @elseif($data['view'] ==  'invited_success')
                      <div class="row offset">
                          <div class="col-md-12">
                              <h5>Already in <a href="#">{{$data['workspace']->name}}</a> WorkSpace</h5>
                          </div>
                          <div class="col-md-12">
                              <span class="{{($data['user']->presence == 'active' ? 'st-active' : 'st-away')}}"></span>
                              {{$data['user']->display_name}}
                              <img width="30" height="30" src="{{$data['user']->avatar}}">
                          </div>
                          <div class="col-md-1"></div>
                      </div>
                  @endif
              </div>
          </div>
      </div> 
  </div> 
@endsection