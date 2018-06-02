@extends('users-mgmt.base') 

@section('action-content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        //when click project list ...
        $("#project").change(function(){
            
            project = $(this).val();
            $.ajax({
                type: "POST",
                url: "{{URL::to('/forum-master/taskfromproj')}}",
                data: {project: project},
                success: function(resp){
                    
                    var html =  '<label class="form-label">Task</label>'
                              + '<select name="task" id="task">';  
                    for ( i = 0 ; i < resp.length; i++){
                        html +=        '<option value="' + resp[i].id+ '">' + resp[i].task_name + '</option>';                 
                    }
                    html +=     '</select>';
                    $(".task-form").html(html);
                    $("#task").selectpicker('refresh');
                }
            })
        })
    });
</script>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 body-container">
        <div class="card">
            <div class="header">
                <h2>Add new forum</h2>
            </div>
            <div class="body">
                <form id="forummaster" class="form-horizontal" role="form" method="POST" action="{{ route('forum-master.store') }}">
                    {{ csrf_field() }} 
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <!-- <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="project" id="project" value="{{ old('project') }}"  min="1" max="100" required>
                                    <label class="form-label">Project</label>
                                </div>
                                <div class="help-info"> Max. 100 characters</div>
                            </div> -->
                            <div>
                                <label class="form-label">Project</label>
                                <select name="project" id="project">
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" >{{$project->p_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="task-form">
                                <label class="form-label">Task</label>
                                <select name="task" id="task">
                                    @foreach($tasks as $task)
                                        <option value="{{$task->id}}">{{$task->task_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="form-group form-float">    
                                <div class="form-line">
                                    <input type="text" class="form-control" name="task" id="task" value="{{ old('task') }}"  min="5" max="191" required>
                                    <label class="form-label">Task</label>
                                </div>
                                <div class="help-info"> Max. 191 characters</div>
                            </div> -->
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <textarea class="form-control" rows="5" name="question"  form="forummaster" id="question" required></textarea>
                                    <label class="form-label">Question</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="date" class="form-control" name="posted_date" id="task" value="{{ old('posted_date') }}"  min="5" max="191" required>
                                    <label class="form-label">Posted date</label>
                                </div>
                                <div class="help-info"> Max. 191 characters</div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary " type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</div> 
@endsection
 
 
