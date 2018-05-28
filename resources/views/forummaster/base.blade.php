 
@extends('layouts.app-template')
@section("title", "Form")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Forums--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content') 
    </div>
</section>
@endsection