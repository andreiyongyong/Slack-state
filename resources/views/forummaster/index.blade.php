@extends('forummaster.base')
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
                      List of Forums
                  </h2>
                  <ul class="header-dropdown m-r--5">
                      <li class="dropdown">
                          <a class="btn btn-primary" href="{{ route('forum-master.create') }}">Add new forum</a>
                      </li>
                  </ul>
              </div> 
              <div class="body">
                  <div class="table-responsive">
                      <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-basic-example dataTable">
                          <thead>
                              <tr>
                                  <th>PROJECT</th>
                                  <th>TASK</th>
                                  <th>QUESTION</th>
                                  <th>POSTED DATE</th>
                                  <th>ACTION</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>PROJECT</th>
                                  <th>TASK</th>
                                  <th>QUESTION</th>
                                  <th>POSTED DATE</th>
                                  <th>ACTION</th>
                              </tr>
                          </tfoot>
                          <tbody>
                          @foreach ($forummaster as $forum)
                              <tr>
                                  <td>{{ $forum->project_info->p_name }}</td>
                                  <td>{{ $forum->task }}</td>
                                  <td>{{ $forum->question }}</td>
                                  <td>{{ $forum->posted_date }}</td>
                                  <td align = "center">
                                      <form class="row" method="POST" action="{{ route('forum-master.destroy', ['id' => $forum->id]) }}" onsubmit = "return confirm('Are you sure?')">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <a href="{{ route('forum-master.show', ['id' => $forum->id]) }}" class="btn btn-success waves-effect">
                                              View
                                            </a>
                                            <a href="{{ route('forum-master.edit', ['id' => $forum->id]) }}" class="btn btn-info waves-effect">
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