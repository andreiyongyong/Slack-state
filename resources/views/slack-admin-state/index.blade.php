@extends('slack-admin-state.base')
@section('action-content') 
<div class="row clearfix">
  <div class="col-sm-6"></div>
  <div class="col-sm-6"></div>
</div> 
  <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
              <div class="header row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <form  method="POST" action="{{route('slack-admin-state.index')}}/active" onsubmit = "return confirm('Are you sure?')">    
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">         
                        <input type="hidden" name="id" value="{{ $id }}">               
                        <input type="hidden" name="workspace_id" value="all">         

                        <div class="form-group form-float">                    
                            <span class="m-r-20" style="display: inline-block;">
                                <label class="form-label">Administrator</label>
                                <select id="userid" name="user" onchange="changeUser()">
                                    @foreach($users as $user)
                                        @if ($user->id == $id)
                                            <option value="{{$user->id}}" selected="selected">
                                        @else
                                            <option value="{{$user->id}}">                                    
                                        @endif
                                            {{$user->username}}
                                        </option>
                                    @endforeach
                                </select>
                            </span>
                            <input type="submit" name="active" value="All active" class="btn btn-info waves-effect m-r-20">
                            <input type="submit" name="active" value="All inactive" class="btn btn-danger waves-effect">
                        </div>
                    </form>
                </div>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>WORKSPACE ID</th>
                                  <th>STATE</th>
                                  <th>ACTIONS</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>WORKSPACE ID</th>
                                  <th>STATE</th>
                                  <th>ACTIONS</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($workspaces as $workspace)
                            <tr>
                                <td>{{ $workspace->id_ }}</td>
                                <td>{{ $workspace->presence }}</td>
                                <td align = 'center'>
                                <form  method="POST" action="{{route('slack-admin-state.index')}}/active" onsubmit = "return confirm('Are you sure?')">    
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">

                                    @if($workspace->presence == 'away')
                                        <input type="submit" name="active" value="Active" class="btn btn-info waves-effect"/>
                                        &nbsp;
                                    @else
                                        <input type="submit" name="active" value="Inactive" class="btn btn-danger waves-effect"/>
                                    @endif
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
@endsection
@section('allocation-scripts')
<script>
    function changeUser() {
        var x = document.getElementById("userid").value;
        var url = "{{ route('slack-admin-state.index') }}";
        url = url + '?id=' + x;
        window.location.href = url;
    }
</script>
@stop
