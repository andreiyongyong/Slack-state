@extends('keywords.base')
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
                      List of keywords
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('keywords.create') }}">Add new keyword</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>KEYWORD</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>ID</th>
                                  <th>KEYWORD</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($keywords as $keyword)
                                  <tr>
                                      <td>{{ $keyword->id }}</td>
                                      <td>{{ $keyword->keyword }}</td>
                                      <td align = 'center'>
                                          <form class="row" method="POST" action="{{ route('keywords.destroy', ['id' => $keyword->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-danger waves-effect">
                                                    Delete
                                                    </button>
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