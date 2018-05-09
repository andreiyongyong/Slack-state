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
              <div class="body">
                  <div class="row clearfix">
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 messaging-section">
                          <div class="col-xs-12">
                              <div class="form-group form-float">
                                  <select name="project">
                                      @foreach($data['projects'] as $project)
                                        <option value="{{$project['id']}}">{{$project['p_name']}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-xs-12">
                              <div class="form-group form-float">
                                  <h2>
                                      Tasks
                                  </h2>
                                      @foreach($data['projects'] as $project)
                                          @foreach($project->tasks as $task)
                                              <button style="width: 100%;margin-bottom: 5px;" >{{$task['task_name']}}</button>
                                          @endforeach
                                      @endforeach
                              </div>
                          </div>

                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 messaging-section">
                          <div class="col-xs-12">
                              <div class="form-group form-float">
                                  <select name="developer">
                                      @foreach($data['developers'] as $developer)
                                          <option value="{{$developer['id']}}">{{$developer['username']}}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-xs-12">
                                  <div class="forum-block forum-massages wrapper">
                                      <div class="table-div">
                                          <div class="table-cell w-100-px"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/user_temp.jpg"></div>
                                          <div class="table-cell info-div">
                                              <span class="first-name">test</span>
                                              <span class="reply-time">test</span>
                                              <p class="info-txt">test</p>
                                          </div>
                                      </div>
                                  </div>

                                  <form id="forumreply" class="form-horizontal" role="form" method="POST" action="/forum-master/add-forum-answer">
                                      {{ csrf_field() }}
                                      <div class="forum-block forum-reply">
                                          <div class="table-div">
                                              <div class="table-cell w-100-px"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/user_temp.jpg"></div>
                                              <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                                              <input type="hidden" name="forum_mid" value="">
                                              <div class="table-cell info-div-answer">
                                                  <textarea rows="6" cols="80" class="forum_answer_textarea" form="forumreply" name="answer" placeholder="Write a Reply..." required></textarea>
                                                  <button type="submit" class="btn btn-send pull-right">Send <i class="glyphicon glyphicon-send"></i> </button>
                                              </div>

                                          </div>

                                      </div>
                                  </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 
@endsection