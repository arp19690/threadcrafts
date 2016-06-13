<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;

function fn_cp_ajax_update_apply_options_rules_post(&$product) {
    $product['options_update'] = true;
}