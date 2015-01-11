<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	
	if (Auth::check())
	{
	    // The user is logged in...
	} else {
		return Redirect::to('login');
	}
	return View::make('hello');
});

Route::any('login', array( 'uses' => 'UserController@login'));
Route::any('admin/dashboard', array( 'uses' => 'DashboardController@dashboard'));
