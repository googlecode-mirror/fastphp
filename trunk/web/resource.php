<?php
require(dirname(__FILE__) . "/global.php");

$type = $_REQUEST['type'];
$md5key = filterRelativePath($_REQUEST['key']);
$resdir = filterRelativePath($_REQUEST['res']);

if($type == "js" || $type == "css") {
	$cacheFile = __ROOT_PATH."files/res_c/{$type}/{$resdir}/{$md5key}.{$type}";
	
	header("Content-Type: text/x-javascript");
	header("Content-Encoding: gzip");
	$expires = 60*60*24;
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	
	$data = file_get_contents($cacheFile);
	echo gzencode($data);
} else {
	logWarn("Unknown type: {$type}.");
}
