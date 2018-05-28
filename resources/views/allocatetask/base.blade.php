 
@extends('layouts.app-template')
@section("title", "Task")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Tasks Allocation--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content') 
    </div>
</section>
@endsection