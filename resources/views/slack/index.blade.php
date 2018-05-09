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
                      <?php
                      $headers = [];
                      $maxRow = 0;
                      foreach($data['response'] as $key => $channel){
                          $headers [] = array('id' => $key, 'name' => $channel['name']);
                          if(count($channel['members']) > $maxRow){
                              $maxRow = count($channel['members']);
                          }
                      }
                      ?>
                          <div class="table-responsive">
                              <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                  <thead>
                                  <tr>
                                      @foreach($headers as $header)
                                            <th>{{$header['name']}}</th>
                                      @endforeach
                                  </tr>
                                  </thead>
                                  <tbody>
                                  @for ($i = 0; $i < $maxRow; $i++)
                                      <tr>
                                      @foreach($headers as $header)
                                          @if(isset($data['response'][$header['id']]['members'][$i]['name']))
                                                <td>
                                                    <span class="{{($data['response'][$header['id']]['members'][$i]['status'] == 'active' ? 'st-active' : 'st-away')}}"></span>
                                                    {{$data['response'][$header['id']]['members'][$i]['name']}}
                                                    <img width="30" height="30" src="{{$data['response'][$header['id']]['members'][$i]['avatar']}}">
                                                </td>
                                          @else
                                                <td></td>
                                          @endif
                                      @endforeach
                                      </tr>
                                  @endfor
                                  </tbody>
                              </table>
                          </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 
@endsection