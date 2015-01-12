<?php
function base_url(){
	return URL::to('/');
}

function admin_dashboard_url(){
	return URL::to('/').'/admin/dashboard';
}
?>