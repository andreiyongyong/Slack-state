@extends('project.base')
@section('action-content') 
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
  <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header">
                  <h2>
                      Project
                  </h2>
                  
                    <div class="col-md-1" style="position: absolute;left: 100px;top: 12px;">
                        <select class="form-control show-tick">
                            <option value="0">All</option>
                            <option value="1">Upcoming</option>
                            <option value="2" selected="selected">Live</option>
                            <option value="3">Hold</option>
                            <option value="4">Closed</option>
                            <option value="5">Deleted</option>
                        </select>
                    </div>
                
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('project.create') }}">Add new project</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead> 
                              <tr>
                                <th></th>
                                <th>PROJECT</th>
                                <th>CLIENT</th>
                                <th>DEVELOPERS</th>
                                <th>TASK</th>
                                <th>STATUS</th>
                                <th></th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                <th></th>
                                <th>PROJECT</th>
                                <th>CLIENT</th>
                                <th>DEVELOPERS</th>
                                <th>TASK</th>
                                <th>STATUS</th>
                                <th></th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($projects as $project)
                              <tr>
                                <td align="center">
                                  <svg height="20" width="20">
                                    <circle cx="10" cy="12" r="8"  fill="{{$project['hot']}}" />
                                  </svg>
                                </td>
                                <td>{{ $project['p_name'] }}</td>
                                <td>{{ $project['p_client'] }}</td>
                                <td><?=$project['developer']?></td>
                                <td>{{ $project['task']}}</td>
                                <td>{{ $project['status']}}</td>
                                <td align = "center">
                                    <form class="row" method="POST" action="{{ route('project.destroy', ['id' => $project['id']]) }}" onsubmit = "return confirm('Are you sure?')">
                                          <input type="hidden" name="_method" value="DELETE">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <a href="{{ route('project.edit', ['id' => $project['id']]) }}" >
                                          Edit
                                          </a>
                                          {{--@if ($user->username != Auth::user()->username)--}}
                                          <!-- <button type="submit" class="btn btn-danger waves-effect">
                                          Delete
                                          </button> -->
                                          {{--@endif--}}
                                      </form>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $("ul.dropdown-menu li").click(function(){
        status = $(this).text();

        $.ajax({
            type: "POST",
            url: '/project/getfromstatus',
            data: {status : status},
            dataType: "JSON",
            success: function(resp) {
              response = resp.string;
              $("tbody").html("");
              for ( i = 0 ; i < response.length; i++){
                $("tbody").append("<tr><td><svg height='20' width='20' style='position: absolute;left: 50px;margin-top: 5px;' ><circle cx='10' cy='10' r='8'  fill='"+response[i].hot+"'/></svg></td><td>"+response[i].p_name+"</td><td>"+response[i].p_client+"</td><td>"+response[i].developer+"</td><td>"+response[i].task+"</td><td>"+response[i].status+"</td><td align = 'center'><a href='{{ route('project.edit', ['id' => $project['id']]) }}' >Edit</a></td></tr>");

              }
            }
        })
      })
    });
</script> 
@endsection