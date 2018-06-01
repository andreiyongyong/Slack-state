@extends('slack-chat.base')
@section('slack-chat-scripts')
    <script src="{{ asset ("/js/slack-chat.js") }}"></script>
@stop
@section('action-content')
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
  <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
          <div class="card">
              <div class="body" style="position: relative">
                  <div class="row clearfix">
                      <div class="col-md-2 col-xs-12 group-users">
                          <h4>Message Templates</h4>
                          @foreach($templates as $template)
                              <div class="col-xs-12 template-block" data-id="{{$template->id}}">
                                  {{$template->title}}
                              </div>
                          @endforeach
                      </div>
                      <div class="col-xs-10 m-b-2-px">
                          <div class="col-xs-12 m-b-2-px">
                              <div class="form-group form-float">
                                      @foreach($data['developers'] as $developer)
                                          <?php
                                              $data = array(
                                                  'id' => $developer->id,
                                                  'slack_id' => $developer->slack_user_id,
                                                  'channel_id' => $developer->channel_id,
                                                  'token' => $developer->token
                                              );
                                          ?>
                                          <div class="col-md-2">
                                              <button class="btn btn-default select-developer" data-creds="{{json_encode($data)}}" value="{{$developer->username}}">{{$developer->username}}</button>
                                              <span class="slack-status {{(($developer->status == 'active') ? 'active' : '')}}" data-slack_id="{{$developer->slack_user_id}}"></span>
                                          </div>
                                      @endforeach
                              </div>
                          </div>
                          <div class="col-xs-12 m-b-2-px">
                              <h4 id="current_developer"></h4>
                          </div>
                          <div class="col-xs-12 messaging-block" data-photo="{{ URL::to('/') }}/image/user_temp.jpg">
                                  <div class="forum-block slack-massages wrapper">

                                  </div>
                          </div>
                          <div class="col-md-12 m-b-2-px" style="margin-top: 15px;">
                              <div class="row clearfix">
                                  <div class="col-xs-11 m-b-2-px">
                                      <div class="form-group form-float">
                                          <div class="form-line">
                                              <textarea id="slack-message" name="message" class="form-control" style="height: 100px;"></textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-xs-1 m-b-2-px">
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