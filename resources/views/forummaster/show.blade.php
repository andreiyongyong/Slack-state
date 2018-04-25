@extends('forummaster.base')
@section('action-content') 
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
  <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          @foreach($forums as $forum)
              <div class="col-lg-3"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/{{$forum->user['image']}}"></div>
              <div class="col-lg-9">
                  <span>{{$forum->user['firstname'].' '.$forum->user['lastname'] }}</span>
                  <span>{{$forum->reply_time}}</span>
                  <p>{{$forum->answer}}</p>
              </div>

          @endforeach
      </div> 
  </div> 
@endsection