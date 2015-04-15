<?php
/**
 * @Author: Arun S S <arunssjoshi@gmail.com>
 * @Date:   2015-01-12 08:39:00
 * @Last Modified by:   Arun S S <arunssjoshi@gmail.com>
 * @Last Modified time: 2015-04-15 11:46:08
 */

function base_url()
{
	return URL::to('/');
}

function admin_url()
{
	return URL::to('/').'/admin';
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
	$dtInput['search']			= 	isset($post['search']['value'])?$post['search']['value']:'';
	return $dtInput;
}

function getNow()
{
	return date('Y-m-d h:i:s');
}

function formatMessage($message, $type, $filter=array()){
	$data = array('type'=>'message-'.$type,'message'=>$message, 'filter'=>$filter);
	return  View::make('admin.common.common_elements', $data);
}
function varDebug($var, $echo = true)
    {
        
        ob_start();
        print_r($var);
        $code =  htmlentities(ob_get_contents());
        ob_clean();

        $debug = debug_backtrace();
        $debug = $debug[0];
        $debug = "File: {$debug['file']} <br/>Line: {$debug['line']}";
        $dump = "<div style=\"border:1px solid #f00;font-family:arial;font-size:12px;font-weight:normal;background:#f0f0f0;text-align:left;padding:3px;\"><pre>".
                $code.'<br/>'.$debug .
        "</pre></div>";
        if ($echo) {
            echo $dump;
        } else {
            return $dump;
        }
    }

function changeArrayIndex($array=array(),$new_index_key){
    $new_array  =   array();
    if(sizeof($array)   >   0)
        foreach($array as $key =>$element) {
            if(!isset($new_array[$element[$new_index_key]]))
                $new_array[$element[$new_index_key]] = array();
            $new_array[$element[$new_index_key]][] = $element;
        }
    return $new_array;
}
?>