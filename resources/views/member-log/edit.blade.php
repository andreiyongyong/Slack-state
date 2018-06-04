@extends('member-log.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>UPDATE TRACK DETAILS</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a> 
                    </li>
                </ul>
            </div>
            <div class="body">
                <form class="form-horizontal" id = "memform_edit" role="form" method="POST" action="{{ route('member-log.update', ['id' => $member_logs->id]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}  

                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="member_id" value="{{$member_logs->id}}">
                    <input type="hidden" id="hint_update" value="{{$member_logs->id}}">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <!-- <input type="text" class="form-control focused" name="log_date" id="log_date" value="{{ $member_logs->log_date }}" required> -->
                                    <input type="date" class="form-control focused" name="log_date" id="log_date" value="{{ $member_logs->log_date }}" required>
                                    <label class="form-label">Date</label>
                                </div>
                                <div class="help-info">YYYY-MM-DD format</div>
                            </div>  
                        </div>
                        <div class="col-md-2">
                             
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                @if( Auth::user()->type != '1' )
                                    <input type="url" class="form-control" name="url" id="url" value="{{ $member_logs->url }}"  required>
                                @else
                                    <input type="url" class="form-control" name="url" id="url" value="{{ $member_logs->url }}" readonly  required>
                                @endif
                                    <label class="form-label">Url</label>
                                </div>
                                <div class="help-info">Starts with http://, https://, ftp:// etc</div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix"> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="penalty" id="penalty" value="{{  $member_logs->penalty}}"  required>
                                    <label class="form-label">Penalty</label>
                                </div>
                                <div class="help-info"> Max. 200 characters</div> 
                            </div>
                        </div>
                        <div class="col-md-2">
                             
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" class="form-control" name="validated" id="validated" min="1" max="100" value="{{  $member_logs->validated  }}"  required>
                                    <label class="form-label">Validated Percentage</label>
                                </div> 
                                <div class="help-info">Numbers only</div>
                            </div> 
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-md-4">  
                            <div class="form-group form-float">
                                <div class="form-line">   
                                @if($member_logs->task != $member_log_temps['tot_task'] )
                                    <input type="text" class="form-control" name="task" id="task" min="1" max="100" value="{{ $member_log_temps['tot_task'] }}" readonly  required>
                                @else
                                    <input type="text" class="form-control" name="task" id="task" min="1" max="100" value="{{ $member_logs->task }}" readonly  required>
                                @endif
                                    <label class="form-label">Task</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div> 
                        </div>
                        <div class="col-md-4">
                             
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    @if($member_logs->track != $member_log_temps['tot_track'] )
                                        <input type="number" class="form-control" name="track_hour" id="track_hour" value="{{ $member_log_temps['tot_track'] }}" readonly  required>
                                    @else
                                        <input type="number" class="form-control" name="track_hour" id="track_hour" value="{{ $member_logs->track_hour }}" readonly required>
                                    @endif
                                    
                                    <label class="form-label">Track Hour</label>
                                </div>
                                <div class="help-info">Numbers only</div>
                            </div>
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                @if($member_log_temps['tot_update'] != $member_logs->summary )  
                                    <input type="text" class="form-control" name="summary" id="summary" value="{{ $member_log_temps['tot_update'] }}"  min="1" max="200" readonly required>
                                @else
                                    <input type="text" class="form-control" name="summary" id="summary" value="{{ $member_logs->summary }}"  min="1" max="200" readonly required>
                                @endif
                                 
                                    <label class="form-label">Summary</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header button-demo js-modal-buttons">
                <h2>
                    Update Track Detail Data
                    <small>Add for borders on all sides of the table and cells.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown"> 
                    @if( Auth::user()->type != '1' )
                        <button type="button" id="add_track_detail" class="btn bg-cyan waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Track Detail</button>
                    @endif
                    </li>
                </ul> 
            </div>
            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        
                    <form id="modal_form" action="{{ route('ajaxImageUpload') }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }} 
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">TRACK DETAIL PUT</h4>
                        </div>
                        <div class="modal-body">
                            
                            <input type="hidden" id="m_id" name = "m_id" value="{{$member_logs->id}}">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float"> 
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="task_" id="task_" min="1" max="50" value=""  required>
                                            <label class="form-label">Task</label>
                                        </div> 
                                        <div class="help-info">Max. 50 characters</div>
                                    </div> 
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="track_" id="track_" value=""  required>
                                            <label class="form-label">Track Hour</label>
                                        </div>
                                        <div class="help-info">Numbers only</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="update_" id="update_" value=""  min="1" max="100" required>
                                            <label class="form-label">Summary</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="file" class="col-md-4 control-label" >Screen Shot</label>
                                        <div class="col-md-6">
                                            <input type="file" id="screen_" name="screen_" required >
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        
                        </div>
                        <div class="modal-footer"> 
                            <button type="submit" id="save_track_detail" class="btn btn-link waves-effect save_track_detail" >SAVE</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>  

                    </div>
                </div>
            </div> 
            <div class="body table-responsive">
                <table class="table table-bordered"  id = 'member_log_table'>
                    <thead>
                        <tr> 
                            <th width = '10%'>Task</th>
                            <th width = '40%'>Summary</th>
                            <th width = '10%'>Track Hour</th>
                            <th width = '30%'>Screen Shot</th>
                            <th width = '10%'></th>
                        </tr>
                    </thead>
                    <tbody id="detail_content">
                    @foreach ($logdetails as $logdetail)
                        <tr id = '{{ $logdetail->id }}'> 
                            <td>{{ $logdetail->task_ }}</td>
                            <td>{{ $logdetail->update_ }}</td>
                            <td>{{ $logdetail->track_ }}</td>  
                            <td align = 'center'><img src = "{{asset ("/upload_img/".$logdetail->screen_)}}" width="150px" height="70px" class = 'img-thumbnail-small-width'></td>
                            <td>
                            @if( Auth::user()->type != '1' )
                                <button id = "view_track_detail" type="button" class="btn bg-cyan waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal" onclick = "onViewTrackDetail({{ $logdetail->id }})">View</button>
                                <button  class="btn btn-danger waves-effect delete-btn-mem">Delete</button>
                            @endif
                            </td>
                        </tr> 
                    @endforeach  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
<div id="myModal" class="modal_image_display">
  <span id="span_close" class="close">×</span>
  <img class="modal-content-image-display" id="modalImg">
  <div id="caption"></div>
</div>
@endsection
