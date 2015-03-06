<?php

class BatchController extends \BaseController {

	function __construct()
	{
		$this->data['menu'] = 'batch';
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->data['title'] = 'Batches';
		$this->data['scriptIncludes'] = array('colorbox','shops_js');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.batch.batch',$this->data);
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
	public function createNewBatch()
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
		$this->data['scriptIncludes'] = array('validator', 'add_batch_js');
		return View::make('admin.batch.new_batch',$this->data);
	}

	/**
	 * Editing a shop. This page will be called through ajax on edit submit.
	 */
	public function editShop($shopId=0){

		$shopObj =	new Shop();
		
		
		if (empty($shopId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$shops  	= 	$shopObj->getShopsDetails(array('shopId'=>$shopId));
		if($shops['total_rows']==0)
			return formatMessage('Shop not found', 'danger', array('resize_popup'=>true));
		$this->data['shop_info'] = $shops['shops'][0];
		//var_dump($this->data['shop_info']);
		if (Request::ajax() && Request::isMethod('post'))
		{
			$shopData				=	Shop::find($shopId);

			$shop = Input::get('shop');
			$city = Input::get('city');
			
			if ($shop == '' || $city == '' ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}

			$shopData['shop']			=	$shop;
			$shopData['city']			=	$city;
			$shopData['updated_by']	=	Auth::user()->id;
			$shopData['updated_at']	=	getNow();

			$shopData->save();
			echo json_encode(array('status'=>true,'message'=>''));
			exit;
		}
		$this->data['scriptIncludes'] = array('validator', 'typehead', 'edit_shop_js');
		return View::make('admin.shops.edit_shop',$this->data);
	}


	/**
	 * Delete a shop. This page will be called through ajax.
	 */
	public function deleteShop($shopId=0){

		$shopObj =	new Shop();
		
		
		if (empty($shopId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$shops  	= 	$shopObj->getShopsDetails(array('shopId'=>$shopId));
		if($shops['total_rows']==0)
			return formatMessage('Shop not found', 'danger', array('resize_popup'=>true));
		$this->data['shop_info'] = $shops['shops'][0];
		//var_dump($this->data['shop_info']);
		if (Request::ajax() && Request::isMethod('post'))
		{
			$shopData				=	Shop::find($shopId);


			$shopData['status']			=	'Deleted';
			$shopData['updated_by']	=	Auth::user()->id;
			$shopData['updated_at']	=	getNow();

			$shopData->save();
			echo json_encode(array('status'=>true,'message'=>''));
			exit;
		}
		$this->data['scriptIncludes'] = array('colorbox', 'validator', 'typehead', 'edit_shop_js','shops_js');
		return View::make('admin.shops.delete_shop',$this->data);
	}

	public function getCitySuggestions($city='')
	{
		
		$shopObj =	new Shop();
		$shops	=	$shopObj->getCitySuggestions($city);

		if($shops) {
			$city_json = array();
			foreach($shops as $shop) {
				$city_json[] = $shop->city;
			}
			echo json_encode($city_json);
		}

	}


}
