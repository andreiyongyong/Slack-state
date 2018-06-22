@extends('keywords.base')

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new keyword</h2>
            </div>
            <div class="body">
                <form id="" class="form-horizontal" role="form" method="POST" action="{{ route('keywords.store') }}">
                    {{ csrf_field() }} 
                    <div class="row offset">
                        <div class="col-md-12">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="keyword" id="keyword" value="{{ old('keyword') }}" required>
                                            <label class="form-label">Keyword</label>
                                        </div> 
                                    </div>
                                </div>
                            </div> 

                            <button class="btn btn-primary waves-effect" type="submit">Create</button>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
