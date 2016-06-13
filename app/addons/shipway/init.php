<?php

if (!defined('BOOTSTRAP')) { die('Access denied'); }
fn_register_hooks(
	'create_shipment'	
);

// adding language variable
	$lang_var = array(
				array(
					'name' 		=> 'shipway',
					'value'		=> 'Shipway'
				)
			);
	if (!empty($lang_var)) {
            $params = array('clear' => false);
            foreach (fn_get_translation_languages() as $lc => $_v) {
                fn_update_lang_var($lang_var, $lc, $params);
            }
    }