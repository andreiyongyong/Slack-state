@extends('project.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Update project</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <label class="form-label">Project</label>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Project</th>
                            <th>Client</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> {{ $project->p_name }} </td>
                            <td> {{ $project->p_client }} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="body">
                <label class="form-label">New Task</label>
                <form id="project" class="form-horizontal" role="form" method="POST" action="{{url('project/addTask')}}">
                    <input type="hidden" name="id" value="{{$project->id}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{ csrf_field() }}
                    <div class="row clearfix">
                        <div class="col-md-8">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="t_name" id="t_name" value="{{ old('t_name') }}"  min="1" max="100" required>
                                    <label class="form-label">Name</label>
                                </div>
                                <div class="help-info"> Max. 100 characters</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="t_price" id="t_price" value="{{ old('t_price') }}" required>
                                    <label class="form-label">Price</label>
                                </div>
                                <div class="help-info"> No Limit . $</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" style="float: right">Add</button>
                </form>
                <div class="table-responsive">
                    <label class="form-label">Tasks</label>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->task_name }}</td>
                                <td>{{ $task->price }}</td>
                                <td>{{ $task->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
