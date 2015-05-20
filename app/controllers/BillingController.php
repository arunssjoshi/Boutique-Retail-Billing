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

	public function processBill()
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

		$product_quantity = $product_list;
		$bill_products = $productObj->getBillProductDetailsByProductCodes($in_products);

    	$total_items = 0;
    	$sub_total = 0;
    	$total_discount = 0;
    	$grant_total =0;

    	$bill_product_input = array();
    	//var_dump($bill_products);exit;
    	foreach($bill_products as $key=> $product){

        	$discount = $product->discount;
        	$quantity = $product_quantity[$product->product_code];
        	$mrp      = $product->selling_price;

        	$total_items = $total_items + $quantity;

        	if($discount) {
        		$discountAmount = ($mrp * $quantity) * $discount/100;
        	} else {
        		$discountAmount = '-';
        	}

        	$tax = ($mrp*$quantity- $discountAmount) *  $product->tax/100 ;
        	$total = $quantity * $mrp - $discountAmount;


        	array_push($bill_product_input, array('bill_id'=>19, 'product_id'=>$product->product_id, 'quantity'=>$quantity,
        										  'mrp'=>$mrp, 'customer_price'=>$total, 'discount_id'=>$product->discount_id, 'tax'=>$tax));


        	$grant_total = $grant_total + $total;
        	$total_discount = $total_discount + $discountAmount;
        	$sub_total = $sub_total+ ($mrp * $quantity);
        }
        var_dump($bill_product_input);
		var_dump($bill_products);
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
