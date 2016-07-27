<?php

use Tygh\Registry;
if (!defined('BOOTSTRAP')) { die('Access denied'); }

/* partee3an @ Cart-Power */

if ($mode == 'view') {

	$popup_product = db_get_row("SELECT * FROM ?:agressive_popups_products WHERE product_id = ?i AND lang_code = ?s", $_REQUEST['product_id'] , CART_LANGUAGE);
	
	if (!empty($popup_product)) {
		if (!isset($_COOKIE['agressive_popup_product_page'.$_REQUEST['product_id']]) && $popup_product['show_popup'] == 'Y') {
			if (!empty($popup_product['time_to_live'])) {
				fn_set_cookie("agressive_popup_product_page".$_REQUEST['product_id'], $_REQUEST['product_id'], (60 * 60 * 24 * $popup_product['time_to_live']));
			}
			Registry::get('view')->assign('popup_product', $popup_product);
		}
	}
}