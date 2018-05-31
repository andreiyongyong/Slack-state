@extends('template.base')
@section('message-templates-scripts')
    <script src="{{ asset ("/js/message-templates.js") }}"></script>
@stop
@section('action-content')
    <div class="row clearfix">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
            <div class="card">
                <div class="header">
                    <h2>
                        Message Templates
                    </h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-xs-12">
                            <button id="add-template-modal" class="btn btn-primary">Add</button>
                            <button id="delete-template" class="btn btn-danger">Remove</button>
                        </div>
                        <div class="col-xs-12">
                            <span class="msg-notify"></span>
                        </div>
                        <div class="modal fade" id="addTempModal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h4>Create Template</h4>
                                        </div>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" id="new-title" name="title" placeholder="title...">
                                        </div>
                                        <div class="col-xs-2">
                                            <button id="add-template" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 temp-container">
                            @foreach($templates as $template)
                                <div class="col-xs-12 template-block" data-id="{{$template->id}}">
                                    {{$template->title}}
                                </div>
                            @endforeach
                        </div>
                        <div class="col-sm-9 col-xs-12 current-template">
                            <div class="col-xs-12">
                                <textarea id="temp-message" class="form-control" style="height: 300px;"></textarea>
                            </div>
                            <div class="col-xs-12 text-right">
                                <button id="save-template" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="loading-block display-none">
                </div>
            </div>
        </div>
    </div>
@endsection