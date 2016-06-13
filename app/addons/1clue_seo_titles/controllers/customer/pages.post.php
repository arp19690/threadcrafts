<?php
use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'view') {
	$page = Registry::get('view')->get_var('page');
	if (empty($page['page_title']) || Registry::get('addons.1clue_seo_titles.override_page_titles') == 'Y') {
		// Get the correct product page title
		$_title = Registry::get('addons.1clue_seo_titles.content_page_title');

		// Replace the required values
		$_title = str_replace("{page}", $page['page'], $_title);
		// Parent page name
		if (strstr($_title, "{parent_page}") !== false) {
			$_title = str_replace("{parent_page}", fn_get_page_name($page['parent_id']), $_title);
		}
		
		Registry::get('view')->assign('page_title', $_title);
	}
}
?>