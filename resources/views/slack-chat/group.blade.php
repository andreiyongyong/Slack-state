@extends('slack-chat.base')
@section('slack-chat-group-scripts')
    <script src="{{ asset ("/js/slack-group-message.js") }}"></script>
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
                      <div class="col-xs-5 m-b-2-px">
                          <div class="col-xs-12">
                              <div class="col-xs-12 group-users">
                                  <input type="checkbox"  id="select-users-all" value="1">
                                  <label for="select-users-all">Select All</label>
                                      <div class="col-xs-12">
                                          <table id = 'DataTables_Table_0' class="table group-table table-bordered table-striped table-hover dataTable">
                                              <thead>

                                              <tr>
                                                  <th>AVATAR</th>
                                                  <th>WORKSPACE</th>
                                                  <th>USER</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              @foreach($developers as $developer)
                                                  <tr>
                                                      <td>
                                                          <img class="users-circle" src="{{\App\Http\Controllers\HelperController::getAvatar($developer->slack_user_id, $developer->workspace_id)}}" width="50" height="50" /></td>
                                                      <td>
                                                        {{$developer->workspace_id}}
                                                      </td>
                                                      <td>
                                                          <input type="checkbox" data-cred="{{json_encode($developer)}}" class="select-user" id="user_{{$developer->id}}" value="{{$developer->slack_user_id}}">
                                                          <label for="user_{{$developer->id}}">{{$developer->username}}</label>
                                                      </td>
                                                  </tr>
                                              @endforeach

                                              </tbody>
                                          </table>

                                      </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-xs-7 m-b-2-px">
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