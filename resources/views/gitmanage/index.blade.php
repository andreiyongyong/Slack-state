@extends('gitmanage.base')
@section('action-content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var git_username, repos_name = [];

    //when you select a user, it takes this user's repositories from one owner
    $(".user-group").click(function() {
        git_username = $(this).data("gitname");
        $(".user-group").each(function( index, element ) {
            $(element).css("border", "1px solid #ddd");
        });

        $(this).css("border", "2px solid black");
        
        $.ajax({
            type: "POST",
            url: '/gitmanage/ajaxrepofromuser',
            data: { git_username: git_username },
            dataType:"json",
            success: function( resp ) {

                $(".uproject").html('');   
                for ( i = 0 ; i < resp.length; i++){

                    if(resp[i].owner.login == "{{ env('GITHUB_USERNAME') }}")
                        $(".uproject").append("<li class='list-group-item' data-owner=  "+resp[i].owner.login+">"+resp[i].name+"</li>");
    
                }
            }
        });
    });

    // if click third table...
    $(".projects-group").click(function() {
        if($(this).hasClass("selected")){
            $(this).css("border", "0");
            $(this).removeClass("selected");
            var index = repos_name.indexOf($(this).data('reposname'));
            repos_name.splice(index, 1);
        }
        else {
            repos_name.push($(this).data('reposname'));
            $(this).addClass("selected");
            $(this).css("border", "1px solid black");
        }

    });

    //if click arrow button...
    $("#shift_proj").click(function(e){
        e.preventDefault();
        if(git_username == '' || git_username == null) {
            alert("Please select a user!");
            return;
        }
        $.ajax({
            type: "POST",
            url: '/gitmanage/updaterepos',
            data: {git_username: git_username, repos_name: repos_name},
            dataType : "json",
            success: function( resp ) {
                console.log(resp);
                if(resp.status='error') {
                    alert(resp.status);
                    return;
                }
                else {
                    
                    for ( i = 0 ; i < resp.length; i++){
                     
                            //old_proj_name.push(resp[i].p_name);
                        $(".uproject").append("<li class='list-group-item' data-owner =  "+resp[i].inviter.login+">"+resp[i].repository.name+"</li>");
                  
                    }
                }
            }
        })
    });

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
                        if (flag == 0) $(".uproject").html("<button type='button' class='list-group-item alloc' data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</button>");
                        else $(".uproject").append("<button type='button' class='list-group-item alloc'  data-project_id =  "+resp[i].project_id+">"+resp[i].p_name+"</button>");
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
                <div class="list-group">
                @foreach ($users as $user)
                    <button type="button" class="list-group-item user-group" data-gitname="{{ $user->github_username }}">{{ $user->username }}</button>
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
                    Repositories
                </h2>
                <button type="button" class="btn btn-danger waves-effect" id="del_proj" style="position: absolute;right:15px;top:15px">Delete
                </button>
            </div>
            <div class="body">
                <ul class="list-group uproject">
                    <li class="list-group-item" style = "background-color: #f9f9f9;">No data available in table</li>
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
                    All Repositories
                </h2>
            </div> 
            <div class="body">
                <div class="table-responsive">
                    <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead> 
                            <tr>
                                <th>REPOSITORY</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($repos as $repo)
                            <tr>
                                <td class="projects-group" data-reposname = "{{ $repo['name'] }}">
                                    {{ $repo['name'] }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>REPOSITORY</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div> 
    
  </div>
    
@endsection