<?php

class CategoryController extends \BaseController {

	function __construct()
	{
		$this->data['menu'] = 'category';
	}

	public function index()
	{
		$this->data['title'] = 'Categories';
		$this->data['scriptIncludes'] = array('colorbox','batch_js');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.category.category',$this->data);
	}

	public function newCategory()
	{
		$propertyObj 	= 	new Property();
		$categoryObj 	= 	new Category();
		$this->data['properties']  	= 	$propertyObj->getPropertiesDetails();
		if (Request::ajax() && Request::isMethod('post'))
		{
			$categoryObj->category = Input::get('category');
			if ($categoryObj->category == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			
			$categoryObj->description	=	Input::get('description');
			$categoryObj->unit			=	Input::get('ddUnit');
			$categoryObj->status		=	'Active';
			$categoryObj->created_by	=	Auth::user()->id;
			$categoryObj->created_at	=	getNow();

			$categoryObj->save();
			$newCategoryId =  $categoryObj->id;


			$categoryProperties =	Input::get('properties');

			if($newCategoryId > 0) {
				if(!empty($categoryProperties)) {
					$categoryPropertyInput = array();
					$categoryProperties = explode(',', $categoryProperties);
					foreach ($categoryProperties as $key => $property_id) {
						$categoryPropertyInput[] = array('category_id'=>$newCategoryId, 'property_id'=>$property_id);
					}
					$categoryObj->createCategoryProperties($categoryPropertyInput);
				}
				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Cannot save your data now.'));
				exit;
			}
			exit;
		}
		$this->data['title'] = 'New Category';
		$this->data['scriptIncludes'] = array('validator','add_category_js');
		return View::make('admin.category.new_category',$this->data);
	}
	


}
