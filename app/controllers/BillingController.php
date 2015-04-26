<?php

class BillingController extends BaseController {
	function __construct()
	{
		$this->data['menu'] = 'Billing';
	}
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

	public function newBill()
	{
		$this->data['title'] = 'New Bill';
		$this->data['scriptIncludes'] = array('validator', 'bill_js');
		return View::make('billing.new-bill',$this->data);
	}

}
