@extends('forummaster.base')
@section('action-content') 
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
  <div class="row">
      <div class="forum-block">
          @foreach($forums as $forum)
              <div class="table-div">
                  <div class="table-cell w-100-px"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/{{$forum->user['image']}}"></div>
                  <div class="table-cell info-div">
                      <span class="first-name">{{$forum->user['firstname'].' '.$forum->user['lastname'] }}</span>
                      <span class="reply-time">{{$forum->reply_time}}</span>
                      <p class="info-txt">{{$forum->answer}}</p>
                  </div>
              </div>
          @endforeach
      </div>
  </div> 
@endsection