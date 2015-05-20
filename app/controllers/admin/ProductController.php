<?php

class ProductController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categoryObj 	= 	new Category();
		$productObj 		= 	new Product();

		$this->data['title'] = 'Products';
		$this->data['categories']	= 	$categoryObj->getCategoryDetails();
		$this->data['scriptIncludes'] = array('colorbox','product_js');
		$this->data['cssIncludes'] = array('colorbox');
		$this->data['tobe_queued'] = $productObj->getTobeQueuedCount(3);	
		return View::make('admin.product.product',$this->data);
	}

	public function getProductJson()
	{
		//var_dump($_POST['name']);
		$dtFilter		=	getdataTableFilter('product');
		$dtFilter['categoryId'] = Input::get('categoryId');
		$dtFilter['listType'] = Input::get('listType');
		$productObj 		= 	new Product();
		$products  	= 	$productObj->getProductDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$products['total_rows'], 'recordsFiltered'=>$products['total_rows'], 'data'=>array());
		
		if($products['total_rows'] > 0){
			foreach($products['products'] as $product){
				$checkBoxValue = ($dtFilter['listType']=='queue' || $dtFilter['listType']=='printed')?$product->barcode_queue_id:$product->product_id;
				
				if ($dtFilter['listType']=='product') {
					$barcode_queue_id_str = '';
					$manageLinks = '<a  class="lnkBatchEdit" href="'.admin_url().'/products/edit/'.$product->product_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a>';
				} else if ($dtFilter['listType']=='tobe_queued') {
					$barcode_queue_id_str = '';
					$manageLinks = '<a  class="lnkBatchEdit" href="'.admin_url().'/products/edit/'.$product->product_id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a>';
				} else {
					$barcode_queue_id_str = " (".$product->barcode_queue_id.")";
					$manageLinks = '<a href="javascript:void(0);" class="lnkBarcodeQueueDelete" rel="'.$product->barcode_queue_id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>';
				}

				$dtData['data'][] = array(
										'&nbsp;&nbsp;&nbsp;<input type="checkbox" class="chkProduct" data-product-id="'.$product->product_id.'" value="'.$checkBoxValue.'">',
										$product->product_id.$barcode_queue_id_str,
										$product->product_code,
										$product->product,
										$product->group_id,
										
										$product->category,
										$product->quantity. ' '.$product->unit.'.',
										$product->selling_price,
										$manageLinks
										);
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
		$this->data['last_product']	=	$productObj->getProductDetails(array('offset'=>0, 'limit'=>1, 'sortField'=>1, 'sortDir'=>'DESC' ));
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
				$productPropertyOptions =	Input::get('properties');
				$newProductObj 	= 	new Product();

				$newProductObj->name	=	Input::get('product');
				$newProductObj->group_id		=	$group_id;
				
				$newProductObj->description	=	Input::get('description');
				$newProductObj->company_id	=	(Input::get('ddCompany'))?Input::get('ddCompany'):null;
				$newProductObj->category_id	=	Input::get('ddCategory');
				$newProductObj->model	=	Input::get('brand');
				$newProductObj->model_no	=	Input::get('brand_no');
				$newProductObj->batch_shop_id	=	Input::get('ddBatchShop');
				$newProductObj->margin	=	Input::get('profit_margin');
				$newProductObj->purchase_price	=	Input::get('purchase_price');
				$newProductObj->quantity	=	Input::get('quantity');
				$newProductObj->initial_quantity	=	Input::get('quantity');
				$newProductObj->selling_price	=	Input::get('customer_price');
				$newProductObj->status		=	'Active';
				$newProductObj->created_by	=	Auth::user()->id;
				$newProductObj->created_at	=	getNow();

				$newProductObj->save();
				$newProductId =  $newProductObj->id;

				if($newProductId > 0) {

				$product_category_info				= 	$categoryObj->getCategoryDetails(array('categoryId'=>$newProductObj->category_id));
				$newProductObj->product_code 		= 	$product_category_info['categories']['0']->category_short_code.$newProductId;
				$newProductObj->save();
				

				if(!empty($productPropertyOptions)) {
					$productPropertyInput = array();
					$productPropertyOptions = explode(',', $productPropertyOptions);
					foreach ($productPropertyOptions as $key => $option_id) {
						$productPropertyInput[] = array('product_id'=>$newProductId, 'property_option_id'=>$option_id);
					}
					$productObj->createProductPropertyOptions($productPropertyInput);
				}
			}
			}

			echo json_encode(array('status'=>true,'message'=>''));
			
			exit;
		}

		$this->data['title'] = 'New Product';
		$this->data['scriptIncludes'] = array('validator','add_product_js');
		return View::make('admin.product.new_product',$this->data);
	}

	public function editProduct($productId)
	{
		$propertyObj 	= 	new Property();
		$categoryObj 	= 	new Category();
		$batchObj 		= 	new Batch();
		$productObj 		= 	new Product();

		if (empty($productId))
			return formatMessage('Invalid Request', 'danger');

		$product_info  	= 	$productObj->getProductDetails(array('productId'=>$productId));
		if($product_info['total_rows']==0)
			return formatMessage('Product not found', 'danger', array('resize_popup'=>true));

		$this->data['product_info'] = $product_info['products'][0];

		$this->data['categories']	= 	$categoryObj->getCategoryDetails();
		$this->data['properties']  	= 	$propertyObj->getPropertiesDetails();
		$this->data['batches']      =   $batchObj->getBatchDetails(array('sortField'=>3, 'sortDir'=>'DESC'));
		$this->data['product_batch']      =   $batchObj->getBatchDetails(array('batchShopId'=>$this->data['product_info']->batch_shop_id))['batches'][0];
		$this->data['companies']	=   $productObj->getCompanies();
		if ($this->data['batches']['total_rows'] > 0) {
			$this->data['shops']  		= 	$batchObj->getBatchShopDetails($this->data['product_batch']->id);
		}
		
		$productData = Product::find($productId);

		if (Request::ajax() && Request::isMethod('post'))
		{
			
			if (Input::get('product') == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}	
			

			$productData->name	=	Input::get('product');
			$productData->group_id		=	Input::get('group_id');
			
			$productData->description	=	Input::get('description');
			$productData->company_id	=	(Input::get('ddCompany'))?Input::get('ddCompany'):null;
			$productData->category_id	=	Input::get('ddCategory');
			$productData->model	=	Input::get('brand');
			$productData->model_no	=	Input::get('brand_no');
			$productData->batch_shop_id	=	Input::get('ddBatchShop');
			$productData->margin	=	Input::get('profit_margin');
			$productData->purchase_price	=	Input::get('purchase_price');
			$productData->quantity	=	Input::get('quantity');
			$productData->selling_price	=	Input::get('customer_price');
			$productData->status		=	Input::get('ddStatus');
			$productData->updated_by	=	Auth::user()->id;
			$productData->updated_at	=	getNow();

			$productData->save();
				

				

			
			
			$productPropertyOptions =	Input::get('properties');

			if($productData->id > 0) {

				$formProductProperties =	Input::get('properties');
				$dbProductProperites   =   array();

				$dbProps = DB::table('product_property_option')->where('product_id', $productId )->get();
				

				if($dbProps) {
					foreach ($dbProps as $prop) {
							$dbProductProperites[] = $prop->property_option_id;
					}
				}

				
				$formProductProperties = (!$formProductProperties)?array():explode(',',$formProductProperties);


				$productPropertyOptionsToInsert = array_diff($formProductProperties, $dbProductProperites);
				$productPropertyOptionsToDelete = array_diff($dbProductProperites, $formProductProperties);

				
				if (sizeof($productPropertyOptionsToInsert) > 0) {
					$productPropertyOptionsInput = array();
					foreach ($productPropertyOptionsToInsert as $key => $option_id) {
						$productPropertyOptionsInput[] = array('product_id'=>$productId, 'property_option_id'=>$option_id);
					}
					$productObj->createProductPropertyOptions($productPropertyOptionsInput);
				}
				

				if (sizeof($productPropertyOptionsToDelete) > 0) {
					$productObj->deleteProductPropertyOptions($productId, $productPropertyOptionsToDelete);
				}

				echo json_encode(array('status'=>true,'message'=>''));

			}	else {
				echo json_encode(array('status'=>false,'message'=>'Cannot save your data now.'));
				exit;
			}
			exit;
		}

		$this->data['title'] = 'Edit Product';
		$this->data['scriptIncludes'] = array('validator','edit_product_js');
		return View::make('admin.product.edit_product',$this->data);
	}

	public function getProductProperties()
	{
		$productId = Input::get('productId');
		$categoryId = Input::get('categoryId');
		$productObj 		= 	new Product();

		$this->data = array();
		$this->data['product_id'] = $productId;
		$properties = $productObj->getCategoryPropertiesForProduct($categoryId, $productId);
		if ($properties) {
			$this->data['product_properties'] = changeArrayIndex(json_decode(json_encode($properties), true),'property_id');
		}

		return View::make('admin.product.property_list',$this->data);

	}

	public function generateBarcode($productIds)
	{
		$productObj 		= 	new Product();

		$productIds = array_unique(explode(',',$productIds));
		$this->data['products'] = $productObj->getProductsForBarcode(implode(',', $productIds));
		
		return View::make('admin.product.barcode',$this->data);
	}


	public function addQueue()
	{
		$products = Input::get('products');
		$product_queue = array();
		$productObj 		= 	new Product();
		if(sizeof($products) > 0) {
			foreach($products as $productId){
				$product_info  	= 	$productObj->getProductDetails(array('productId'=>$productId));
				if($product_info['total_rows'] > 0){
					$product_info = $product_info['products'][0];
					for($i=1; $i<=$product_info->quantity; $i++) {
						$product_queue[]['product_id'] = $productId;
					}
				}

				
			}
			$productObj->addToBarcodeQueue($product_queue);

			$count =  DB::table('barcode_queue')->where('status', '=', 'Queue')->count();
			echo json_encode(array('count'=>$count));
			exit;
		}
	}


	public function markPrinted()
	{
		$productObj 		= 	new Product();
		$barcode_queue_ids = Input::get('barcodeQueueIds');
		if($barcode_queue_ids) {
			$productObj->markAsPrinted(implode(',',$barcode_queue_ids));
			$count =  DB::table('barcode_queue')->where('status', '=', 'Queue')->count();
			echo json_encode(array('count'=>$count));
			exit;
		}
	}

	public function deleteBarcodeQueue()
	{
		$productObj 		= 	new Product();
		$barcodeQueueId = Input::get('barcodeQueueId');
		if (is_numeric($barcodeQueueId) && $barcodeQueueId > 0){
			$productObj->deleteBarcodeQueueItem($barcodeQueueId);
			$count =  DB::table('barcode_queue')->where('status', '=', 'Queue')->count();
			echo json_encode(array('count'=>$count));
			exit;
		}
	}

	public function tempProductSoldMark()
	{
		$productObj 	= 	new Product();

		$date = '2015-05-2';
		$productIds = "329,355,355,352,348,349,350";

		exit;
		$productIds = explode(',', $productIds);

		$bill_id = DB::table('bill')->insertGetId(
            array('customer_name'=>'A good Customer', 'created_by'=>2, 'created_date'=>$date)
        );
        

        foreach ($productIds as $key => $product_id) {
        	$product_info  	= 	$productObj->getProductDetails(array('productId'=>$product_id));
			
			$product_info = $product_info['products'][0];
			$bill_product_id = DB::table('bill_product')->insertGetId(
	            array('bill_id'=>$bill_id, 'bill_id'=>$bill_id, 'product_id'=>$product_id, 'quantity'=>1, 
	            	  'mrp'=>$product_info->selling_price, 'customer_price'=>$product_info->selling_price)
	        );
			
			$query = "UPDATE product SET quantity=quantity-1 WHERE id = $product_id";
	        	DB::select(DB::raw($query ));
	        }
	}

}
