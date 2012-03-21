<?php
require(dirname(__FILE__) . "/global.php");


$fastphp_module = "Default";
$fastphp_action = "Home";
$fastphp_method = "Index";
if(!empty($_REQUEST['actionkey'])) {
	$actionkey = $_REQUEST['actionkey'];
	//检查别名actionkey别名表
	if(isset($__ACTION_KEY_ALIAS[$actionkey])) {
		$fastphp_config = $__ACTION_KEY_ALIAS[$actionkey];
		if(!empty($fastphp_config['Module'])) $fastphp_module = $config['Module'];
		if(!empty($fastphp_config['Action'])) $fastphp_action = $config['Action'];
		if(!empty($fastphp_config['Method'])) $fastphp_method = $config['Method'];
	} else {
		$tmp = explode('.', $_REQUEST['actionkey'], 2);
		if(count($tmp) > 1 && !empty($tmp[1])) $fastphp_method = $tmp[1];
		if(!empty($tmp[0])) {
			$fastphp_action = $tmp[0];
			if(strpos($fastphp_action, "_") > 0) {
				$tmp = explode('_', $fastphp_action, 2);
				$fastphp_module = $tmp[0];
				$fastphp_action = $tmp[1];
			}
		}
	}
}

if($fastphp_module != "Default") {
	$fastphp_action = $fastphp_module . $fastphp_action;
}
$fastphp_action .= "Action";

//Create Action Class
$fastphp_obj = new $fastphp_action;
$fastphp_obj->execute($fastphp_method);

