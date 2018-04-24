@extends('users-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add new resource</h2>
            </div>
            <div class="body">
                <form id="resource-management" class="form-horizontal" role="form" method="POST" action="{{ route('resource-management.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}"  min="1" max="100" required>
                                    <label class="form-label">Title</label>
                                </div> 
                                <div class="help-info"> Max. 100 characters</div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="url" id="url" value="{{ old('url') }}"  min="5" max="191" required>
                                    <label class="form-label">Url</label>
                                </div> 
                                <div class="help-info"> Max. 191 characters</div>
                            </div>
                        </div>
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea class="form-control" rows="5" name="content"  form="resource-management" id="content" required></textarea>
                                    <label class="form-label">Content</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group form-float">
                                <div>
                                    <label class="form-label">Type</label>
                                    <select name="type">
                                        <option value="2">Developer</option>
                                        <option value="1">Member</option>
                                        <option value="0">Admin</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group form-float">
                                <div>
                                    <label class="form-label">Level </label>
                                    <select name="level">
                                        @for($i=11;$i>0;$i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary " type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
