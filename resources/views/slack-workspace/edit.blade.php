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
                                            <input type="text" class="form-control" name="token" id="token" value="{{ $workspace->token }}" required>
                                            <label class="form-label">Workspace Token</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary waves-effect" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
