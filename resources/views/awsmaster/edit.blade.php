@extends('users-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Edit Aws</h2>
            </div>
            <div class="body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('aws-master.update', ['id' => $aws->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_client" id="aws_client" value="{{ $aws->aws_client }}"  min="1" max="100" required>
                                            <label class="form-label">Client</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_url" id="aws_url" value="{{ $aws->aws_url }}"  min="1" max="200" required>
                                            <label class="form-label">Url</label>
                                        </div> 
                                        <div class="help-info"> Max. 200 characters</div>
                                    </div>
                                </div>
                            </div>  
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_username" id="aws_username" value="{{ $aws->aws_username  }}"  min="1" max="100" required>
                                            <label class="form-label">Username</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="aws_password" id="aws_password" value="{{ $aws->aws_password }}"  min="1" max="100" required>
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
                                            <input type="text" class="form-control" name="purpose" id="purpose" value="{{ $aws->awsinstance['purpose']  }}"  min="1" max="100" required>
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
                                            <input type="text" class="form-control" name="country" id="country" value="{{ $aws->awsinstance['country']  }}"  min="1" max="100" required>
                                            <label class="form-label">Country</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Upload pem file</label>
                                </div>
                                <div class="col-md-3"><input type="file" name="pem_file"/></div>
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
 
 
