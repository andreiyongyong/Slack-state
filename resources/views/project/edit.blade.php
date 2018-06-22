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
                                <th>Level</th>
                                <th>Status</th>
                                <th>Hot</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <!-- <td> {{ $project->p_name }} </td> -->
                                <!-- <td> {{ $project->p_client }} </td> -->
                                <td><input type="text" class="form-control" name="p_name" id="p_name" value="{{ $project->p_name }}"  min="1" max="100" required></td>
                                <td><input type="text" class="form-control" name="p_client" id="p_client" value="{{ $project->p_client }}"  min="1" max="100" required></td>
                                <td>
                                    <select class="form-control show-tick" id = 'level'>
                                        <?php $level_array = array("LV1","LV2","LV3","LV4","LV5"); ?>
                                        @foreach($level_array as $key=>$level)
                                            <option {{ $project->level == $level ? 'selected="selected"' : '' }}>{{ $level }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control show-tick" id = "status">
                                        <?php $status_array = array("Upcoming","Live","Hold","Closed","Deleted"); ?>
                                        @foreach($status_array as $key=>$status)
                                            <option {{ $project->status == $status ? 'selected="selected"' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control show-tick" id= "hot">
                                        <?php $hot_array = array("Hot","Normal","Loose"); ?>
                                        @foreach($hot_array as $key=>$hot)
                                            <option {{ $project->hot == $hot ? 'selected="selected"' : '' }}>{{ $hot }}</option>
                                        @endforeach
                                        <option>Hot</option>
                                        <option>Normal</option>
                                        <option>Loose</option>
                                    </select>
                                </td>
                                <td align="center"><button class="btn btn-primary waves-effect" id="save" type="submit">Save</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="body">
                <label class="form-label">New Task</label>
                <form id="project" class="form-horizontal" role="form" method="POST" action="{{url('project/addTask')}}">
                    <input type="hidden" name="id" id = "p_id" value="{{$project->id}}">
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id = "task_table">
                        @foreach ($tasks as $task)
                            <form class="row" method="POST" action="{{ url('project/editTask') }}" >
                                <tr>
                                    <td>{{ $task->id }}</td>
                                    <td>
                                        <div style="text-decoration: underline;">{{ $task->task_name }}</div>
                                        <input name="task_name" value="{{ $task->task_name }}" hidden>
                                    </td>
                                    <td>
                                        <div style="text-decoration: underline;">{{ $task->price }}</div>
                                        <input type="number" name="price" value="{{ $task->price }}" hidden>
                                    </td>
                                    <td>{{ $task->created_at }}</td>
                                    <td align="center">
                                        <input type="hidden" name="id" class="task_id" value="{{ $task->id }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type ="submit" class="btn btn-info waves-effect">
                                        Save
                                        </button>
                                        {{--@if ($user->username != Auth::user()->username)--}}
                                        <a class="btn btn-danger waves-effect del_task" data-task_id = {{$task->id}}>
                                        Delete
                                        </a>
                                        {{--@endif--}}
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    $(document).ready(function(){

        $("#save").click(function(){
            p_name = $("#p_name").val();
            p_client = $("#p_client").val();
            id = $("#p_id").val();
            level = $("#level").val();
            status = $("#status").val();
            hot = $("#hot").val();

            $.ajax({
                type: "POST",
                url: "{{URL::to('/project/editProject')}}",
                data: {p_name: p_name, p_client:p_client, id: id, level:level, status:status, hot:hot},
                success: function(resp){
                    if(resp.status == 'success'){

                    }else{
                        alert('ajax error');
                    }
                }
            })
        })
        
        $("#task_table td").click(function(e){
            var tag = $(this).children();
            tag.first().hide();
            tag.last().show();
        });

        $(".del_task").click(function(e){
            console.log(e);
            task_id = $(this).data('task_id');
            if(!confirm("Are you sure?")) return;
            $.ajax({
                type: "POST",
                url: "{{URL::to('/project/removeTask')}}",
                data: {id: task_id},
                success: function(resp){
                    console.log(resp);
                    if(resp.status == 'success'){
                        // location.reload();
                    }else{
                        alert('ajax error');
                    }
                }
            })
        });

    });
</script>
@endsection
 
 
