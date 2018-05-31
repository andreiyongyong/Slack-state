 
@extends('layouts.app-template')
@section("title", "Message Templates")
@section('content')
<section class="content">
    <div class="container-fluid">
        @yield('action-content') 
    </div>
</section>
@endsection