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
		$this->data['scriptIncludes'] = array('colorbox','batch_js');
		$this->data['cssIncludes'] = array('colorbox');
		return View::make('admin.batch.batch',$this->data);
	}

	/**
	 * Get shops as a json object. This page will be called through ajax for datatable.
	 */
	public function getBatchJson()
	{
		
		$dtFilter		=	getdataTableFilter();
		
		$batchObj =	new Batch();
		$batches  	= 	$batchObj->getBatchDetails($dtFilter);
		$dtData 		= 	array( 'recordsTotal'=>$batches['total_rows'], 'recordsFiltered'=>$batches['total_rows'], 'data'=>array());
		
		if($batches['total_rows'] > 0){
			foreach($batches['batches'] as $batch){
				$dtData['data'][] = array($batch->batch,
										$batch->shops,
										$batch->city,
										date('l, jS F Y',strtotime($batch->purchased_on)),
										'<a href="javascript:void(0);" class="lnkBatchEdit" rel="'.admin_url().'/batch/edit/'.$batch->id.'"><small class="badge  bg-aqua"><i class="fa fa-pencil"></i> Edit</small></a> 
										 <a href="javascript:void(0);" class="lnkPropertyDelete" rel="'.admin_url().'/batch/delete/'.$batch->id.'"><small class="badge  bg-aqua"><i class="fa fa-trash"></i> Delete</small></a>');
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
		$dtFilter		=	getdataTableFilter();
		$batchObj =	new Batch();
		$this->data['cities']  = Shop::where('status', '=', 'Active')->select('city')->distinct()->get();
		if (Request::ajax() && Request::isMethod('post'))
		{

			$batchInput['batch'] = Input::get('batch');
			if ($batchInput['batch'] == ''  ) {
				echo json_encode(array('status'=>false,'message'=>'Please enter the required fields.'));
				exit;
			}
			
			$batchInput['description']	=	Input::get('summary');
			$batchInput['purchased_on']	=	Input::get('purchaseDate');
			$batchInput['status']		=	'Active';
			$batchInput['sort_order']	=	1;
			$batchInput['created_by']	=	Auth::user()->id;
			$batchInput['created_at']	=	getNow();

			$batchShops =	Input::get('chkShop');

			$newBatchId = $batchObj->createBatch($batchInput);
			
			if($newBatchId > 0) {
				if(!empty($batchShops)) {
					$batchShopInput = array();
					foreach ($batchShops as $key => $shop) {
						$batchShopInput[] = array('batch_id'=>$newBatchId, 'shop_id'=>$shop);
					}
					$batchObj->createBatchShop($batchShopInput);
				}
				echo json_encode(array('status'=>true,'message'=>''));
				exit;
			}	else {
				echo json_encode(array('status'=>false,'message'=>'Cannot save your data now.'));
				exit;
			}
			exit;
		}
		$this->data['scriptIncludes'] = array('validator','moment_js','datepicker_js', 'add_batch_js');
		$this->data['cssIncludes'] = array('datepicker_css');
		return View::make('admin.batch.new_batch',$this->data);
	}

	/**
	 * Editing a shop. This page will be called through ajax on edit submit.
	 */
	public function editBatch($batchId=0){

		$batchObj =	new Batch();
		
		
		if (empty($batchId))
			return formatMessage('Invalid Request', 'danger', array('resize_popup'=>true));

		$batches  	= 	$batchObj->getBatchDetails(array('batchId'=>$batchId));
		if($batches['total_rows']==0)
			return formatMessage('Shop not found', 'danger', array('resize_popup'=>true));
		$this->data['batch_info'] = $batches['batches'][0];
		$this->data['cities']  = Shop::where('status', '=', 'Active')->select('city')->distinct()->get();
		$this->data['shops']	=	$batchObj->getBatchShopDetails($batchId);
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
		$this->data['scriptIncludes'] = array('validator', 'moment_js','datepicker_js', 'edit_batch_js');
		return View::make('admin.batch.edit_batch',$this->data);
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

	public function getShopJson()
	{
		$city = Input::get('city');
		$batchObj =	new Batch();
		$shops	=	$batchObj->getShopsByCity($city);
		echo json_encode($shops);exit;
		
	}
}
