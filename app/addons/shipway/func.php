<?php
use Tygh\Registry;
use Tygh\Mailer;
use Tygh\Navigation\LastView;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

//function fn_shipway_create_shipment($shipment_data, $order_info, $group_key, $all_products){

function fn_shipway_create_shipment_post($shipment_data, $order_info, $group_key, $all_products, $shipment_id){
	$login_id 		= Registry::get('addons.shipway.shipway_loginid');
	$password		= Registry::get('addons.shipway.shipway_licencekey');
	
	$awbno 		= (isset($shipment_data['tracking_number'])) ? $shipment_data['tracking_number'] : 0;
	$carrier 	= (isset($shipment_data['carrier'])) ? $shipment_data['carrier'] : '';
	$order_id	= (isset($shipment_data['order_id'])) ? $shipment_data['order_id'] : '';
	
	$carrier_id = db_get_field("SELECT `id` FROM ?:shipway_couriers WHERE `code` = '" . $carrier . "' LIMIT 1 ");
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

	$product_name = '';
	foreach($order_info['products'] as $products){
		$product_name .= $products['product'].',';
	}

	if($awbno && $carrier_id && $order_id && $login_id && $password){
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
	//$carrier_id = fn_get_shipway_courier_id( $tracking_details['carrier'] );
	$carrier_id = db_get_field("SELECT `id` FROM ?:shipway_couriers WHERE `code` = '" . $tracking_details['carrier'] . "' LIMIT 1 ");
	
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

function fn_check_shipway_user( $username = '' , $password = ''){
	$login_id 		= ($username) ? $username : Registry::get('addons.shipway.shipway_loginid');
	$password		= ($password) ? $password : Registry::get('addons.shipway.shipway_licencekey');
	
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
function fn_sync_shipway_carriers(){
	$login_id 		= Registry::get('addons.shipway.shipway_loginid');
	$password		= Registry::get('addons.shipway.shipway_licencekey');
	
	if(!empty($login_id) && !empty($password)){
	
		$url         = "http://shipway.in/api/getcarrier";
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
		
		$output = (array)json_decode($output);
		
		if(isset($output['status']) && strtolower( trim( $output['status'] ) ) == 'failed'){
			return array();
		}
		
		return $output;
	}
}
function fn_update_shipway_carriers(){
	$last_updated = db_get_field("SELECT TIMESTAMPDIFF(DAY, `last_updated`, NOW()) FROM `?:shipway_couriers` LIMIT 1");
	if($last_updated >= 1 || $last_updated === ""){
		$shipway_carriers = fn_sync_shipway_carriers();
		if(!empty($shipway_carriers)){
			$query = '';
			foreach($shipway_carriers as $key => $carrier){
				$query .= "('" .$key. "','" .'Shipway-'.ucwords($carrier). "','" .str_replace(' ','_',$carrier). "'),";
			}
			
			$query = trim($query,',');
			if(!empty($query)){
				db_query("TRUNCATE ?:shipway_couriers");
				db_query("INSERT INTO ?:shipway_couriers (`id`,`name`,`code`) values ".$query);
			}
		}
	}
}
function fn_get_shipway_carriers(){
	$shipway_carriers = db_get_array("SELECT * FROM ?:shipway_couriers");
	return $shipway_carriers;
}

function fn_get_shipway_login_id(){
	return Registry::get('addons.shipway.shipway_loginid');
}