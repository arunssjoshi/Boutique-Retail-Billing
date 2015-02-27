<?php
/**
 * @Author: Arun S S <arunssjoshi@gmail.com>
 * @Date:   2015-01-11 10:15:15
 * @Last Modified by:   Arun S S <arunssjoshi@gmail.com>
 * @Last Modified time: 2015-02-27 09:50:26
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
		$this->data['scriptIncludes'] = array('colorbox','properties_js');
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
										  '<a href="javascript:void(0);" class="lnkPropertyEdit" rel="'.admin_url().'/properties/edit/'.$property->property_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a> 
										   <a href="javascript:void(0);" class="lnkPropertyDelete" rel="'.admin_url().'/properties/delete/'.$property->property_id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>');
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
		$this->data['scriptIncludes'] = array('validator', 'add_property_js');
		return View::make('admin.properties.new_property',$this->data);
	}

	/**
	 * Editing a property and its options. This page will be called through ajax on edit submit.
	 */
	public function editProperty($propertyId=0){

		$propertyObj =	new Property();
		
		
		if (empty($propertyId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$properties  	= 	$propertyObj->getPropertiesDetails(array('propertyId'=>$propertyId));
		if($properties['total_rows']==0)
			return formatMessage('Property not found', 'danger', array('resize_popup'=>true));
		$this->data['property_info'] = $properties['properties'][0];
		$this->data['property_options'] = $propertyObj->getPropertyOptions($propertyId);
		
		if (Request::ajax() && Request::isMethod('post'))
		{
			$property = Input::get('property');
			
			$existingOptions 	= json_decode(Input::get('existingOptions'),true);
			$newOptions 		= json_decode(Input::get('newOptions'),true);
			if ($property == '' && sizeof($propertyOptions)<1  && sizeof($newOptions)<1) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			$propertyData				=	Property::find($propertyId);
			if ($propertyData->id){
				$propertyData->property		=	$property;
				$propertyData->updated_by	=	Auth::user()->id;
				$propertyData->updated_at	=	getNow();

				$propertyData->save();
			}
			if(!empty($propertyData->id)) {

				if(sizeof($newOptions) > 0) {
					//$newOptions array will contain new options to be inserted.
					$propertyOptionsInput = array();
					foreach ($newOptions as $option){
						if(trim($option['value'])=='') {
							continue;
						}
						$optionInput['property_id']	=	$propertyData->id;
						$optionInput['option']		=	$option['value'];
						$optionInput['status']		=	'Active';
						$optionInput['created_by']	=	Auth::user()->id;
						$optionInput['created_at']	=	getNow();
						$propertyOptionsInput[] = $optionInput;
					}
					$propertyObj->createPropertyOptions($propertyOptionsInput);
				}
				//$existingOptions array will contains the existing array of values. Now check each value in the $existingOptions array and
				//check the value is null, if null delete that row else update the same row
				foreach ($existingOptions as $option){

					$propertyOptionId 	=	$option['propertyoptionId'];
					$propertyOptionObj = 	PropertyOption::find($propertyOptionId);

					if(!empty($propertyOptionObj->id)) {
						$propertyOptionObj->updated_by	=	Auth::user()->id;
						$propertyOptionObj->updated_at	=	getNow();
						if(trim($option['value'])=='') {
							$propertyOptionObj->status = 'Deleted';
							$propertyOptionObj->save();
							continue;
						} else {
							
							$propertyOptionObj->option		=	$option['value'];
							$propertyOptionObj->save();
						}
					}
					
				}

				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Invalid Property'));
				exit;
			}
			exit;
		}
		$this->data['scriptIncludes'] = array('validator', 'edit_property_js');
		return View::make('admin.properties.edit_property',$this->data);
	}

	function deleteProperty($propertyId=0){

		$propertyObj =	new Property();
		
		
		if (empty($propertyId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$properties  	= 	$propertyObj->getPropertiesDetails(array('propertyId'=>$propertyId));
		if($properties['total_rows']==0)
			return formatMessage('Property not found', 'danger', array('resize_popup'=>true));
		$this->data['property_info'] = $properties['properties'][0];
		$this->data['propertyId'] 		=	 $propertyId;
		if (Request::ajax() && Request::isMethod('post'))
		{
			
			$propertyData				=	Property::find($propertyId);
			if ($propertyData->id){
				$propertyData->status		=	'Deleted';
				$propertyData->updated_by	=	Auth::user()->id;
				$propertyData->updated_at	=	getNow();

				$propertyData->save();
			}
			if(!empty($propertyData->id)) {
				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Invalild Property'));
				exit;
			}
			exit;
		}
		$this->data['scriptIncludes'] = array( 'colorbox','properties_js');
		return View::make('admin.properties.delete_property',$this->data);
	}
}
