<?php
function base_url()
{
	return URL::to('/');
}

function admin_dashboard_url()
{
	return URL::to('/').'/admin/dashboard';
}

function getdataTableFilter()
{
	$post = $_POST;
	$dtInput['sortField'] 		= 	isset($post['order'][0]['column'])?$post['order'][0]['column']:0;
	$dtInput['sortDir']			= 	isset($post['order'][0]['dir'])?$post['order'][0]['dir']:' ASC';	
	$dtInput['offset']			= 	isset($post['start'])?$post['start']:0;
	$dtInput['limit']			= 	isset($post['length'])?$post['length']:Config::get('billing.page_limit');
	return $dtInput;
}

function getNow()
{
	return date('Y-m-d h:i:s');
}
?>