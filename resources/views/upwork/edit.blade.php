@extends('project.base') 

@section('action-content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Marketing</h2> 
            </div>
            <div class="body">
                <form class="form-horizontal" id="upwork" role="form" method="POST" action="{{ route('upwork.update', ['id' => $upwork->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-3"> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-line  focused">
                                    <input type="date" class="form-control focused" name="date" id="date" value="{{$upwork->date}}" required>
                                    <label class="form-label">Date</label>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="country" id="country" value="{{ $upwork->country }}"  min="1" max="200" required>
                                    <label class="form-label">Country</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div>
                        <div class="col-md-3"> 
                        </div>
                    </div>   
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="upwork_name" id="upwork_name" value="{{ $upwork->upwork_name }}"  min="1" max="200" required>
                                    <label class="form-label">Upwork Name</label>
                                </div>  
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="upwork_id" id="upwork_id" value="{{ $upwork->upwork_id }}"  min="1" max="200" required>
                                    <label class="form-label">Upwork Id</label>
                                </div>  
                            </div>
                        </div>  
                    </div> 
                    <div class="row clearfix"> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="email" id="email" value="{{ $upwork->email }}"  min="1" max="200" required>
                                    <label class="form-label">Email</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="password" id="password" value="{{ $upwork->password }}"  min="1" max="200" required>
                                    <label class="form-label">Password</label>
                                </div> 
                                <div class="help-info"> Max. 200 characters</div>
                            </div>
                        </div> 
                    </div> 
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="rising_talent" id="rising_talent" value="{{ $upwork->rising_talent }}"  min="1" max="200" required>
                                    <label class="form-label">Rising Talent</label>
                                </div> 
                                <div class="help-info">top rate , rising talent</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="test" id="test" value="{{ $upwork->test }}" required>
                                    <label class="form-label">Test</label>
                                </div>  
                                <div class="help-info"></div>
                            </div>
                        </div> 
                    </div>  
                    <div class="row clearfix"> 
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line focused">
                                    <input type="date" class="form-control focused" name="bid_date" id="bid_date" value="{{$upwork->bid_date}}" required>
                                    <label class="form-label">Bid Date</label>
                                </div> 
                                <div class="help-info"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="lancer_type" id="lancer_type" value="{{ $upwork->lancer_type }}" required>
                                    <label class="form-label">Freelancer Type</label>
                                </div> 
                                <div class="help-info">ex: developer , graphic designer , translator , writer ,,,</div>
                            </div>
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="security_question" id="security_question"  value="{{ $upwork->security_question }}"  required>
                                    <label class="form-label">Security Question</label>
                                </div>   
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="security_answer" id="security_answer"  value="{{ $upwork->security_answer }}"  required>
                                    <label class="form-label">Security Answer</label>
                                </div>   
                            </div>
                        </div>
                    </div>  
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="series" id="series"  value="{{ $upwork->series }}"  required>
                                    <label class="form-label">Series</label>
                                </div>   
                            </div>
                        </div> 
                    </div>  
                    <button class="btn btn-primary waves-effect" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
