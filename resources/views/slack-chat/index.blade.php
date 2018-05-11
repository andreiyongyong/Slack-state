@extends('slack-chat.base')
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
                      Slack
                  </h2>
              </div>
              <div class="body" style="position: relative">
                  <div class="row clearfix">
                      <div class="col-xs-12">
                          <div class="col-xs-12">
                              <div class="form-group form-float">
                                      @foreach($data['developers'] as $developer)
                                      @if($developer->userinfo !== null)
                                          <?php
                                              $data = array(
                                                  'id' => $developer->id,
                                                  'slack_id' => $developer->slack_user_id,
                                                  'channel_id' => $developer->userinfo['channel_id'],
                                                  'workspace_id' => $developer->workspace_id
                                              );
                                          ?>
                                          <div class="col-md-2">
                                              <button class="btn btn-default select-developer" data-creds="{{json_encode($data)}}" value="{{$developer['username']}}">{{$developer['username']}}</button>
                                              <span class="slack-status {{(($developer->status == 'active') ? 'active' : '')}}" data-slack_id="{{$developer->slack_user_id}}"></span>
                                          </div>
                                      @endif
                                      @endforeach
                              </div>
                          </div>
                          <div class="col-xs-12">
                              <h2 id="current_developer"></h2>
                          </div>
                          <div class="col-xs-12 messaging-block" data-photo="{{ URL::to('/') }}/image/user_temp.jpg">
                                  <div class="forum-block slack-massages wrapper">

                                  </div>
                          </div>
                          <div class="col-md-12" style="margin-top: 15px">
                              <div class="row clearfix">
                                  <div class="col-xs-10">
                                      <div class="form-group form-float">
                                          <div class="form-line">
                                              <input type="text" class="form-control" name="message" id="slack-message" value="">
                                              <label class="form-label">Message</label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xs-2">
                                      <button class="btn btn-primary waves-effect" id="send-message">Send</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          <div class="loading-block display-none">
          </div>
          </div>
      </div>
  </div> 
@endsection