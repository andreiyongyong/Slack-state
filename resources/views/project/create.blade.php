@extends('project.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new project</h2>
            </div>
            <div class="body">
                <form id="project" class="form-horizontal" role="form" method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-8">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="p_name" id="p_name" value="{{ old('p_name') }}"  min="1" max="100" required>
                                    <label class="form-label">Project</label>
                                </div> 
                                <div class="help-info"> Max. 100 characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="p_client" id="p_client" value="{{ old('p_client') }}"  min="1" max="200" required>
                                    <label class="form-label">Client</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                    </div>   
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="task" id="task" value="{{ old('task') }}"  min="1" max="200" required>
                                    <label class="form-label">Task</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="price" id="price" value="{{ old('price') }}" required>
                                    <label class="form-label">Price</label>
                                </div> 
                                <div class="help-info"> No Limit . $</div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="developer" id="developer" value="{{ old('developer') }}"  min="1" max="200" required>
                                    <label class="form-label">Developer</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="date" class="form-control focused" name="meet_time" id="meet_time" value="{{ old('meet_time') }}" required>
                                    <label class="form-label">Meet Time</label>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="mode" id="mode" value="{{ old('mode') }}" required>
                                    <label class="form-label">Mode</label>
                                </div> 
                                <div class="help-info"></div>
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
 
 
