@extends('users-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add new user</h2> 
            </div>
            <div class="body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.update', ['id' => $user->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}"  min="1" max="50" required>
                                    <label class="form-label">User Name</label>
                                </div> 
                                <div class="help-info"> Max. 50 characters</div>
                            </div>
                        </div>
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $user->firstname  }}"  min="1" max="50" required>
                                    <label class="form-label">First Name</label>
                                </div> 
                                <div class="help-info"> Max. 50 characters</div>
                            </div>
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $user->lastname }}"  min="1" max="50" required>
                                    <label class="form-label">Last Name</label>
                                </div> 
                                <div class="help-info"> Max. 50 characters</div>
                            </div>
                        </div>
                    </div>    
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password" id="password"  min="1" max="200" required>
                                    <label class="form-label">Password</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                    </div>     
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"    min="1" max="200" required>
                                    <label class="form-label">Confirm Password</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                    </div>      
                    <button class="btn btn-primary waves-effect" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
