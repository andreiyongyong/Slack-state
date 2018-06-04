@extends('resources-mgmt.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Edit resource</h2>
            </div>
            <div class="body">
                <form class="form-horizontal" id="resource-management" role="form" method="POST" action="{{ route('resource-management.update', ['id' => $resource->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" id="title" value="{{ $resource->name }}"  min="1" max="100" required>
                                    <label class="form-label">Title</label>
                                </div> 
                                <div class="help-info"> Max. 100 characters</div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                     <textarea class="form-control" rows="5" name="content"  form="resource-management" id="content"  required>{{$resource->content }}</textarea>
                                    <label class="form-label">Content</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group form-float">
                                <div>
                                    <label class="form-label">Project</label>
                                    <select name="project" data-live-search="true">
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" {{ $project->id == $resource->project_id ? "selected" : "" }}>{{$project->p_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group form-float">
                                <div>
                                    <label class="form-label">Type</label>
                                    <select name="type">
                                        <option value="2" {{ $resource->type == 2 ? "selected" : "" }}>Developer</option>
                                        <option value="1" {{ $resource->type == 1 ? "selected" : "" }}>Member</option>
                                        <option value="0" {{ $resource->type == 0 ? "selected" : "" }}>Admin</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group form-float">
                                <div>
                                    <label class="form-label">Level </label>
                                    <select name="level">
                                        @for($i=11;$i>0;$i--)
                                            <option value="{{$i}}" {{ $resource->level == $i ? "selected" : "" }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Update</button>
                </form>
                <div class="row clearfix" style="margin-top: 20px">
                    <div class="col-xs-12">
                        <h3> Resource Details </h3>
                    </div>
                    <div class="col-xs-12">
                        <form id="resource-management" class="form-horizontal" role="form" method="POST" action="{{ route('resource-management.addDetail') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_id" value="{{$resource->id}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <h5> Add Details </h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="key" id="title" value="{{ old('key') }}" required>
                                            <label class="form-label">Key</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line type-input-add">
                                            <input type="text" class="form-control" name="value" id="url" value="{{ old('value') }}" required>
                                            <label class="form-label">Value</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Type</label>
                                            <select name="type" class="detial-type-change-add" >
                                                <option value="url">Url</option>
                                                <option value="file">File</option>
                                                <option value="text">Text</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary " type="submit">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <h5> Details List </h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id = 'DataTables_Table_0' class="table table-bordered table-striped table-hover js-resources-metas dataTable">
                                <thead>
                                <tr>
                                    <th>KEY</th>
                                    <th>VALUE</th>
                                    <th>TYPE</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <td>{{ $detail['key'] }}</td>
                                        <td class="type-input">
                                            @if($detail['type'] == 'file')
                                                <input type="file" form="edit-form-{{$detail['id']}}" name="value" value="{{ $detail['value'] }}" required>
                                            @else
                                                <input type="text" form="edit-form-{{$detail['id']}}" name="value" value="{{ $detail['value'] }}" required>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-group form-float">
                                                <select name="type" form="edit-form-{{$detail['id']}}" class="detial-type-change">
                                                    <option value="url" {{ $detail['type'] == 'url' ? "selected" : "" }}>Url</option>
                                                    <option value="file" {{ $detail['type'] == 'file' ? "selected" : "" }}>File</option>
                                                    <option value="text" {{ $detail['type'] == 'text' ? "selected" : "" }}>Text</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td align = "center">
                                            <form id="edit-form-{{$detail['id']}}" method="post" action="{{route('resource-management.editDetail')}}"  enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="{{$resource->id}}">
                                                <input type="hidden" name="key" value="{{$detail['key']}}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-info waves-effect" >Update</button>
                                            </form>

                                            <a href="{{ url('/delete-detail/'.$detail['id']) }}" class="btn btn-danger waves-effect" onclick = "return confirm('Are you sure?')">Delete</a>
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
    </div>
</div> 
@endsection
 
 
