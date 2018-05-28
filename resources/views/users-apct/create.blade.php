@extends('users-apct.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new applicant</h2>
            </div>
            <div class="body">
                <form id="" class="form-horizontal" role="form" method="POST" action="{{ route('applicants.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <div class="row offset">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}"  min="1" max="50" required>
                                            <label class="form-label">User Name</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}"  min="1" max="50" required>
                                            <label class="form-label">Email Address</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                            </div> 
                            
                            
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="github_id" id="github_id" value="{{ old('github_id')  }}"  min="1" max="100" required>
                                            <label class="form-label">Github ID</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                            <!--</div>
                            
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname') }}"  min="1" max="50" required>
                                            <label class="form-label">First Name</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname') }}"  min="1" max="50" required>
                                            <label class="form-label">Last Name</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div>
                                </div>
                            </div>  
                            
                            <div class="row clearfix"> -->
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Type </label>
                                            <select name="type">
                                                <option value="2">Developer</option>
                                                <option value="1">Member</option>
                                                <option value="0">Admin</option>
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label"class="form-control">Level </label>
                                            <select name="level">
                                                @for($i=11;$i>0;$i--)
                                                <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-2">
                                    <label class="form-label">Upload image</label> 
                                </div>
                                <div class="col-md-2">
                                    <input type="file" name="image"/>
                                </div>
                                -->
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    {{--<div class="form-group form-float">--}}
                                        {{--<div class="">--}}
                                            {{--<label class="form-label">Stack</label>--}}
                                            {{--<select name="stack" id="stack">--}}
                                                {{--@foreach($workspaces as $workspace)--}}
                                                    {{--<option value="{{$workspace->id_}}">{{$workspace->id_}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div> --}}
                                    {{--</div>--}}
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="stack" id="stack" value="{{ old('stack')  }}"  min="1" max="100" required>
                                            <label class="form-label">Stack</label>
                                        </div>
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="">
                                            <label class="form-label">Project</label>
                                            <select name="project" id="project">
                                                <option value=" "></option>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->id}}">{{$project->p_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="skypeid" id="skypeid" value="{{ old('skypeid')  }}"  min="1" max="100" required>
                                            <label class="form-label">Skype ID</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="room" id="room" value="{{ old('room')  }}"  min="1" max="100" required>
                                            <label class="form-label">Room</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>  
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="country" id="country" value="{{ old('country') }}"  min="1" max="100" required>
                                            <label class="form-label">Country</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="age" id="age" value="{{ old('age') }}"  min="0" max="150" required>
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
                                            <input type="text" class="form-control" name="time_doctor_email" id="time_doctor_email" value="{{ old('time_doctor_email') }}"  min="1" max="100" required>
                                            <label class="form-label">Time Doctor Email</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="time_doctor_password" id="time_doctor_password" value="{{ old('time_doctor_password') }}"  min="1" max="100" required>
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
                                            <input type="text" class="form-control" name="time_doctor_token" id="time_doctor_token" value="{{ old('time_doctor_token') }}"  min="1" max="100" required>
                                            <label class="form-label">Time Doctor Password</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                        <!--     <div class="row clearfix"> 
                                <div class="col-md-8">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="notes" id="notes" value="{{ old('notes') }}"  min="1" max="200" required>
                                            <label class="form-label">Notes</label>
                                        </div> 
                                        <div class="help-info"> Max. 200 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-float">
                                        <div class="form-line ">
                                            <input type="checkbox" class="form-control" name="called" id="called" value="1" >
                                            <label for="called" class="form-label">Called</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="checkbox" class="form-control" name="approved" checked id="approved" value="1" >
                                            <label for="approved" class="form-label">Approved</label>
                                        </div>
                                    </div>
                                </div>
                            </div>   -->
                            <!-- <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}"  min="1" max="200">
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
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}"  min="1" max="200">
                                            <label class="form-label">Confirm Password</label>
                                        </div> 
                                        <div class="help-info"> Max. 200 characters</div>
                                    </div>
                                </div>
                            </div> -->
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
                                                    <option value="{{$workspace->id}}">{{$workspace->id_}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="channel_id" id="channel_id" value="{{ old('channel_id')  }}"  min="1" max="100" required>
                                            <label class="form-label">Channel Id</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">Create</button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
