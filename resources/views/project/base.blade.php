 
@extends('layouts.app-template')
@section("title", "Projects")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Project--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content') 
    </div>
</section>
@endsection