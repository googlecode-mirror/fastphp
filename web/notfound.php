<?php
if(!defined("__FILE_NOTFOUND_PHP")) {
	define("__FILE_NOTFOUND_PHP", true);

	require(dirname(__FILE__) . "/global.php");
	
	global $__ACTION_KEY;
	
	header("HTTP/1.0 404 Not Found");
	$actionkey = "notfound";
	if(!isset($__ACTION_KEY[$actionkey])) {
		logError("The actionkey is unknown.({$actionkey}).");
		redirect302("/");
	}
	$config = $__ACTION_KEY[$actionkey];
	if($config['Module'] != "Default") {
		$action = $config['Module'] . '_';
	} else {
		$action = "";
	}
	$action .= $config['Action'] . "Action";
	$method = $config['Method'];
	$obj = new $action;
	$obj->execute($method);
} else {
	die("twice include notfound.php");
	redirect302("/");
}