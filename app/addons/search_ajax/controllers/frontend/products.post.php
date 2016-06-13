<?php
use Tygh\Registry;
if (!defined('BOOTSTRAP')) { die('Access denied'); }
if ($mode == 'search') {
	$params = $_REQUEST;
    $params['extend'] = array('description');
	$json_return = array('html'=>1);
	if(defined('AJAX_REQUEST')){
		$page_size = 12;			
		list($products, $search) = fn_get_products($params, $page_size);		
		Tygh::$app['view']->assign('products', $products);
		$json_data = Tygh::$app['view']->fetch('addons/search_ajax/views/products/search_ajax.tpl');
		echo json_encode(array("html"=>$json_data),true);
		exit;
	}
}