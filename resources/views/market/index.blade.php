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
                      Marketing
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('market.create') }}">Add Marketing</a>
                      </li>
                  </ul>
              </div>  
   
              <div class="body">
                  <div class="table-responsive">
                      <div>
                        Status: <select id="status">
                            @foreach($status_list as $status)
                                <option value="{{ $status }}">{{ strtoupper($status) }}</option>
                            @endforeach
                        </select>

                        Running: <select id="running">
                            @foreach($running_list as $running)
                                <option value="{{ $running }}">{{ strtoupper($running) }}</option>
                            @endforeach
                        </select>
                      </div>
                      <table id ='DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead> 
                              <tr>
                                  <th>DATE</th>
                                  <th>COUNTRY</th>
                                  <th>Marketing NAME</th>
                                  <th class="hide">Marketing ID</th>
                                  <th>EMAIL</th>
                                  <th>PASSWORD</th>
                                  <th>TALENT</th>
                                  <th>B-DATE</th>
                                  <th>TYPE</th> 
                                  <th>STATUS</th> 
                                  <th>RUNNING</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>DATE</th>
                                  <th>COUNTRY</th>
                                  <th>Marketing NAME</th>
                                  <th class="hide">Marketing ID</th>
                                  <th>EMAIL</th>
                                  <th>PASSWORD</th>
                                  <th>TALENT</th>
                                  <th>B-DATE</th>
                                  <th>LANCER TYPE</th> 
                                  <th>STATUS</th> 
                                  <th>RUNNING</th>
                                  <th></th>
                              </tr>
                          </tfoot>
                          <tbody>

                          @foreach ($markets as $market)
                              <tr>
                                  <td>{{ $market->date }}</td>
                                  <td>{{ $market->country }}</td>
                                  <td>{{ $market->market_name }}</td>
                                  <td class="hide">{{ $market->market_id }}</td>
                                  <td>{{ $market->email }}</td>
                                  <td>{{ $market->password }}</td>
                                  <td>{{ $market->rising_talent }}</td>
                                  <td>{{ $market->bid_date }}</td>
                                  <td>{{ $market->lancer_type }}</td>
                                  @if ($market->status == 'updated')
                                    <td style="color: green;">UPDATED &nbsp;&nbsp;<a href="{{ route('market.doneStatus', ['id' => $market->id]) }}"><button type="button" class="btn btn-primary" style="float: right; ">DONE</button></a></td> 
                                  @elseif ($market->status == 'pending')
                                    <td style="color: red;"><a href="{{ route('market.toggleStatus', ['id' => $market->id]) }}">PENDING &nbsp;&nbsp;</a><a href="{{ route('market.doneStatus', ['id' => $market->id]) }}"><button type="button" class="btn btn-primary" style="float: right;">DONE</button></a></td>
                                  @else
                                    <td style="color: red;">DONE</td>
                                  @endif
                                  @if ($market->status != 'done')
                                  @if ($market->running == false)
                                    <td id="{{ $market->id }}"><a href="{{ route('market.toggleRunState', ['id' => $market->id]) }}"><button type="button" class="btn">RUN</button></a></td>
                                  @else
                                    <td id="{{ $market->id }}"><a href="{{ route('market.toggleRunningState', ['id' => $market->id]) }}"><button type="button" class="btn btn-danger">RUNNING</button></a></td>
                                  @endif
                                  @else
                                  <td style="color: red;">DONE</td>
                                  @endif
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
      <script type="text/javascript">
        $(document).bind('after_ready', function() {
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var status = $("select#status").val();
                var flag1 = (status == '' || status == 'all' || status.toUpperCase() == data[9]);

                var running = $("select#running").val();
                var flag2 = (running == '' || running == 'all' || running.toUpperCase() == data[10]);

                return flag1 && flag2;
            });

            var table = $('#DataTables_Table_0').DataTable({
                "iDisplayLength": 50,
                "bDestroy": true,
            }); 

            $('#status').change(function() {
                table.draw();
            });

            $('#running').change(function() {
                table.draw();
            });
        });
      </script>
  </div> 
@endsection