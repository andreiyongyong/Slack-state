 <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>ADVANCED VALIDATION</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <form id="form_advanced_validation" class="form-horizontal" role="form" method="POST" action="{{ route('member-log.store', ['id' => $memberid]) }}" enctype="multipart/form-data">
                    {{ csrf_field() }} 
                    <input type = 'hidden' id = 'member_id' value = '{{$memberid}}'>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="log_date" id="log_date" value="{{ old('log_date') }}" required>
                            <label class="form-label">Date</label>
                        </div>
                        <div class="help-info">YYYY-MM-DD format</div>
                    </div>   
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="url" class="form-control" name="githup_url" id="githup_url" value="{{ old('githup_url') }}"  required>
                            <label class="form-label">Url</label>
                        </div>
                        <div class="help-info">Starts with http://, https://, ftp:// etc</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="task" id="task" min="1" max="200" value="{{ old('task') }}"  required>
                            <label class="form-label">Task</label>
                        </div> 
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" class="form-control" name="update_content" id="update_content" value="{{ old('update_content') }}"  min="1" max="200" required>
                            <label class="form-label">Summary</label>
                        </div> 
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="number" class="form-control" name="track" id="track" value="{{ old('track_hour') }}"  required>
                            <label class="form-label">Track</label>
                        </div>
                        <div class="help-info">Numbers only</div>
                    </div> 
                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Track Detail Data
                    <small>Add for borders on all sides of the table and cells.</small>
                </h2>
                <div class = "col-md-2"> 
                    <input type = 'button' class="recipe-table__add-row-btn btn btn-primary pull-right" value = 'Add Row'>
                </div>
            </div>
            <div class="body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr> 
                            <th>Task</th>
                            <th>Summary</th>
                            <th>Track Hour</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($logdetails as $logdetail)
                        <tr detailid = "{{ $logdetail->id }}"> 
                            <td>{{ $logdetail->task_ }}</td>
                            <td>{{ $logdetail->update_ }}</td>
                            <td>{{ $logdetail->track_ }}</td>
                            <td><button  class="btn btn-danger delete-btn-mem">Delete</button>/td>
                        </tr> 
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>