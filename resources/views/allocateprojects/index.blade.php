@extends('allocateprojects.base')
@section('action-content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var id;
        $(".user-group").click(function() {
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
                    if(resp.length < 1 ) $(".uproject").html("");                     
                    for ( i = 0 ; i < resp.length; i++){
                        if(resp[i].user_id == id){
                            //old_proj_name.push(resp[i].p_name);
                            if (flag == 0) $(".uproject").html("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                            else $(".uproject").append("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                            flag = 1;
                        }
                    }
                }
            });
        });
        var proj_name = [];
        $(".projects-group").click(function() {
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
                /*if(isSelected % 2 == 0){
                    $(this).css("border", "1px solid black");
                }*/
            }
            console.log(proj_name);
        });
        $("#shift_proj").click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '/allocateprojects/updateproj',
                data: {userid: id, proj_id: proj_name},
                success: function( resp ) {
                    var flag = 0;   
                    $(".uproject").html("");                     
                    for ( i = 0 ; i < resp.length; i++){
                        if(resp[i].user_id == id){
                            //old_proj_name.push(resp[i].p_name);
                            if (flag == 0) $(".uproject").html("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                            else $(".uproject").append("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                            flag = 1;
                        }
                    }
                }
            })
        });
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
                <div class="list-group">
                @foreach ($users as $user)
                    <button type="button" class="list-group-item user-group" data-userid={{ $user->id }}>{{ $user->username }}</button>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    
     <!-- Button Items -->
    <div class="col-lg-3 col-md-3" style="width:30%">
        <div class="card">
            <div class="header">
                <h2>
                    Projects
                </h2>
            </div>
            <div class="body">
                <ul class="list-group uproject">
                    
                </ul>
            </div>
        </div>
    </div>
    <a class="col-lg-1 col-md-1" style="width:5%;margin-left:-30px;padding:60px 30px" id="shift_proj">
        <i class="large material-icons" style="zoom:2">arrow_back</i>
    </a>
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