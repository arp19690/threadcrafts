<?php
use Tygh\Registry;
use Tygh\Mailer;
use Tygh\Navigation\LastView;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_shipway_create_shipment($shipment_data, $order_info, $group_key, $all_products){
	$login_id 		= Registry::get('addons.shipway.shipway_loginid');
	$password		= Registry::get('addons.shipway.shipway_licencekey');
	
	$awbno 		= (isset($shipment_data['tracking_number'])) ? $shipment_data['tracking_number'] : 0;
	$carrier 	= (isset($shipment_data['carrier'])) ? $shipment_data['carrier'] : '';
	$order_id	= (isset($shipment_data['order_id'])) ? $shipment_data['order_id'] : '';
	
	$carrier_id = fn_get_shipway_courier_id($carrier);
	$order_info = fn_get_order_info($order_id);
	
	$push_order = array();
	
	$push_order['order_id'] 			= $order_id;
	$push_order['firstname'] 			= $order_info['firstname'];
	$push_order['lastname'] 			= $order_info['lastname'];
	$push_order['email'] 				= $order_info['email'];
	$push_order['phone'] 				= $order_info['phone'];
	$push_order['address'] 				= $order_info['s_address'] . ' ' . $order_info['s_address_2'];
	$push_order['city'] 				= $order_info['s_city'] ;
	$push_order['state'] 				= $order_info['s_state'] ;
	$push_order['country'] 				= $order_info['s_country'] ;
	$push_order['zipcode'] 				= $order_info['s_zipcode'] ;
	$push_order['amount'] 				= $order_info['total'] ;
	$push_order['payment_type']			= ( isset( $order_info['payment_method']['payment'] ) && trim( $order_info['payment_method']['payment'] == 'C.O.D' ) ) ? 'C' : 'P' ;
	$push_order['order_date']			= date( "Y-m-d" , $order_info['timestamp'] ) ;
	
	$push_order['collectable_amount'] 	= ($push_order['payment_type'] == 'C') ? $order_info['total'] : 0;
	
	$products = array();
	$key =0 ;
	foreach($order_info['products'] as $product){
		$products[$key]['product_id']	= $product['product_id'];
		$products[$key]['name']		= addslashes( strip_tags( $product['product'] ) );
		$products[$key]['price']		= $product['base_price'] ;
		$products[$key]['quantity']		= $product['shipment_amount'] ;
		$products[$key]['url']			= fn_url('products.view?product_id=' . $product['product_id'], 'C', 'http', 'en', true);
		$key++;
	}
	$push_order['products'] = $products;
	
	$company_id = $order_info['company_id'];
	$push_order['return_address'] = '';
	$company = '';
	if(!empty($company_id)){
		$company_data = db_get_row("SELECT company,address,city,state,country,zipcode FROM ?:companies WHERE company_id = '" . (int)$company_id . "' ");
		if(!empty($company_data)){
			$push_order['return_address'] = $company_data['company']. ',' . $company_data['address']. ' ' . $company_data['city']. ' ' . $company_data['state']. ' ' . $company_data['country']. ',postcode-' . $company_data['zipcode'];
			$company = $company_data['company'];
		}
	}
	//echo "<pre>";print_r($push_order);die;
	$product_name = '';
	foreach($order_info['products'] as $products){
		$product_name .= $products['product'].',';
	}

	
	if($awbno && $carrier_id && $order_id){
		$data = array(
				'carrier_id' 	=> $carrier_id,
				'order_id' 		=> $order_id,
				'awb' 			=> $awbno,
				'username' 		=> $login_id,
				'password' 		=> $password,
				'first_name'	=> $order_info['firstname'],
				'last_name'		=> $order_info['lastname'],
				'email'			=> $order_info['email'],
				'phone'			=> $order_info['phone'],
				'products'		=> $product_name,
				'company'		=> $company,
				'order'		=> $push_order
		);

		fn_push_order($data);
		
	}else{
		fn_set_notification('W', __('warning'),'Tracking number is not pushed to Shipway.');
	}	
}
function fn_get_tracking_details_by_order_id($order_id){
	
	$tracking_details = db_get_array("SELECT s.tracking_number,s.carrier FROM ?:shipments s INNER JOIN ?:shipment_items si ON(s.shipment_id = si.shipment_id) WHERE si.order_id = '". (int)$order_id."' LIMIT 1");
	return (isset($tracking_details[0])) ? $tracking_details[0] : array() ;
}

function fn_track_shipway($order_id){
	
	$order_info = fn_get_order_short_info($order_id);
	if(empty($order_info)){
		return '<div class="error"> Order ID not found.</div>';
	}
	$tracking_details = fn_get_tracking_details_by_order_id($order_id);
	if(empty($tracking_details)){
		return '<div class="error"> order is not shipped yet.</div>';
	}
	$awbno = $tracking_details['tracking_number'];
	$carrier_id = fn_get_shipway_courier_id( $tracking_details['carrier'] );
	
	if( !$awbno || ! $carrier_id){
		return '<div class="error"> Your order is not shipped yet.</div>';
	}
	
	$username 		= Registry::get('addons.shipway.shipway_loginid');
	$password		= Registry::get('addons.shipway.shipway_licencekey');
	
	if(!$username || !$password){
		return '<div class="error"> Invalid shipway credentials.</div>';
	}
	
	$url         = "http://shipway.in/api/getawbresult";
    $data_string = array(
        "username" 		=> $username,
        "password" 		=> $password,
        "carrier_id" 	=> $carrier_id,
        "awb" 			=> $awbno,
		"order_id"		=> $order_id
    );
		
    $data_string = json_encode($data_string);
    $curl        = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json'
    ));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);
    curl_close($curl);
	
	$head = '<table class="track_table">
			<tbody><tr class="head">
				<th style="border-right-color:#ffffff;">Airway Bill Number</th>
				<th>Carrier Name</th>				
			</tr>
			<tr>
				<td><b>'.$awbno.'</b></td>
				<td><b>'. ucwords( $tracking_details['carrier'] ) .'</b></td>
			</tr>
		</tbody></table>';
	
    return $head.$output;
}

function fn_push_order($data){
	$url = "http://shipway.in/api/pushOrderData";
		
	$data_string = json_encode($data);
		
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type:application/json'
	));
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
	$output = curl_exec($curl);
	$output = json_decode($output);
	curl_close($curl);
		
	if(isset($output->status) && strtolower($output->status) == 'success'){
		fn_set_notification('N',__('notice'),'Order has been pushed to Shipway.');
	}else{
		fn_set_notification('W', __('warning'),'Tracking number is not pushed to Shipway.');
	}
}
function fn_get_shipway_courier_id($courier_name){
	$couriers = array(
		'bluedart'		=> '1',
		'delhivery'		=> '2',
		'gati'			=> '3',
		'gojavas'		=> '4',
		'fedex'			=> '5',
		'ecomexpress'	=> '6',
		'dtdc'			=> '7',
		'dotzot'		=> '8',
		'redexpress'	=> '9',
		'firstflight'	=> '10',		
		'aramex'		=> '11',
		'dhl'			=> '12',		
		'professional'	=> '13',
	);
	
	$courier_name = strtolower( trim( str_replace(' ','',$courier_name ) ) );
	
	return (isset($couriers[$courier_name])) ? $couriers[$courier_name] : 0;
}
function fn_check_shipway_user(){
	$login_id 		= Registry::get('addons.shipway.shipway_loginid');
	$password		= Registry::get('addons.shipway.shipway_licencekey');
	
	$url         = "http://shipway.in/api/authenticateUser";
    $data_string = array(
        "username" => $login_id,
        "password" => $password
    );
    $data_string = json_encode($data_string);
    $curl        = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json'
    ));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($curl);		
	curl_close($curl);
        
	$output = json_decode($output);	
	if(isset($output->status) && strtolower($output->status) == 'success'){
		return true;
	}
	return false;
}