@extends('allocateprojects.base')
@section('action-content') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(".user-group").click(function() {
            var id = $(this).attr("userid");
            $( ".user-group" ).each(function( index, element ) {
                $(element).css("border", "1px solid #ddd");
            });

            $(this).css("border", "2px solid black");
            
            $.ajax({
                    type: "POST",
                    url: '/allocateprojects/ajaxprofromuser',
                    data: {userid: id},
                    success: function( resp ) {
                        var flag = 0;
                        
                        for ( i = 0 ; i < resp.length; i++){
                            if(resp[i].developer == id){
                                if (flag == 0) $(".uproject").html("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                                else $(".uproject").append("<li class='list-group-item'>"+resp[i].p_name+"</li>");
                                flag = 1;
                            }
                        }
                    }
                });
           
            
        });
    });
</script>
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
    
  <div class="row clearfix">
    <div class="col-lg-4">
        <div class="card">
            <div class="header">
                <h2>
                    Users
                </h2>
            </div>
            <div class="body">
                <div class="list-group">
                @foreach ($users as $user)
                    <button type="button" class="list-group-item user-group" userid={{ $user->id}}>{{ $user->username }}</button>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    
     <!-- Button Items -->
    <div class="col-lg-4">
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
    
    <!-- #END# Button Items -->
    
    <div class="col-lg-4">
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
                                <td>{{ $project->p_name }}</td>
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