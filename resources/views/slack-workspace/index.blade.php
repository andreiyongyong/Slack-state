@extends('slack-workspace.base')
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
                      List of workspaces
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('workspaces.create') }}">Add new workspaces</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>NAME</th>
                                  <th>DOMAIN</th>
                                  <th>TOKEN</th>
                                  <th>ACTIONS</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>ID</th>
                                  <th>NAME</th>
                                  <th>DOMAIN</th>
                                  <th>TOKEN</th>
                                  <th>ACTIONS</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($workspaces as $workspace)
                                  <tr>
                                      <td>{{ $workspace->id_ }}</td>
                                      <td>{{ $workspace->name }}</td>
                                      <td>{{ $workspace->domain }}</td>
                                      <td>{{ $workspace->token }}</td>
                                      <td align = 'center'>
                                          <form class="row" method="POST" action="{{ route('workspaces.destroy', ['id' => $workspace->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
{{--                                                @if(Auth::user()->type == '0' || $workspace->id == Auth::user()->id)--}}
                                                    <a href="{{ route('workspaces.edit', ['id' => $workspace->id]) }}" class="btn btn-info waves-effect">
                                                    Update
                                                    </a>
                                                    &nbsp;
                                                {{--@endif--}}
                                                {{--@if ( Auth::user()->type == '0' )--}}
                                                    <button type="submit" class="btn btn-danger waves-effect">
                                                    Delete
                                                    </button>
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
@endsection