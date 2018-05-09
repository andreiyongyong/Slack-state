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
                  <h6 style="color: {{($data['error'] ? 'red' : '#1f91f3')}}"> {{$data['message']}} </h6>
              </div> 
              <div class="body">
                  <form class="form-horizontal" role="form" method="POST" action="{{ route('slack.send') }}">
                      <input type="hidden" name="_method" value="POST">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      {{ csrf_field() }}
                      <div class="row">
                          <div class="col-md-12">
                              <div class="row clearfix">
                                  <div class="col-md-12">
                                      <div class="form-group form-float">
                                          <div class="form-line">
                                              <input type="text" class="form-control" name="channel" id="channel" value="" required>
                                              <label class="form-label">Channel</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row clearfix">
                                  <div class="col-md-12">
                                      <div class="form-group form-float">
                                          <div class="form-line">
                                              <input type="text" class="form-control" name="message" id="message" value="" required>
                                              <label class="form-label">Message</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <button class="btn btn-primary waves-effect" type="submit">Send</button>
                          </div>
                      </div>
                  </form>
                  <div class="row">

                          <div class="table-responsive">
                              <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                  <thead>
                                  <tr>
                                     <th>STATUS</th>
                                     <th>NAME</th>
                                     <th>AVATAR</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                      @foreach($data['response'] as $user)
                                          <tr>
                                              <td><span class="{{($user['presence'] == 'active' ? 'st-active' : 'st-away')}}"></span></td>
                                              <td>{{$user['profile']['display_name']}}</td>
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