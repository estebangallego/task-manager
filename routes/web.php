<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TasksController@index');

//Task routes
Route::post('tasks/store', 'TasksController@store');
Route::delete('tasks/destroy/{id}', 'TasksController@destroy');
Route::patch('tasks/update/{id}', 'TasksController@update');

//Project routes
Route::post('projects/store', 'ProjectsController@store');



