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
		$this->data['scriptIncludes'] = array('colorbox','properties');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.properties.properties',$this->data);
	}

	/**
	 * Get properties as a json object. This page will be called through ajax for datatable.
	 */
	public function getPropertiesJson()
	{
		
		$dtFilter		=	getdataTableFilter();
		
		$propertyObj 	= 	new Property();
		$properties  	= 	$propertyObj->getPropertiesDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$properties['total_rows'], 'recordsFiltered'=>$properties['total_rows'], 'data'=>array());
		
		if($properties['total_rows'] > 0){
			foreach($properties['properties'] as $property){
				$dtData['data'][] = array($property->property,$property->property_options,'ssg');
			}
		}
		
		echo json_encode($dtData);
		exit;
	}

	public function createNewProperty()
	{	
		$propertyObj =	new Property();
		if (Request::ajax() && Request::isMethod('post'))
		{

			$property = Input::get('property');
			
			$propertyOptions = Input::get('option');
			if ($property == '' && sizeof($propertyOptions)<1) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			$propertyInput['property']	=	$property;
			$propertyInput['status']	=	'Active';
			$propertyInput['sort_order']	=	1;
			$propertyInput['created_by']	=	Auth::user()->id;
			$propertyInput['created_at']	=	getNow();

			$newPropertyId = $propertyObj->createProperty($propertyInput);

			if($newPropertyId > 0) {
				$propertyOptionsInput = array();
				foreach ($propertyOptions as $option){
					if(trim($option)=='') {
						continue;
					}

					$optionInput['property_id']	=	$newPropertyId;
					$optionInput['option']		=	$option;
					$optionInput['status']		=	'Active';
					$optionInput['created_by']	=	Auth::user()->id;
					$optionInput['created_at']	=	getNow();
					$propertyOptionsInput[] = $optionInput;
				}
				$propertyObj->createPropertyOptions($propertyOptionsInput);
				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Cannot save your data now.'));
				exit;
			}
			exit;
		}
		$this->data['scriptIncludes'] = array('validator', 'add_property');
		return View::make('admin.properties.new_property',$this->data);
	}

	public function saveNewProperty(){
		var_dump($_POST);
	}
}
