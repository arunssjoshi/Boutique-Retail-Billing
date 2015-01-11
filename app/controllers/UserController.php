<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function login()
	{	
		//echo Hash::make('admin123');
		echo Input::get('userid');
		if (Auth::attempt(array('email' => Input::get('userid'), 'password' => Input::get('password'), 'status'=>'Active')))
		{
		    if (Auth::user()->role == 'Admin' ) {
		    	return Redirect::to('admin/dashboard');
		    } else {
		    	return Redirect::to('dashboard');
		    }
		} else {

		}
		return View::make('user.login');
	}

}
