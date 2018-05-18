@extends('slack-workspace.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Edit workspace</h2>
                @if(isset($message))
                    <h6 style="color: red">{{$message}}</h6>
                @endif
            </div>
            <div class="body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('workspaces.update', ['id' => $workspace->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="id_" id="id_" value="{{ $workspace->id_ }}" required>
                                            <label class="form-label">ID</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">Update</button>
                        </div>
                    </div>
                </form>
                <div class="row clearfix">
                    <div class="col-xs-12">
                        <h3> Workspace Tokens </h3>
                    </div>
                    <div class="col-xs-12">
                        <form id="workspace_tokens" class="form-horizontal" role="form" method="POST" action="{{ route('workspace-tokens.addToken') }}">
                            <input type="hidden" name="_id" value="{{$workspace->id}}">
                            {{ csrf_field() }}
                            <div class="row clearfix">
                                <div class="col-xs-12">
                                    <h5> Add Token </h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div>
                                            <label class="form-label">Admin</label>
                                            <select name="user_id">
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-float">
                                        <div class="form-line type-input-add">
                                            <input type="text" class="form-control" name="token" id="token" value="{{ old('token') }}" required>
                                            <label class="form-label">Token</label>
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
                                    <th>USERNAME</th>
                                    <th>TOKEN</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($workspace->tokens as $token)
                                    <tr>
                                        <td>{{ $token['user_id'] }}</td>
                                        <td>{{ $token['token'] }}</td>
                                        <td align = "center">
                                            <a href="{{ url('/delete-token/'.$token['id']) }}" class="btn btn-danger waves-effect" onclick = "return confirm('Are you sure?')">Delete</a>
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
 
 
