<?php
use Tygh\Registry;
use Tygh\BlockManager\SchemesManager;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	fn_trusted_vars (
		'popup_data'
	);
	if ($mode == 'update')
	{
		$popup_data = $_REQUEST['popup_data'];
		
		$popups = db_get_row("SELECT * FROM ?:agressive_popups WHERE lang_code = ?s", DESCR_SL);
		if (empty($popups))
		{
			foreach (fn_get_translation_languages() as $popup_data['lang_code'] => $v) {
			$popup_data['id'] = db_query("INSERT INTO ?:agressive_popups ?e", $popup_data);
			}
		} else {
			db_query("UPDATE ?:agressive_popups SET description = ?s, title = ?s, popup_width = ?i, popup_height = ?i, time_to_show = ?i, time_to_live = ?i, show_popup = ?s WHERE id = ?i AND lang_code = ?s", $popup_data['description'], $popup_data['title'], $popup_data['popup_width'], $popup_data['popup_height'], $popup_data['time_to_show'], $popup_data['time_to_live'], $popup_data['show_popup'], $popups['id'], DESCR_SL);
		}
		return array(CONTROLLER_STATUS_OK, "agressive_popup.update");
	}
}
if ($mode == 'update')
{
	$popup_data = db_get_row("SELECT * FROM ?:agressive_popups WHERE lang_code = ?s", DESCR_SL);
	Registry::get('view')->assign('popup_data', $popup_data);
}
