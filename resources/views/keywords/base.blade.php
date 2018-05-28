 
@extends('layouts.app-template')
@section("title", "Forbidden Keywords")
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>
              Forbidden Keywords
            </h2>
        </div>
        @yield('action-content') 
    </div>
</section>
@endsection