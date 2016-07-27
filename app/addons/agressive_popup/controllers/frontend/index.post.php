<?php

use Tygh\Registry;
if (!defined('BOOTSTRAP')) { die('Access denied'); }

/* partee3an @ Cart-Power */

$popup = db_get_row("SELECT * FROM ?:agressive_popups WHERE lang_code = ?s", CART_LANGUAGE);

if (!empty($popup)) {
	if (!isset($_COOKIE['agressive_popup_home_page']) && $popup['show_popup'] == 'Y') {
		
		if (!empty($popup['time_to_live'])) {
			fn_set_cookie("agressive_popup_home_page", "agressive_popup_home_page", (60 * 60 * 24 * $popup['time_to_live']));
		}
		Registry::get('view')->assign('popup', $popup);
	}
}