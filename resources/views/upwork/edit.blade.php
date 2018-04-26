@extends('project.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add new project</h2> 
            </div>
            <div class="body">
                <form class="form-horizontal" id="project" role="form" method="POST" action="{{ route('project.update', ['id' => $project->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-8">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="p_name" id="p_name" value="{{ $project->p_name }}"  min="1" max="100" required>
                                    <label class="form-label">Project</label>
                                </div> 
                                <div class="help-info"> Max. 100 characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="p_client" id="p_client" value="{{ $project->p_client }}"  min="1" max="200" required>
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
                                    <input type="text" class="form-control" name="task" id="task" value="{{ $project->task }}"  min="1" max="200" required>
                                    <label class="form-label">Task</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="price" id="price" value="{{ $project->price }}" required>
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
                                    <input type="text" class="form-control" name="developer" id="developer" value="{{ $project->developer }}"  min="1" max="200" required>
                                    <label class="form-label">Developer</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="date" class="form-control" name="meet_time" id="meet_time" value="{{ $project->meet_time }}" required>
                                    <label class="form-label">Meet Time</label>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="mode" id="mode" value="{{ $project->mode }}" required>
                                    <label class="form-label">Mode</label>
                                </div> 
                                <div class="help-info"></div>
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
 
 
