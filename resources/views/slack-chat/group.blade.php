@extends('slack-chat.base')
@section('slack-chat-group-scripts')
    <script src="{{ asset ("/bower_components/AdminBSB/js/slack-group-message.js") }}"></script>
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
                      <div class="col-xs-4 m-b-2-px">
                          <div class="col-xs-12">
                              <input type="checkbox"  id="select-users-all" value="1">
                              <label for="select-users-all">Select All</label>
                          </div>
                          <div class="col-xs-12">
                              <div class="col-xs-12 group-users">
                                  @foreach($developers as $developer)
                                      <div class="col-xs-12">
                                          <input type="checkbox" data-cred="{{json_encode($developer)}}" class="select-user" id="user_{{$developer->id}}" value="{{$developer->slack_user_id}}">
                                          <label for="user_{{$developer->id}}">{{$developer->username}}</label>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-8 m-b-2-px">
                          <div class="col-xs-12">
                              <textarea id="group-message" class="form-control" style="height: 300px;"></textarea>
                          </div>
                          <div class="col-xs-12">
                              <div class="col-md-6 text-left">
                                  <span><label for="attach_file"><i class="material-icons attach-file">attach_file</i></label></span>
                                  <input style="display: none;" type="file" id="attach_file" class="upload-file" name="attach_file">
                                  <span class="file_name"></span>
                              </div>
                              <div class="col-xs-6 text-right">
                                  <button id="send-group-message" class="btn btn-primary">Send</button>
                              </div>
                          </div>
                          <div class="col-xs-12 text-right">
                              <span class="msg-notify"></span>
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