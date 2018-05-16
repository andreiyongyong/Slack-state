 
@extends('layouts.app-template')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
              Allocation
            </h2>
        </div> 
        @yield('action-content') 
    </div>
</section>
@endsection
@section('allocation-scripts')
    <script src="{{ asset ("/bower_components/AdminBSB/js/allocation.js") }}"></script>
@stop