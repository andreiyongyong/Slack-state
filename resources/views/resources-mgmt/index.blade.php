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
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('resource-management.create') }}">Add new resource</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>TITLE</th>
                                  <th>URL</th>
                                  <th>CONTENT</th>
                                  <th>TYPE</th>
                                  <th>LEVEL</th>
                                  <th>ACTION</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>TITLE</th>
                                  <th>URL</th>
                                  <th>CONTENT</th>
                                  <th>TYPE</th>
                                  <th>LEVEL</th>
                                  <th>ACTION</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($resources as $resource)
                              <tr>
                                  <td>{{ $resource->title }}</td>
                                  <td>{{ $resource->url }}</td>
                                  <td>{{ $resource->content }}</td>
                                  <td>{{ $resource->type }}</td>
                                  <td>{{ $resource->level }}</td>
                                  <td>
                                      <form class="row" method="POST" action="{{ route('resource-management.destroy', ['id' => $resource->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('resource-management.edit', ['id' => $resource->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                                            Update
                                            </a>
                                            {{--@if ($user->username != Auth::user()->username)--}}
                                            <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
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