@extends('forummaster.base')
@section('action-content') 
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div>

    <div class="row " style="background-color: #f1f3fa;">
        <div class="forum-block forum-massages wrapper">
            @foreach($forums as $forum)
                <div class="table-div">
                    <div class="table-cell w-100-px"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/{{!empty($forum->user['image'])?$forum->user['image']:'user_temp.jpg'}}"></div>
                    <div class="table-cell info-div">
                        <span class="first-name">{{$forum->user['firstname'].' '.$forum->user['lastname'] }}</span>
                        <span class="reply-time">{{$forum->reply_time}}</span>
                        <p class="info-txt">{{$forum->answer}}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <form id="forumreply" class="form-horizontal" role="form" method="POST" action="/forum-master/add-forum-answer">
            {{ csrf_field() }}
            <div class="forum-block forum-reply">
            <div class="table-div">
                <div class="table-cell w-100-px"><img width="80" height="80" class="img-circle" src="{{ URL::to('/') }}/image/{{!empty(Auth::user()->image)?Auth::user()->image:'user_temp.jpg'}}"></div>
                <input type="hidden" name="userid" value="{{Auth::user()->id}}">
                <input type="hidden" name="forum_mid" value="{{$forum_mid}}">
                <div class="table-cell info-div-answer">
                    <textarea rows="6" cols="80" class="forum_answer_textarea" form="forumreply" name="answer" placeholder="Write a Reply..." required></textarea>
                    <button type="submit" class="btn btn-send pull-right">Send <i class="glyphicon glyphicon-send"></i> </button>
                </div>

            </div>

        </div>
        </form>
        {{--<div class="send-block clearfix">--}}
            {{--<div class="textarea-div">--}}
                {{--<div class="table-div">--}}
                    {{--<div class="table-cell"><img width="80" height="80" class="img-circle" src="http://sq.loc/image/1524503568.jpg"></div>--}}
                    {{--<div class="table-cell">--}}
                        {{--<span class="write">Write a Reply...</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<textarea name="" id="" cols="30" rows="10"></textarea>--}}
            {{--</div>--}}

            {{--<a href="#" class="btn btn-send pull-right">Send <i class="glyphicon glyphicon-send"></i> </a>--}}

        {{--</div>--}}

    </div>

@endsection