@extends('layouts.app-template')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
              Slack Messaging
            </h2>
        </div> 
        @yield('action-content') 
    </div>
</section>
@endsection
@section('slack-chat-scripts')
    <script src="{{ asset ("/bower_components/AdminBSB/js/slack-chat.js") }}"></script>
@stop