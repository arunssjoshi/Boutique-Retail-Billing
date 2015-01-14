<?php

class PropertiesController extends \BaseController {

	function __construct()
	{
		$this->data['menu'] = 'properties';
	}

	/**
	 * Show the properties listing page
	 */
	public function index()
	{
		$this->data['title'] = 'properties';
		return View::make('admin.properties.properties',$this->data);
	}

	/**
	 * Get properties as a json object. This page will be called through ajax for datatable.
	 */
	public function getPropertiesJson()
	{
		
		$propertyObj = new Property();
		$properties  = $propertyObj->getPropertiesDetails();
		$dtData = array('draw'=>1, 'recordsTotal'=>$properties['total_rows'], 'recordsFiltered'=>$properties['total_rows'], 'data'=>array());
		
		if($properties['total_rows'] > 0){
			foreach($properties['properties'] as $property){
				$dtData['data'][] = array($property->property,$property->property_options,'ssg');
			}
		}
		
		echo json_encode($dtData);
		exit;
		
	}
}
