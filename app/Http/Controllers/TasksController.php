<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderby('priority', 'ASC')->get();
        $projects = Project::orderby('id', 'ASC')->get();

        return view('tasks', compact('projects', 'tasks'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        // Store values
        Task::create($request->all());
        Session::flash('message', 'Task added!');
        return Redirect::back();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $tasks)
    {

        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'priority' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        // Update values

        $request->request->remove('_token'); // remove property from $request
        $request->request->remove('_method'); // remove property from $request


        DB::table('tasks')
            ->where('id', $request->id)
            ->update($request->all());
        Session::flash('message', 'Task Updated!');
        return Redirect::back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy($tasks)
    {
        //

        Task::find($tasks)->delete();
        Session::flash('message', 'Task Deleted!');
        return Redirect::back();
    }
}
