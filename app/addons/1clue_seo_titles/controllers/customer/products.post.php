<?php
use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($mode == 'view') {
	$product_data = Registry::get('view')->get_var('product');

	if (empty($product_data['page_title']) || Registry::get('addons.1clue_seo_titles.override_product_titles') == 'Y') {
		// Get the correct product page title
		$_title = Registry::get('addons.1clue_seo_titles.product_page_title');

		// Replace the required values
		$_title = str_replace("{product_code}", $product_data['product_code'], $_title);
		$_title = str_replace("{price}", $product_data['base_price'], $_title);
		$_title = str_replace("{product}", $product_data['product'], $_title);
		// Main category name
		if (strstr($_title, "{category}") !== false) {
			$_title = str_replace("{category}", fn_get_category_name($product_data['main_category']), $_title);
		}
		// Category path
		if (strstr($_title, "{category_path}") !== false) {
			$breacrumps = Registry::get('view')->get_var('breadcrumbs');
			$cat_path = "";
			foreach ($breacrumps as $item) {
				if (strstr($item['link'], "categories.view") !== false) {
					$cat_path .= $item['title'] . " :: ";
				}
			}
			$_title = str_replace("{category_path}", rtrim($cat_path," :: "), $_title);
		}
		
		Registry::get('view')->assign('page_title', $_title);
	}
}

?>