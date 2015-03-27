<?php

class CategoryController extends \BaseController {

	function __construct()
	{
		$this->data['menu'] = 'category';
	}

	public function index()
	{
		$this->data['title'] = 'Categories';
		$this->data['scriptIncludes'] = array('colorbox','category_js');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.category.category',$this->data);
	}

	public function getCategoryJson()
	{
		
		$dtFilter		=	getdataTableFilter();
		
		$categoryObj =	new Category();
		$categories  	= 	$categoryObj->getCategoryDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$categories['total_rows'], 'recordsFiltered'=>$categories['total_rows'], 'data'=>array());
		
		if($categories['total_rows'] > 0){
			foreach($categories['categories'] as $category){
				$dtData['data'][] = array($category->category,
										$category->tax,
										$category->total_product,
										$category->total_price,
										'<a  class="lnkBatchEdit" href="'.admin_url().'/categories/edit/'.$category->category_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a> 
										 <a href="javascript:void(0);" class="lnkCategoryDelete" rel="'.admin_url().'/categories/delete/'.$category->category_id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>');
			}
		}
		
		echo json_encode($dtData);
		exit;
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
			$categoryObj->tax			=	Input::get('tax');
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
	

	public function editCategory($categoryId=0){

		$categoryObj 	= 	new Category();
		$propertyObj 	= 	new Property();
		
		if (empty($categoryId))
			return formatMessage('Invalid Request', 'danger');

		$categories  	= 	$categoryObj->getCategoryDetails(array('categoryId'=>$categoryId));
		if($categories['total_rows']==0)
			return formatMessage('Category not found', 'danger', array('resize_popup'=>true));
		$this->data['category_info'] = $categories['categories'][0];
		$this->data['cities']  = Shop::where('status', '=', 'Active')->select('city')->distinct()->get();
		$this->data['properties']  	= 	$categoryObj->getCategoryProperties($categoryId);

		$categoryData = Category::find($categoryId);
		
		if (Request::ajax() && Request::isMethod('post'))
		{
			$categoryData->category = Input::get('category');
			if ($categoryData->category == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			$categoryData->description	=	Input::get('description');
			$categoryData->tax			=	Input::get('tax');
			$categoryData->unit			=	Input::get('ddUnit');
			$categoryData->status		=	'Active';
			$categoryData->updated_by	=	Auth::user()->id;
			$categoryData->updated_at	=	getNow();

			$categoryData->save();

			$formCategoryProperties =	Input::get('properties');
			$dbCategoryProperites   =   array();

			if($this->data['properties']['total_rows'] > 0) {
				foreach ($this->data['properties']['properties'] as $property) {
					if($property->category_property_id!='')
						$dbCategoryProperites[] = $property->property_id;
				}
			}
			

			$formCategoryProperties = (!$formCategoryProperties)?array():explode(',',$formCategoryProperties);

			
			$categoriesToInsert = array_diff($formCategoryProperties, $dbCategoryProperites);
			$categoriesToDelete = array_diff($dbCategoryProperites, $formCategoryProperties);

			if (sizeof($categoriesToInsert) > 0) {
				$categoryBatchInput = array();
				foreach ($categoriesToInsert as  $propertyId) {
					$categoryBatchInput[] = array('category_id'=>$categoryId, 'property_id'=>$propertyId);
				}

				$categoryObj->createCategoryProperties($categoryBatchInput);
			}


			if (sizeof($categoriesToDelete) > 0) {
				$categoryObj->deleteCategoryProperties($categoryId, $categoriesToDelete);
			}
			
			echo json_encode(array('status'=>true,'message'=>''));
			exit;
		}
		$this->data['title'] = 'Edit Category';
		$this->data['scriptIncludes'] = array('validator',  'edit_category_js');
		return View::make('admin.category.edit_category',$this->data);
	}

	/**
	 * Delete a category. This page will be called through ajax.
	 */
	public function deleteCategory($categoryId=0){

		$categoryObj 	= 	new Category();
		
		
		if (empty($categoryId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$categories  	= 	$categoryObj->getCategoryDetails(array('categoryId'=>$categoryId));
		if($categories['total_rows']==0)
			return formatMessage('Category not found', 'danger', array('resize_popup'=>true));
		$this->data['category_info'] = $categories['categories'][0];
		//var_dump($this->data['category_info']);exit;
		if (Request::ajax() && Request::isMethod('post'))
		{
			$categoryData				=	Category::find($categoryId);


			$categoryData['status']			=	'Deleted';
			$categoryData['updated_by']	=	Auth::user()->id;
			$categoryData['updated_at']	=	getNow();

			$categoryData->save();
			echo json_encode(array('status'=>true,'message'=>''));
			exit;
		}
		$this->data['scriptIncludes'] = array('colorbox', 'category_js');
		return View::make('admin.category.delete_category',$this->data);
	}

}
