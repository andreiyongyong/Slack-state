@extends('allocateprojects.base')
@section('action-content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var id = 0, proj_name = [];
    $("#DataTables_Table_0_length").children().children().val(25);

    $("#DataTables_Table_1").on('click', '.user-group', function(){
        id = $(this).data("userid");
        $(".user-group").each(function( index, element ) {
            $(element).css("border", "1px solid #ddd");
        });

        $(this).css("border", "2px solid black");
        
        $.ajax({
            type: "POST",
            url: '/allocateprojects/ajaxprofromuser',
            data: {userid: id},
            success: function( resp ) {
                var flag = 0;     
                $(".uproject").html("<li class='list-group-item'>No data available in table</li>");               
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        if (flag == 0) $(".uproject").html("<li class='list-group-item alloc' data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        else $(".uproject").append("<li class='list-group-item alloc' data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        flag = 1;
                    }
                }
            }
        });
    });

    $("#DataTables_Table_0").on('click', '.projects-group', function(){
        if($(this).hasClass("selected")){
            $(this).css("border", "0");
            $(this).removeClass("selected");
            var index = proj_name.indexOf($(this).data('prject_id'));
            proj_name.splice(index, 1);
        }
        else {
            proj_name.push($(this).data('prject_id'));
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
            url: '/allocateprojects/updateproj',
            data: {userid: id, proj_id: proj_name},
            success: function( resp ) {
                var flag = 0;   
                $(".uproject").html("");                     
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        if (flag == 0) $(".uproject").html("<li type='button' class='list-group-item alloc'  data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        else $(".uproject").append("<li type='button' class='list-group-item alloc' data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        flag = 1;
                    }
                }
                location.reload();
            }
        })
    });
    //second table
    var del_proj_name = [];
    $(".uproject").on('click', '.alloc', function(){
        if($(this).hasClass("selected")){
            $(this).css("border", "1px solid #ddd");
            $(this).removeClass("selected");
            var index = del_proj_name.indexOf($(this).data('project_id'));
            del_proj_name.splice(index, 1);
        }
        else {
            
            del_proj_name.push($(this).data('project_id'));

            $(this).addClass("selected");
            $(this).css("border", "2px solid red");
        }
    })

    $("#del_proj").click(function(){
 
        if(id == 0) {
            alert("Please select a user!");
            return;
        }
        if(del_proj_name.length==0){
            alert("Please select a project to delete");
            return;
        }
        $.ajax({
            type:"POST",
            url: '/allocateprojects/del_proj',
            data: {userid : id, del_proj_id: del_proj_name},
            success: function(resp) {
                var flag = 0;   
                $(".uproject").html("");                     
                for ( i = 0 ; i < resp.length; i++){
                    if(resp[i].user_id == id){
                        //old_proj_name.push(resp[i].p_name);
                        if (flag == 0) $(".uproject").html("<li type='button' class='list-group-item alloc' data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        else $(".uproject").append("<li type='button' class='list-group-item alloc'  data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</li>");
                        flag = 1;
                    }
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
                <div class="table-responsive">
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
                                <td class="user-group" data-userid = {{$user->id}}>
                                    @if ( DB::table('allocation')->where([['user_id','=', $user->id],['is_delete','=', '0']])->count() == 0)
                                    <div>
                                        <img class="users-circle" src="{{\App\Http\Controllers\HelperController::getAvatar($user->slack_user_id, $user->workspace_id)}}" width="50" height="50" />
                                        <svg style="float: right" height="20" width="20">
                                    <circle cx="10" cy="13" r="7"  fill="red" />
                                    </svg>{{ $user->workspace_id }}{{" ".$user->username }} </div>
                                    @else
                                    <div>
                                        <img class="users-circle" src="{{\App\Http\Controllers\HelperController::getAvatar($user->slack_user_id, $user->workspace_id)}}" width="50" height="50" />
                                        <svg style="float: right" height="20" width="20">
                                    <circle cx="10" cy="13" r="7"  fill="white" />
                                    </svg>{{ $user->username }} </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="header">
                <h2>
                    Projects
                </h2>
                <button type="button" id="shift_proj" class="btn btn-primary waves-effect" style="position: absolute; right: 100px; top: 15px;">Add</button>
                <button type="button" class="btn btn-danger waves-effect" id="del_proj" style="position: absolute;right:20px;top:15px">Delete
                </button>
            </div>
            <div class="body">
                <ul class="list-group uproject">
                    <li class="list-group-item" style = "background-color: #f9f9f9;">No data available in table</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="header">
                <h2>
                    All Projects
                </h2>
            </div> 
            <div class="body">
                <div class="table-responsive">
                    <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead> 
                            <tr>
                                <th>PROJECT</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>PROJECT</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="projects-group" data-prject_id="{{ $project->id }}">
                                    <div >{{ $project->p_name }}</div>
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