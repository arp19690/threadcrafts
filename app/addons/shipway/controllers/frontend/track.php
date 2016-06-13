<?php

use Tygh\Registry;
use Tygh\Storage;
use Tygh\Session;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($mode == 'track'){

		$order_id = 0 ;
		if(isset($_POST['order_id'])){
			$order_id = (int)$_POST['order_id'];
		}
		
		$allowed_id = db_get_field("SELECT user_id FROM ?:orders WHERE user_id = '". $auth['user_id']. "' AND order_id = '". $order_id ."'");
		if(empty($allowed_id)){
			fn_set_notification('E', __('error'), __('warning_track_orders_not_allowed'));	
		}else{
			$track_data = fn_track_shipway($order_id) ;
			Registry::get('view')->assign('track_data',$track_data);
		}		
	}
}
if($mode == 'track'){
	
	$view = Registry::get('view');
	$view->assign('test', 'This is test data');
	fn_add_breadcrumb('Track Shipment');
}