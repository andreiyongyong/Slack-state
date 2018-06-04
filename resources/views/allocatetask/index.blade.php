@extends('allocatetask.base')
@section('action-content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var id = 0, task_ids = [];
    //if click record in first table..
    $("#DataTables_Table_1").on("click", ".user-group", function() {
        task_ids = [];
        var tsk = $("#DataTables_Table_0").find(".tasks-group");
        tsk.removeClass("selected");
        tsk.css("border", "0"); 

        id = $(this).data("userid");
        
        $(".user-group").each(function( index, element ) {
            $(element).css("border", "1px solid #ddd");
        });

        $(this).css("border", "2px solid black");
        
        $.ajax({
            type: "POST",
            url: '/taskallocation/taskfromuser',
            data: {userid: id},
            success: function( resp ) {
                var flag = 0;
                $(".utask").html("<li class='list-group-item' style = 'background-color: #f9f9f9;'>No data available in table</li>");            
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        if (flag == 0) $(".utask").html("<li class='list-group-item alloc' data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        else $(".utask").append("<li class='list-group-item alloc' data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        flag = 1;
                    }
                }
            }
        });
    });

    $("#DataTables_Table_0").on("click", ".tasks-group", function() {
        if($(this).hasClass("selected")){
            $(this).css("border", "0");
            $(this).removeClass("selected");
            var index = task_ids.indexOf($(this).data('task_id'));
            task_ids.splice(index, 1);
        }
        else {
            task_ids.push($(this).data('task_id'));
            $(this).addClass("selected");
            $(this).css("border", "1px solid black");
        }

    });
    
    $("#shift_proj").click(function(e){
        e.preventDefault();
        if(id == 0) {
            alert("Please select a user!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{URL::to('/taskallocation/updatetask')}}",
            data: {userid: id, task_ids: task_ids},
            success: function( resp ) {
                var flag = 0;   
                $(".utask").html("");                     
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        if (flag == 0) $(".utask").html("<li class='list-group-item alloc'  data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        else $(".utask").append("<li class='list-group-item alloc' data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        flag = 1;
                    }
                }
            }
        })
    });
    //when click record in second table...
    var del_task_ids = [];
    $(".utask").on('click', '.alloc', function(){
        if($(this).hasClass("selected")){
            $(this).css("border", "1px solid #ddd");
            $(this).removeClass("selected");
            var index = del_task_ids.indexOf($(this).data('task_id'));
            del_task_ids.splice(index, 1);
        }
        else {
            del_task_ids.push($(this).data('task_id'));
            $(this).addClass("selected");
            $(this).css("border", "2px solid red");
        }
    })

    $("#del_proj").click(function(){
 
        if(id == 0) {
            alert("Please select a user!");
            return;
        }
        if(del_task_ids.length==0){
            alert("Please select a task to delete");
            return;
        }
        $.ajax({
            type:"POST",
            url: '{{URL::to("/taskallocation/del_task")}}',
            data: {userid : id, del_task_ids: del_task_ids},
            success: function(resp) {
                var flag = 0;   
                $(".utask").html("");                     
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        if (flag == 0) $(".utask").html("<li class='list-group-item alloc' data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        else $(".utask").append("<li class='list-group-item alloc'  data-task_id =  "+resp[i].task_id+">"+resp[i].task_name+"</li>");
                        flag = 1;
                    }
                }
            }
        })
    })
    //when click project list...
    $(".show-tick").change(function(){
        project = $(this).val();
        //alert(project);
        $.ajax({
            type: "POST",
            url: '{{URL::to("/taskallocation/taskfromproj")}}',
            data: {project : project},
            success: function(resp) {
                var flag = 0;   

                $("#tasks").html("<tr><td style = 'background-color: #f9f9f9;'>No data available in table</td></tr>");  
                for ( i = 0 ; i < resp.length; i++){
                    if (flag == 0) $("#tasks").html("<tr><td class='tasks-group alloc' data-task_id="+resp[i].id +">"+resp[i].task_name+"</td></tr>");
                    else $("#tasks").append("<tr><td class='tasks-group alloc'  data-task_id =  "+resp[i].id+">"+resp[i].task_name+"</td></tr>");
                    flag = 1;
                
                }
            }
        })
    })
});
</script>
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
    
<div class="row clearfix">
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="header">
                <h2>
                    Users
                </h2>
            </div>
            <div class="body">
                <table id = 'DataTables_Table_1' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                    <thead>
                        <tr>
                            <th>USER</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>USER</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="list-group-item user-group" data-userid={{ $user->id }}>
                                <div ><img class="users-circle" src="{{\App\Http\Controllers\HelperController::getAvatar($user->slack_user_id, $user->workspace_id)}}"
                                           width="50" height="50" /> {{ $user->workspace_id }}&nbsp;&nbsp;&nbsp;&nbsp;{{$user->username }}</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="header">
                <h2>
                    Tasks
                </h2>
                <button type="button" id="shift_proj" class="btn btn-primary waves-effect" style="position: absolute; right: 100px; top: 15px;">Add</button>
                <button type="button" class="btn btn-danger waves-effect" id="del_proj" style="position: absolute;right:20px;top:15px">Delete
                </button>
            </div>
            <div class="body">
                <ul class="list-group utask">
                    <li class="list-group-item" style = "background-color: #f9f9f9;">No data available in table</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- <a class="col-lg-1 col-md-1" style="width:5%;margin-left:-30px;padding:60px 30px; cursor: pointer;" id="shift_proj">
        <i class="large material-icons" style="zoom:2">arrow_back</i>
    </a> -->
    

    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="header">
                <h2 style="float: left; margin-top: 10px;">
                    Task List For
                </h2>
                <!-- all project list -->
                <div style="padding-left: 300px;">
                    <select class="form-control show-tick" data-live-search="true">
                        <option value="0">All Projects</option>
                        @foreach ($projects as $project)
                            <option value="{{ $loop->index + 1 }}">{{ $project->p_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div> 
            <div class="body">
                <div class="table-responsive">
                    <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead> 
                            <tr>
                                <th>TASK</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>TASK</th>
                            </tr>
                        </tfoot>
                        <tbody id="tasks">
                        @foreach ($tasks as $task)
                            <tr>
                                <td class="tasks-group" data-task_id="{{ $task->id }}">
                                    <div >{{ $task->task_name }}</div>
                                </td>
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