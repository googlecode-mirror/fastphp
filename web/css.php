<?php
require(dirname(__FILE__) . "/../global.php");

$md5key = $_REQUEST['key'];
$resdir = $_REQUEST['res'];
$cacheFile = __ROOT_PATH.'files/res_c/css/'.$resdir.'/'.$md5key.'.js';

header("Content-Type: text/css");
header("Content-Encoding: gzip");
$expires = 60*60*24;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');


$data = file_get_contents($cacheFile);
echo gzencode($data);
