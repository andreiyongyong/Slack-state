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
                    <div class="col-md-1" style="position: absolute;left: 100px;top: 7px;">
                        <select class="form-control show-tick">
                            <option value="0">All</option>
                            <option value="1">Upcoming</option>
                            <option value="2" selected="selected">Live</option>
                            <option value="3">Hold</option>
                            <option value="4">Closed</option>
                            <option value="5">Deleted</option>
                        </select>
                    </div>
                
                  <ul class="header-dropdown m-r--5" style="position: absolute;top: 7px;">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('project.create') }}">Add new project</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover dataTable">
                          <thead> 
                              <tr>
                                <th></th>
                                <th>PROJECT</th>
                                <th>CLIENT</th>
                                <th>DEVELOPERS</th>
                                <th>TASK</th>
                                <th>LEVEL</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                <th></th>
                                <th>PROJECT</th>
                                <th>CLIENT</th>
                                <th>DEVELOPERS</th>
                                <th>TASK</th>
                                <th>LEVEL</th>
                                <th>STATUS</th>
                                <th>ACTION</th>
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
                                <td>{{ $project['level']}}</td>
                                <td>{{ $project['status']}}</td>
                                <td align = "center">
                                    <form class="row" method="POST" action="{{ route('project.destroy',
                                    ['id' => $project['id']]) }}" onsubmit = "return confirm('Are you sure?')">
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
<script type="text/javascript">
    var mytable;
    $(document).ready(function(){
        mytable = $("#DataTables_Table_0").DataTable();
      $(".input-sm").val(100);  
      $("ul.dropdown-menu li").click(function(){
        status = $(this).text();
        $.ajax({
            type: "POST",
            url: '/project/getfromstatus',
            data: {status : status},
            dataType: "JSON",
            success: function(resp) {

                if (mytable) mytable.clear();
              response = resp.string;

              var result = response.map(function(item){
                  var result = [];
                    result.push("<svg height='20' width='20' style='position: absolute;left: 50px;"
                         + "margin-top: 5px;' ><circle cx='10' cy='10' r='8'  fill='"+item.hot+"'/></svg>");
                    result.push(item.p_name);
                    result.push(item.p_client);
                    result.push(item.developer);
                    result.push(item.task);
                    result.push(item.level);
                    result.push(item.status);
                    result.push("<a href='/project/"+item.id+"/edit'>Edit</a>");
                    result.push("");
                    // .... add all the values required
                  console.log(result);
                    return result;
                });
                mytable.rows.add(result); // add to DataTable instance
                mytable.draw(); // always redraw
            }
        })
      })
    });
</script> 
@endsection