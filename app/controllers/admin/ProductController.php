<?php

class ProductController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('admin.product.product');
	}


	public function newProduct()
	{
		$propertyObj 	= 	new Property();
		$categoryObj 	= 	new Category();
		$batchObj 		= 	new Batch();
		$productObj 		= 	new Product();

		
		$this->data['shops']  		= 	$batchObj->getBatchShopDetails(1);
		$this->data['categories']	= 	$categoryObj->getCategoryDetails();
		$this->data['properties']  	= 	$propertyObj->getPropertiesDetails();
		if (Request::ajax() && Request::isMethod('post'))
		{
			
			if (Input::get('product') == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}	
			
			
			

			$duplicates = (is_numeric(Input::get('duplicate')) && Input::get('duplicate') > 1) ?Input::get('duplicate'):1;
			$group_id		=	md5(uniqid(rand(), true));

			for($i=1; $i<=$duplicates; $i++){

				$newProductObj 	= 	new Product();

				$newProductObj->name	=	Input::get('product');
				$newProductObj->group_id		=	$group_id;
				
				$newProductObj->description	=	Input::get('description');
				//$newProductObj->company_id	=	Input::get('company');
				$newProductObj->category_id	=	Input::get('ddCategory');
				$newProductObj->model	=	Input::get('brand');
				$newProductObj->model_no	=	Input::get('brand_no');
				$newProductObj->batch_shop_id	=	Input::get('ddBatchShop');
				$newProductObj->margin	=	Input::get('profit_margin');
				$newProductObj->purchase_price	=	Input::get('purchase_price');
				$newProductObj->quantity	=	Input::get('quantity');
				$newProductObj->selling_price	=	Input::get('customer_price');
				$newProductObj->status		=	'Active';
				$newProductObj->created_by	=	Auth::user()->id;
				$newProductObj->created_at	=	getNow();

				$newProductObj->save();
				$newProductId =  $newProductObj->id;
				
			}

			exit;
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

		$this->data['title'] = 'New Product';
		$this->data['scriptIncludes'] = array('validator','add_product_js');
		return View::make('admin.product.new_product',$this->data);
	}


}
