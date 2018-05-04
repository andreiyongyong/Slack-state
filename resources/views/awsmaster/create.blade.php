@extends('users-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add new Aws</h2>
            </div>
            <div class="body">
                <form id="" class="form-horizontal" role="form" method="POST" action="{{ route('aws-master.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <div class="row offset">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_client" id="aws_client" value="{{ old('aws_client') }}"  min="1" max="100" required>
                                            <label class="form-label">Client</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_url" id="aws_url" value="{{ old('aws_url') }}"  min="1" max="191" required>
                                            <label class="form-label">Url</label>
                                        </div> 
                                        <div class="help-info"> Max. 191 characters</div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_username" id="aws_username" value="{{ old('aws_username') }}"  min="1" max="100" required>
                                            <label class="form-label">Username</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_password" id="aws_password" value="{{ old('aws_password') }}"  min="1" max="100" required>
                                            <label class="form-label">Password</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="purpose" id="purpose" value="{{ old('purpose')  }}"  min="1" max="100" required>
                                            <label class="form-label">Purpose</label>
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
                                        <div class="col-md-6">
                                            <label class="form-label">Upload Pem file</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" name="pem_file"/>
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
 
 
