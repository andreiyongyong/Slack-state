@extends('users-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Edit user</h2>
            </div>
            <div class="body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.update', ['id' => $user->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}"  min="1" max="50" required>
                                            <label class="form-label">User Name</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}"  min="1" max="50" required>
                                            <label class="form-label">Email Address</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                            </div>  
                            {{--<div class="row clearfix">--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="form-line">--}}
                                            {{--<input type="text" class="form-control" name="firstname" id="firstname" value="{{ $user->firstname  }}"  min="1" max="50" required>--}}
                                            {{--<label class="form-label">First Name</label>--}}
                                        {{--</div> --}}
                                        {{--<div class="help-info"> Max. 50 characters</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="form-line">--}}
                                            {{--<input type="text" class="form-control" name="lastname" id="lastname" value="{{ $user->lastname  }}"  min="1" max="50" required>--}}
                                            {{--<label class="form-label">Last Name</label>--}}
                                        {{--</div> --}}
                                        {{--<div class="help-info"> Max. 50 characters</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>  --}}
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="github_id" id="github_id" value="{{ $user->github_id  }}"  min="1" max="100" required>
                                            <label class="form-label">Github ID</label>
                                        </div>
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Type</label>
                                            <select name="type">
                                                <option value="2" {{ $user->type == 2 ? "selected" : "" }}>Developer</option>
                                                <option value="1" {{ $user->type == 1 ? "selected" : "" }}>Member</option>
                                                <option value="0" {{ $user->type == 0 ? "selected" : "" }}>Admin</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Level </label>
                                            <select name="level">
                                                @for($i=11;$i>0;$i--)
                                                    <option value="{{$i}}" {{ $user->level == $i ? "selected" : "" }}>{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                {{--<div class="col-md-2">--}}
                                    {{--<label class="form-label">Upload image</label> --}}
                                {{--</div>--}}
                                {{--<div class="col-md-2"><input type="file" name="image"/></div>--}}
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="">--}}
                                            {{--<label class="form-label">Stack</label>--}}
                                            {{--<select name="stack" id="stack">--}}
                                                {{--@foreach($workspaces as $workspace)--}}
                                                    {{--<option value="{{$workspace->id_}}" {{(($user->userinfo['stack'] == $workspace->id_) ? 'selected' : '')}}>{{$workspace->id_}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="stack" id="stack" value="{{ $user->userinfo['stack']  }}"  min="1" max="100" required>
                                            <label class="form-label">Stack</label>
                                        </div>
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="country" id="country" value="{{ $user->country  }}"  min="1" max="100" required>
                                            <label class="form-label">Country</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="age" id="age" value="{{ $user->age  }}"  min="1" max="3" required>
                                            <label class="form-label">Age</label>
                                        </div> 
                                        <div class="help-info"> Max. 3 characters</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="time_doctor_email" id="time_doctor_email" value="{{ $user->time_doctor_email  }}"  min="1" max="100" required>
                                            <label class="form-label">Time Doctor Email</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="time_doctor_password" id="time_doctor_password" value="{{ $user->time_doctor_password  }}"  min="1" max="100" required>
                                            <label class="form-label">Time Doctor Password</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="time_doctor_token" id="time_doctor_token" value="{{ $user->time_doctor_token }}"  min="1" max="100" required>
                                            <label class="form-label">Time Doctor Token</label>
                                        </div>
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="row clearfix">--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="form-line">--}}
                                            {{--<input type="password" class="form-control" name="password" id="password"  min="1" max="200" required>--}}
                                            {{--<label class="form-label">Password</label>--}}
                                        {{--</div> --}}
                                        {{--<div class="help-info"> Max. 200 characters</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="form-line">--}}
                                            {{--<input type="password" class="form-control" name="password_confirmation" id="password_confirmation"    min="1" max="200" required>--}}
                                            {{--<label class="form-label">Confirm Password</label>--}}
                                        {{--</div> --}}
                                        {{--<div class="help-info"> Max. 200 characters</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row clearfix">
                                <div class="cal-xs-12">
                                    <h4 style="margin-left: 20px;">Slack Options</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="">
                                            <label class="form-label">Workspace</label>
                                            <select name="workspace" id="workspace">
                                                <option value=" "></option>
                                                @foreach($workspaces as $workspace)
                                                    <option value="{{$workspace->id}}" {{(($user->workspace_id == $workspace->id) ? 'selected' : '')}}>{{$workspace->id_}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="channel_id" id="channel_id" value="{{ $user->channel_id  }}"  min="1" max="100" required>
                                            <label class="form-label">Channel Id</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="slack_user_id" id="slack_user_id" value="{{ $user->slack_user_id }}"  min="1" max="100" required>
                                            <label class="form-label">Slack User Id</label>
                                        </div>
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">Update</button>
                        </div> 
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
