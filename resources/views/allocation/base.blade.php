 
@extends('layouts.app-template')
@section("title", "Allocation-Resource")
@section('content')
<section class="content">
    <div class="container-fluid">
        {{--<div class="block-header">--}}
            {{--<h2>--}}
              {{--Allocation--}}
            {{--</h2>--}}
        {{--</div> --}}
        @yield('action-content') 
    </div>
</section>
@endsection
@section('allocation-scripts')
    <script src="{{ asset ("/js/allocation.js") }}"></script>
@stop