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
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <!-- <td> {{ $project->p_name }} </td> -->
                                <td><input type="text" class="form-control" name="p_name" id="p_name" value="{{ $project->p_name }}"  min="1" max="100" required></td>
                                <td><input type="text" class="form-control" name="p_client" id="p_client" value="{{ $project->p_client }}"  min="1" max="100" required></td>
                                <td align="center"><button class="btn btn-primary" id="save" type="submit">Save</button></td>
                                <!-- <td> {{ $project->p_client }} </td> -->
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="body">
                <label class="form-label">New Task</label>
                <form id="project" class="form-horizontal" role="form" method="POST" action="{{url('project/addTask')}}">
                    <input type="hidden" name="id" id = "p_id"value="{{$project->id}}">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#save").click(function(){
            p_name = $("#p_name").val();
            p_client = $("#p_client").val();
            id = $("#p_id").val();
            $.ajax({
                type: "POST",
                url: "/project/editProject",
                data: {p_name: p_name, p_client:p_client, id: id},
                success: function(resp){
                    if(resp.status == 'success'){
                        alert('Project is saved');
                    }else{
                        alert('ajax error');
                    }
                }
            })
        })
    });
</script>
@endsection
 
 
