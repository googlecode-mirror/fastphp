<?php


function smarty_function_load_css($params, &$smarty) {
	$files = array();
	foreach($params as $key => $val) {
		if(substr($key, 0, 4) == 'file') {
			$val = trim($val);
			if($val == '') continue;
			$num = intval(substr($key, 4));
			$files[$num] = $val;
		}
	}
	ksort($files);
	if(__LOG_LEVEL <= 1) { //DEBUG状态
		foreach($files as $file) {
			$url = RewriteHelper::getURL("css", array("file"=>$file));
			echo "<link href='{$url}' rel='stylesheet' />\r\n";
		}
	} else {
		$result = __auto_create_css_cache($files);
		$url = RewriteHelper::getURL("css_c", array("key"=>$result['md5key'],"res"=>$result['resdir']));
		echo "<link href='{$url}' rel='stylesheet' />\r\n";
	}
}

function __auto_create_css_cache($files) {
	//1. 检查文件是否存在，并取得最后修改时间
	$loadFiles = array();
	$check = "";
	$resdir = "";
	foreach($files as $file) {
		$file = str_replace(array('//', '..'), array('/', ''), $file);
		if($file == '' || substr($file, -4) != '.css')  continue;
		if(substr($file, 0, 1) == '/') $file = substr($file, 1);
		$pathfile = __ROOT_PATH.'res/css/'.$file;
		$modifyTime = @filemtime($pathfile);
		if($modifyTime == false) {
			logWarn("Load CSS ERROR - miss file: ".$pathfile);
			continue;
		}
		$resdir .= substr($file, 0, 1); //取文件名的第一个字母作为文件名
		$check .= $file . '|' . $modifyTime . '|';
		$loadFiles[] = array('file'=>$file, 'mtime'=>$modifyTime);
	}
	//2. 检查是否有缓存文件
	$md5key = md5($check);
	$result = array('resdir'=>$resdir, 'md5key'=>$md5key);
	$cacheFile = __FILES_PATH.'res_c/css/'.$resdir.'/'.$md5key.'.css';
	if(file_exists($cacheFile)) {
		return $result;
	}
	$data = "";
	foreach($loadFiles as $info) {
		$originFile = __ROOT_PATH.'res/css/'.$info['file'];
		$str = file_get_contents($originFile);
		$baseURL = __RESOURCE_BASE_URL."css/";
		$subdir = dirname($info['file']);
		if($subdir != "") {
			$baseURL .= $subdir . "/";
		}
		$str = FastPHP_CSSMin::minify($str, $baseURL);
		$data .= $str . "\r\n";
	}
	if(file_exists(dirname($cacheFile)) == false) {
		mkdir(dirname($cacheFile), 0777, true);
	}
	file_put_contents($cacheFile, $data);
	return $result;
}