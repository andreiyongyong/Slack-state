@extends('member-log.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>CREATE TRACK DETAILS</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a> 
                    </li>
                </ul>
            </div>
            <div class="body">
                <form id="memform_create" class="form-horizontal" role="form" method="POST" action="{{ route('member-log.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <input type = 'hidden' id = 'member_id' name = 'member_id' value = '{{$memberid}}'>
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="date" class="form-control focused" name="log_date" id="log_date" value="{{ old('log_date') }}" required>
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
                                    <input type="url" class="form-control" name="url" id="url" value="{{ old('url') }}"  required>
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
                                    <input type="text" class="form-control" name="penalty" id="penalty" value="{{ old('penalty') }}"  required>
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
                                    <input type="number" class="form-control" name="validated" id="validated" min="1" max="100" value="{{ old('validated') }}"  required>
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
                                    <input type="text" class="form-control" name="task" id="task" min="1" max="100" value="{{ old('task') }}"  required>
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
                                    <input type="number" class="form-control" name="track_hour" id="track_hour" value="{{ old('track_hour') }}"  required>
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
                                    <input type="text" class="form-control" name="summary" id="summary" value="{{ old('summary') }}"  min="1" max="200" required>
                                    <label class="form-label">Summary</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Save</button>
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
                    Create Track Detail Data
                    <small>Add for borders on all sides of the table and cells.</small>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown"> 
                        <button type="button" id="add_track_detail" class="btn bg-cyan waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Add Track Detail</button>
                        <!--<input type = 'button' class="recipe-table__add-row-btn btn btn-primary pull-right" value = 'Add Track Detail'>--> 
                    </li>
                </ul> 
            </div>
            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <form id="modal_form" action="{{ route('ajaxImageUpload') }}" enctype="multipart/form-data" method="POST">
                    <input type="hidden" id="m_id" name = "m_id" value="{{$memberid}}">
                    {{ csrf_field() }} 
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">TRACK DETAIL PUT</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-float"> 
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="task_" id="task_" min="1" max="50" value="{{ old('task_') }}"  required>
                                            <label class="form-label">Task</label>
                                        </div> 
                                        <div class="help-info"> Max. 50 characters</div>
                                    </div> 
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="track_" id="track_" value="{{ old('track_') }}"  required>
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
                                            <input type="text" class="form-control" name="update_" id="update_" value="{{ old('update_') }}"  min="1" max="100" required>
                                            <label class="form-label">Summary</label>
                                        </div> 
                                        <div class="help-info"> Max. 100 characters</div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="avatar" class="col-md-4 control-label" >Screen Shot</label>
                                        <div class="col-md-6">
                                            <input type="file" id="screen_" name="screen_" required >
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="save_track_detail" class="btn btn-link waves-effect">SAVE</button>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>  
@endsection
 
 