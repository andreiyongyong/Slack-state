@extends('upwork.base')
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
                      Upwork
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('upwork.create') }}">Add new upwork</a>
                      </li>
                  </ul>
              </div>  
   
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead> 
                              <tr>
                                  <th>DATE</th>
                                  <th>COUNTRY</th>
                                  <th>UPWORK NAME</th>
                                  <th>UPWORK ID</th>
                                  <th>EMAIL</th>
                                  <th>RISING TALENT</th>
                                  <th>BID DATE</th>
                                  <th>LANCER TYPE</th> 
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>DATE</th>
                                  <th>COUNTRY</th>
                                  <th>UPWORK NAME</th>
                                  <th>UPWORK ID</th>
                                  <th>EMAIL</th>
                                  <th>RISING TALENT</th>
                                  <th>BID DATE</th>
                                  <th>LANCER TYPE</th> 
                              </tr>
                          </tfoot>
                          <tbody>

                          @foreach ($upworks as $upwork)
                              <tr>
                                  <td>{{ $upwork->date }}</td>
                                  <td>{{ $upwork->country }}</td>
                                  <td>{{ $upwork->upwork_name }}</td>
                                  <td>{{ $upwork->upwork_id }}</td>
                                  <td>{{ $upwork->email }}</td>
                                  <td>{{ $upwork->rising_talent }}</td>
                                  <td>{{ $upwork->bid_date }}</td>
                                  <td>{{ $upwork->lancer_type }}</td> 
                                  <td align = "center">
                                      <form class="row" method="POST" action="{{ route('upwork.destroy', ['id' => $upwork->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('upwork.edit', ['id' => $upwork->id]) }}" class="btn btn-info waves-effect">
                                            Update
                                            </a>
                                            {{--@if ($user->username != Auth::user()->username)--}}
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