@extends('market.base')
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
                      Markeing
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('market.create') }}">Add Marketing</a>
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
                                  <th>Marketing NAME</th>
                                  <th>Marketing ID</th>
                                  <th>EMAIL</th>
                                  <th>TALENT</th>
                                  <th>B-DATE</th>
                                  <th>TYPE</th> 
                                  <th></th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>DATE</th>
                                  <th>COUNTRY</th>
                                  <th>Marketing NAME</th>
                                  <th>Marketing ID</th>
                                  <th>EMAIL</th>
                                  <th>TALENT</th>
                                  <th>B-DATE</th>
                                  <th>LANCER TYPE</th> 
                                  <th></th>
                              </tr>
                          </tfoot>
                          <tbody>

                          @foreach ($markets as $market)
                              <tr>
                                  <td>{{ $market->date }}</td>
                                  <td>{{ $market->country }}</td>
                                  <td>{{ $market->market_name }}</td>
                                  <td>{{ $market->market_id }}</td>
                                  <td>{{ $market->email }}</td>
                                  <td>{{ $market->rising_talent }}</td>
                                  <td>{{ $market->bid_date }}</td>
                                  <td>{{ $market->lancer_type }}</td> 
                                  <td align = "center">
                                      <form class="row" method="POST" action="{{ route('market.destroy', ['id' => $market->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('market.edit', ['id' => $market->id]) }}" class="btn btn-info waves-effect">
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