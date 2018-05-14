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
              <div class="body">
                  <div class="row">
                      <div class="table-responsive">
                          <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-statuses dataTable">
                              <thead>
                              <tr>
                                  <th>STATUS</th>
                                  <th>NAME</th>
                                  <th>AVATAR</th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($data as $user)
                                  <tr>
                                      <td><span data-slack_id="{{$user['id']}}" class="slack-status"></span></td>
                                      <td>{{$user['display_name']}}</td>
                                      <td><img width="30" height="30" src="{{(isset($user['profile']['image_original']) ? $user['profile']['image_original']: '')}}"></td>
                                  </tr>
                              @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 
@endsection