<?php

class PropertiesController extends \BaseController {

	function __construct()
	{
		$this->data['menu'] = 'properties';
	}

	public function index()
	{
		
		return View::make('admin.properties.properties',$this->data);
	}


}
