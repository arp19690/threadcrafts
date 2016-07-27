<?php
use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	fn_trusted_vars (
		'popup_data'
	);
	
	if ($mode == 'update') {
			if (!empty($_REQUEST['product_id'])) {
				$popup_data = $_REQUEST['popup_data'];
				$popup_data['product_id'] = $_REQUEST['product_id'];
				$popups = db_get_row("SELECT * FROM ?:agressive_popups_products WHERE lang_code = ?s AND product_id = ?i", DESCR_SL, $_REQUEST['product_id']);
				if (empty($popups))
				{
					foreach (fn_get_translation_languages() as $popup_data['lang_code'] => $v) {
					$popup_data['id'] = db_query("INSERT INTO ?:agressive_popups_products ?e", $popup_data);
					}
				} else {
					db_query("UPDATE ?:agressive_popups_products SET description = ?s, title = ?s, popup_width = ?i, popup_height = ?i, time_to_show = ?i, time_to_live = ?i, show_popup = ?s WHERE id = ?i AND product_id = ?i AND lang_code = ?s", $popup_data['description'], $popup_data['title'], $popup_data['popup_width'], $popup_data['popup_height'], $popup_data['time_to_show'], $popup_data['time_to_live'], $popup_data['show_popup'], $popups['id'],  $_REQUEST['product_id'], DESCR_SL);
				}
				return array(CONTROLLER_STATUS_OK, "products.update?product_id=" . $_REQUEST['product_id'] . "&selected_section=subscribers");
			}
	}
}

if ($mode == 'update') {
	Registry::set('navigation.tabs.agressive_popup', array (
			'title' => __('agressive_popup'),
			'js' => true
	));
	$popup_data = db_get_row("SELECT * FROM ?:agressive_popups_products WHERE product_id = ?i AND lang_code = ?s", $_REQUEST['product_id'], DESCR_SL);
	Registry::get('view')->assign('popup_data', $popup_data);
}
