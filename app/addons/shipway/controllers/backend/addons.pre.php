<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($mode == 'update') {
			if (isset($_REQUEST['addon_data'])) {
				if($_REQUEST['addon'] == 'shipway' && isset($_REQUEST['addon_data']['options']) ){
					$shipway_password = array_pop( $_REQUEST['addon_data']['options'] );
					$shipway_login_id = array_pop( $_REQUEST['addon_data']['options'] );
					if(!fn_check_shipway_user($shipway_login_id,$shipway_password)){
						fn_set_notification("E","Error: ","Shipway Login ID or Licence Key is incorrect.");
						return array(CONTROLLER_STATUS_REDIRECT, 'addons.update?addon=' . $_REQUEST['addon']);
					}
				}
			}
	}
}