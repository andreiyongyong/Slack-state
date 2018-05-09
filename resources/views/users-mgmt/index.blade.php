@extends('users-mgmt.base')
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
                      List of users
                  </h2>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr> 
                                  <th>USERNAME</th>
                                  <th>EMAIL</th>
                                  <th>FIRSTNAME</th>
                                  <th>LASTNAME</th> 
                                  <th>TYPE</th>
                                  <th>LEVEL</th>
                                  <th>ACTION</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr> 
                                  <th>USERNAME</th>
                                  <th>EMAIL</th>
                                  <th>FIRSTNAME</th>
                                  <th>LASTNAME</th>
                                  <th>TYPE</th>
                                  <th>LEVEL</th>
                                  <th>ACTION</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($users as $user)
                              @if($user->userinfo !== null)
                                  <tr>
                                      <td><img class="users-circle" src="{{ $user->image ? asset ("/image/".$user->image) :  asset ("/image/user_temp.jpg") }}" width="50" height="50" />&nbsp;{{ $user->username }}</td>
                                      <td>{{ $user->email }}</td>
                                      <td>{{ $user->firstname }}</td>
                                      <td>{{ $user->lastname }}</td>
                                      <td>{{ $user->type }}</td>
                                      <td>{{ $user->level }}</td>
                                      <td align = 'center'>
                                          <form class="row" method="POST" action="{{ route('user-management.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                              <input type="hidden" name="_method" value="DELETE">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <a href="{{ route('workspaces.connection', ['id' => $user->id]) }}" class="btn btn-info waves-effect">
                                                  Slack
                                              </a>
                                              @if(Auth::user()->type == '0' || $user->id == Auth::user()->id)
                                                  <a href="{{ route('user-management.edit', ['id' => $user->id]) }}" class="btn btn-info waves-effect">
                                                      Update
                                                  </a>
                                                  &nbsp;
                                              @endif
                                              @if ( Auth::user()->type == '0' )
                                                  <button type="submit" class="btn btn-danger waves-effect">
                                                      Delete
                                                  </button>
                                              @endif
                                          </form>
                                      </td>
                                  </tr>
                              @endif
                          @endforeach 
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div> 
  </div> 
@endsection