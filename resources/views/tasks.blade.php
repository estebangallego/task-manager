@extends('layouts.app')

@section('title', 'Coalition Tasks' )

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="text-center alert alert-success">{{ Session::get('message') }}</div>
        @elseif (Session::has('error'))
            <div class="text-center alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="row">
            <h1>Coalition Task Manager</h1>
            <p>Let's begin creating a project, then add a task to it.</p>
        </div>
            <div class="row">
                <form action="projects/store" method="POST" >
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-6">
                            <input type="text" name="name" id="project-name" class="form-control" placeholder="Project Name">
                        </div>
                        <div class="col-md-6 form-group">
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </div>

                </form>
            </div>
        <div class="row">
            <form action="tasks/store" method="POST" >
                @csrf
                <div class="row form-group">
                    <div class="col-md-3">
                        <input type="text" name="name" id="task-name" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="priority" id="selector">
                            <option value="3">Priority</option>
                            <option value="0">High</option>
                            <option value="1">Medium</option>
                            <option value="2">Low</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="project_id" id="selector">
                            @foreach($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </div>

            </form>
        </div>
        <hr>
        <div class="row">
            @if (count($projects) > 0)
                <h3>Projects</h3>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($projects as $project)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{$project->id}}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $project->id}}" aria-expanded="true" aria-controls="collapse{{ $project->id}}">
                                        {{ $project->name }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{ $project->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$project->id}}">
                                <div class="panel-body">
                                   <ol>
                                       @foreach($tasks as $project_task)
                                           @if( $project_task->project_id == $project->id)
                                                <li>{{$project_task->name}}</li>
                                           @endif
                                       @endforeach
                                   </ol>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>



            @else
                <h3>No Projects available!</h3>
            @endif
        </div>
        <div class="row">
            @if (count($tasks) > 0)
                <h3>Tasks</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Name</th>
                        <th>Priority</th>
                        <th>Project</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <th>{{$task->id}}</th>
                            <td>{{ $task->name }}</td>
                            <td>
                                @if ($task->priority == 0)
                                    High
                                @elseif ($task->priority == 1)
                                    Medium
                                @elseif ($task->priority == 2)
                                    Low
                                @elseif ($task->priority == 3)
                                    Not Assigned
                                @endif
                            </td>
                            <td>
                                @foreach($projects as $project_name)
                                    @if($project_name->id == $task->project_id)
                                        {{ $project_name->name  }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Button trigger modal -->
                                        <button type="button" data-toggle="modal" data-target="#modal{{ $task->id }}">
                                            <i class="fa fa-edit" /></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="modal{{ $task->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modal{{ $task->id }}Label">Edit Task</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ url('tasks/update', $task->id) }}" method="POST">
                                                        <div class="modal-body">

                                                            @csrf
                                                            @method('PATCH')

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="text" name="name" value="{{ $task->name }}" class="form-control" placeholder="Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <select class="form-control" name="priority" id="selector">
                                                                            <option value="{{ $task->priority }}">
                                                                                @if ($task->priority == 0)
                                                                                    High
                                                                                @elseif ($task->priority == 1)
                                                                                    Medium
                                                                                @elseif ($task->priority == 2)
                                                                                    Low
                                                                                @elseif ($task->priority == 3)
                                                                                    Not Assigned
                                                                                @endif
                                                                            </option>
                                                                            <option value="0">High</option>
                                                                            <option value="1">Medium</option>
                                                                            <option value="2">Low</option>
                                                                            <option value="3">Not Assigned</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select class="form-control" name="project_id" id="selector">
                                                                        @foreach($projects as $project)
                                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <form action="/tasks/destroy/{{ $task->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="_method" value="DELETE" />
                                            <button type="submit"><i class="fa fa-trash" /></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @else
                <h3>No tasks available!</h3>
            @endif
        </div>
    </div>
@endsection
