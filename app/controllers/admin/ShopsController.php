<?php

class ShopsController extends \BaseController {
	function __construct()
	{
		$this->data['menu'] = 'shops';
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['title'] = 'Shops';
		$this->data['scriptIncludes'] = array('colorbox','shops');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.shops.shops',$this->data);
	}

	/**
	 * Get shops as a json object. This page will be called through ajax for datatable.
	 */
	public function getShopsJson()
	{
		
		$dtFilter		=	getdataTableFilter();
		
		$shopObj =	new Shop();
		$shops  	= 	$shopObj->getShopsDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$shops['total_rows'], 'recordsFiltered'=>$shops['total_rows'], 'data'=>array());
		
		if($shops['total_rows'] > 0){
			foreach($shops['shops'] as $shop){
				$dtData['data'][] = array($shop->shop,
										  $shop->city,
										  '<a href="javascript:void(0);" class="lnkPropertyEdit" rel="'.admin_url().'/shops/edit/'.$shop->id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a> 
										   <a href="javascript:void(0);" class="lnkPropertyDelete" rel="'.admin_url().'/shops/delete/'.$shop->id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>');
			}
		}
		
		echo json_encode($dtData);
		exit;
	}

	/**
	 * Show popup for creating new shop.  This function will also call through ajax post, on submit.
	 */
	public function createNewShop()
	{	
		$shopObj =	new Shop();
		if (Request::ajax() && Request::isMethod('post'))
		{

			$shop = Input::get('shop');
			$city = Input::get('city');
			
			if ($shop == '' || $city == '' ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			$shopInput['shop']			=	$shop;
			$shopInput['city']			=	$city;
			$shopInput['status']		=	'Active';
			$shopInput['sort_order']	=	1;
			$shopInput['created_by']	=	Auth::user()->id;
			$shopInput['created_at']	=	getNow();

			$newShopId = $shopObj->createShop($shopInput);

			if($newShopId > 0) {
				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Cannot save your data now.'));
				exit;
			}
			exit;
		}
		$this->data['scriptIncludes'] = array('validator','typeahead', 'add_shop');
		return View::make('admin.shops.new_shop',$this->data);
	}
}
