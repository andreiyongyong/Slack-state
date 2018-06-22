@extends('layouts.app')

@section('content')
<div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);"><b> SQ </b></a>
            <small>SQ TECNOLOGY COMPANY</small>
        </div>
        <div class="card">
            <div class="body">
               <form id="sign_up" class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                    <div class="msg">Register a new membership</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" id="name" name="name"  value="{{ old('name') }}" placeholder="User name" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                        <div class="form-line">
                            <input type="email" class="form-control" id="email" name="email"  value="{{ old('email') }}" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" id="password" name="password" minlength="6" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" id="password-confirm" name="password-confirm" minlength="6" placeholder="Confirm Password" required>
                        </div>
                    </div>  
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ route('login') }}">You already have a membership?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
