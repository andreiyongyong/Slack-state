@extends('layouts.app-template')
@section("title", "Github")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Git Manage--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content') 
    </div>
</section>
@endsection