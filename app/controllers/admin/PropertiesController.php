<?php
/**
 * @Author: Arun S S <arunssjoshi@gmail.com>
 * @Date:   2015-01-11 10:15:15
 * @Last Modified by:   Arun S S <arunssjoshi@gmail.com>
 * @Last Modified time: 2015-01-28 10:49:31
 */

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
				$dtData['data'][] = array($property->property,
										  $property->property_options,
										  '<a href="javascript:void(0);" class="lnkPropertyEdit" rel="'.admin_url().'/properties/edit/'.$property->property_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a>');
			}
		}
		
		echo json_encode($dtData);
		exit;
	}

	/**
	 * Show popup for creating new property.  This function will also call through ajax post, on submit.
	 */
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

	/**
	 * Editing a property and its options. This page will be called through ajax on edit submit.
	 */
	public function editProperty($propertyId=0){

		$propertyObj =	new Property();
		return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));
		
		if (empty($propertyId))
			die("Invalid Request");

		$properties  	= 	$propertyObj->getPropertiesDetails(array('propertyId'=>$propertyId));
		if($properties['total_rows']==0)
			die("Property not found");
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
		$this->data['scriptIncludes'] = array('validator', 'edit_property');
		return View::make('admin.properties.edit_property',$this->data);
	}
}
