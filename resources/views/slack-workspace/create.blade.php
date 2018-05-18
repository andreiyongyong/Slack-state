@extends('slack-workspace.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new workspace</h2>
                @if(isset($message))
                    <h6 style="color: red">{{$message}}</h6>
                @endif
            </div>
            <div class="body">
                <form id="" class="form-horizontal" role="form" method="POST" action="{{ route('workspaces.store') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{ csrf_field() }}
                    <div class="row offset">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="token" id="token" value="{{ old('token') }}" required>
                                            <label class="form-label">Workspace Token</label>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Admin</label>
                                            <select name="user">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="id_" id="id_" value="{{ old('id_') }}" required>
                                            <label class="form-label">ID</label>
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
 
 
