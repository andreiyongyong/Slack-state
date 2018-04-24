@extends('member-log.base')
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
                      TRACK
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                        @if( Auth::user()->type != '1' )
                          <a class="btn btn-primary" href="{{ route('member-log.create') }}">Add New Track</a>
                        @endif
                      </li>
                  </ul>
              </div>
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>DATE</th>
                                  <th>TASK</th>
                                  <th>URL</th>
                                  <th>TRACK HOURS</th>
                                  <th>VALIDATED PERCENTAGE</th>
                                  <th>PENALTY</th>
                                  <th>ACTION</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>DATE</th>
                                  <th>TASK</th>
                                  <th>URL</th>
                                  <th>TRACK HOURS</th>
                                  <th>VALIDATED PERCENTAGE</th>
                                  <th>PENALTY</th>
                                  <th>ACTION</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($member_logs as $memberlog)
                              <tr>
                                  <td>{{ $memberlog->log_date }}</td>
                                  <td>{{ $memberlog->task }}</td>  
                                  <td>{{ $memberlog->url }}</td>
                                  <td>{{ $memberlog->track_hour }}</td>
                                  <td>{{ $memberlog->validated }}</td>
                                  <td>{{ $memberlog->penalty }}</td> 
                                  <td>
                                      <form class="row clear-fix js-sweetalert" id = 'mem_index_delete' method="POST" action="{{ route('member-log.destroy', ['id' => $memberlog->id]) }}" >
                                          <input type="hidden" name="_method"  value="DELETE">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <a href="{{ route('member-log.edit', ['id' => $memberlog->id]) }}" class="btn btn-info waves-effect">
                                            Update
                                          </a>
                                          @if( Auth::user()->type != '1' )
                                          <input type = 'button' class="btn btn-danger waves-effect"  data-type="confirm" value = 'Delete' onclick = 'showConfirmMessage();'> 
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