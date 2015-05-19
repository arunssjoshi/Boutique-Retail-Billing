<?php

class BillingController extends BaseController {
	function __construct()
	{
		$this->data['menu'] = 'Billing';
	}
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function newBill()
	{
		$this->data['title'] = 'New Bill';
		$this->data['scriptIncludes'] = array('validator', 'bill_js');
		return View::make('billing.new-bill',$this->data);
	}

	public function getProduct($productId)
	{
		
		$productObj 		= 	new Product();
		$product_info = $productObj->getBillProductDetails(trim($productId));
		if ($product_info) {
			echo json_encode(array('status'=>true, 'product_info'=>$product_info));
		} else {
			echo json_encode(array('status'=>false, 'product_info'=>$product_info));
		}
	}

	public function printBill()
	{
		$products = Input::get('products');
		if (empty($products)) {
			die('Invalid Products');
		}

		$productObj 		= 	new Product();

		$products = explode('||', $products);
		$product_list = array();

		$in_products= "'";
		foreach ($products as $key => $product) {
			$product_chunks = explode('*', $product);
			if(!isset($product_list[$product_chunks[0]])) {
				$product_list[$product_chunks[0]] = $product_chunks[1];
				$in_products.=$product_chunks[0]."','";
			}
		}
		//$product_list = implode("'", $product_list);
		
		$in_products =  substr($in_products,0,strlen($in_products)-2);

		$this->data['product_quantity'] = $product_list;
		$this->data['bill_products'] = $productObj->getBillProductDetailsByProductCodes($in_products);
		
		return View::make('billing.print-bill',$this->data);
	}
}
