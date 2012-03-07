<?php
require(dirname(__FILE__) . "/global.php");

if(!empty($_REQUEST['actionkey'])) {
	$actionkey = $_REQUEST['actionkey'];
	if(!isset($__ACTION_KEY[$actionkey])) {
		logError("The actionkey is unknown.({$actionkey}).");
		redirect302("/");
	}
	$config = $__ACTION_KEY[$actionkey];
	//echo $actionkey."<br>";
	if($config['Module'] != "Default") {
		$action = $config['Module'] . '_';
	} else {
		$action = "";
	}
	$action .= $config['Action'] . "Action";
	$method = $config['Method'];
} else {
	$action = "HomeAction";
	$method = "Index";
	if(!empty($_REQUEST['actionphp'])) {
		$tmp = explode('.', $_REQUEST['actionphp'], 2);
		$action = $tmp[0].'Action';
		if(count($tmp) > 1) {
			$method = $tmp[1];
		}
	}
}

//Create Action Class

$obj = new $action;
$obj->execute($method);
