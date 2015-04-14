<?php

class ProductController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['title'] = 'Products';
		$this->data['scriptIncludes'] = array('colorbox','product_js');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.product.product',$this->data);
	}

	public function getProductJson()
	{
		
		$dtFilter		=	getdataTableFilter();
		
		$productObj 		= 	new Product();
		$products  	= 	$productObj->getProductDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$products['total_rows'], 'recordsFiltered'=>$products['total_rows'], 'data'=>array());
		
		if($products['total_rows'] > 0){
			foreach($products['products'] as $product){
				$dtData['data'][] = array($product->product_id,
										$product->product,
										$product->group_id,
										
										$product->category,
										$product->quantity. ' '.$product->unit.'.',
										$product->selling_price,
										'<a  class="lnkBatchEdit" href="'.admin_url().'/products/edit/'.$product->product_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a> 
										 <a href="javascript:void(0);" class="lnkCategoryDelete" rel="'.admin_url().'/products/delete/'.$product->product_id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>');
			}
		}
		
		echo json_encode($dtData);
		exit;
	}

	public function newProduct()
	{
		$propertyObj 	= 	new Property();
		$categoryObj 	= 	new Category();
		$batchObj 		= 	new Batch();
		$productObj 		= 	new Product();

		
		
		$this->data['categories']	= 	$categoryObj->getCategoryDetails();
		$this->data['properties']  	= 	$propertyObj->getPropertiesDetails();
		$this->data['batches']      =   $batchObj->getBatchDetails(array('sortField'=>3, 'sortDir'=>'DESC'));
		$this->data['last_product']	=	$productObj->getProductDetails(array('offset'=>0, 'limit'=>1, 'sortField'=>0, 'sortDir'=>'DESC' ));
		$this->data['companies']	=   $productObj->getCompanies();
		if ($this->data['batches']['total_rows'] > 0) {
			$this->data['shops']  		= 	$batchObj->getBatchShopDetails($this->data['batches']['batches'][0]->id);
		}
		
		if (Request::ajax() && Request::isMethod('post'))
		{
			
			if (Input::get('product') == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}	
			
			
			

			$duplicates = (is_numeric(Input::get('duplicate')) && Input::get('duplicate') > 1) ?Input::get('duplicate'):1;
			$group_id		=	substr(strtoupper(md5(uniqid(rand(), true))),16,16);

			for($i=1; $i<=$duplicates; $i++){

				$newProductObj 	= 	new Product();

				$newProductObj->name	=	Input::get('product');
				$newProductObj->group_id		=	$group_id;
				
				$newProductObj->description	=	Input::get('description');
				$newProductObj->company_id	=	Input::get('ddCompany');
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

			echo json_encode(array('status'=>true,'message'=>''));
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
