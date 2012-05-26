<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        resource.php
 *
 * This framework is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author XuLH <hansen@fastphp.org>
 */

require(dirname(__FILE__) . "/global.php");

$type = substr($_REQUEST['type_c'], 0, -2); //忽略最后两位“_c”
$md5key = filterRelativePath($_REQUEST['key']);
$resdir = filterRelativePath($_REQUEST['res']);

if ($_SERVER['HTTP_IF_NONE_MATCH'] == $md5key) {
    header("HTTP/1.1 304 Not Modified");
} else if($type == "js" || $type == "css") {
	$cacheFile = __FILES_PATH."res_c/{$type}/{$resdir}/{$md5key}.{$type}";
	if($type == "css") {
		header("Content-Type: text/css");
	} else if($type == "js") {
		header("Content-Type: application/javascript");
	}
	header("Content-Encoding: gzip");
	header("Etag: ".$md5key);
	$expires = 365*86400; //客户端缓存1年
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	
	$data = file_get_contents($cacheFile);
	echo gzencode($data);
} else {
	logWarn("Unknown type: {$type}.");
}
