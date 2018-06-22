 
@extends('layouts.app-template')
@section("title", "Workspace")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Slack Workspaces--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content')
    </div>
</section>
@endsection