<?php

use Tygh\Registry;
if (!defined('BOOTSTRAP')) { die('Access denied'); }

/* partee3an @ Cart-Power */

if ($mode == 'view') {
	$popup_category = db_get_row("SELECT * FROM ?:agressive_popups_categories WHERE category_id = ?i AND lang_code = ?s", $_REQUEST['category_id'] , CART_LANGUAGE);
	if (!empty($popup_category)) {
		if (!isset($_COOKIE['agressive_popup_category_page'.$_REQUEST['category_id']]) && $popup_category['show_popup'] == 'Y') {
			if (!empty($popup_category['time_to_live'])) {
				fn_set_cookie("agressive_popup_category_page".$_REQUEST['category_id'],$_REQUEST['category_id'], (60 * 60 * 24 * $popup_category['time_to_live']));
			}
			Registry::get('view')->assign('popup_category', $popup_category);
		}
	}
}