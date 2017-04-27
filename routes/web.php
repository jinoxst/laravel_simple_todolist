<?php

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

Route::get('app', function () {
    return view('layouts.app');
});

Route::get('child', function () {
    return view('child');
});


Route::get('user/{id}/profile', ['as' => 'profile', function ($id) {
    return 'profile text'. $id;
}]);

Route::get('profiletest', function () {
    // return route('profile', ['id' => 1]);
    return route('profile', 3);
});

Route::get('/resource_path', function () {
    return resource_path();
});

Route::get('/asset', function () {
    return asset('assets/bootstrap/css/bootstrap.min.css');
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/json_jp', function () {
	$data = DB::select('select * from todos');
	return json_encode($data, JSON_UNESCAPED_UNICODE);
});


Route::group(['prefix' => 'todos'], function() {
	Route::get('', [
		'as' => 'todos.index',
		'uses' => 'TodosController@index',
	]);

	Route::post('', [
		'as' => 'todos.store',
		'uses' => 'TodosController@store',
	]);

	Route::post('{id}/update', [
		'as' => 'todos.update',
		'uses' => 'TodosController@update',
	]);
	Route::put('{id}/title', [
		'as' => 'todos.update-title',
		'uses' => 'TodosController@ajaxUpdateTitle',
	]);

	Route::post('{id}/delete', [
		'as' => 'todos.delete',
		'uses' => 'TodosController@delete',
	]);

	Route::post('{id}/restore', [
		'as' => 'todos.restore',
		'uses' => 'TodosController@restore',
	]);
});