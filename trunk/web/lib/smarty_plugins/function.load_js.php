<?php


function smarty_function_load_js($params, &$smarty) {
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
	$result = __auto_create_js_cache($files);
	$url = 'system/js.php?key='.$result['md5key']."&res=".$result['resdir'];
	echo "<script language='JavaScript' src='{$url}'></script>\r\n";
}

function __auto_create_js_cache($files) {
	//1. 检查文件是否存在，并取得最后修改时间
	$loadFiles = array();
	$check = "";
	$resdir = "";
	foreach($files as $file) {
		$file = str_replace(array('//', '..'), array('/', ''), $file);
		if($file == '' || substr($file, -3) != '.js')  continue;
		if(substr($file, 0, 1) == '/') $file = substr($file, 1);
		$pathfile = __ROOT_PATH.'res/js/'.$file;
		$modifyTime = @filemtime($pathfile);
		if($modifyTime == false) {
			logWarn("Load JS ERROR - miss file: ".$pathfile);
			continue;
		}
		$resdir .= substr($file, 0, 1); //取文件名的第一个字母作为文件名
		$check .= $file . '|' . $modifyTime . '|';
		$loadFiles[] = array('file'=>$file, 'mtime'=>$modifyTime);
	}
	//2. 检查是否有缓存文件
	$md5key = md5($check);
	$result = array('resdir'=>$resdir, 'md5key'=>$md5key);
	$cacheFile = __ROOT_PATH.'files/res_c/js/'.$resdir.'/'.$md5key.'.js';
	if(file_exists($cacheFile)) {
		return $result;
	}
	$data = "";
	foreach($loadFiles as $info) {
		//检查是否已是.min文件
		$originFile = __ROOT_PATH.'res/js/'.$info['file'];
		if(substr($info['file'], -7, 4) != '.min') { //转换为.min文件
			$minFile = __ROOT_PATH.'files/res_c/jsmin/'.substr($info['file'], 0, -2).$info['mtime'].'.min.js';
			if(file_exists($minFile) == false) {
				$str = JSMin::minify(file_get_contents($originFile));
				if(file_exists(dirname($minFile)) == false) {
					mkdir(dirname($minFile), 0777, true);
				}
				file_put_contents($minFile, $str);
			} else {
				$str = file_get_contents($minFile);
			}
		} else { //源文件已是压缩过的，直接读取
			$str = file_get_contents($originFile);
		}
		$data .= $str . "\r\n";
	}
	if(file_exists(dirname($cacheFile)) == false) {
		mkdir(dirname($cacheFile), 0777, true);
	}
	file_put_contents($cacheFile, $data);
	return $result;
}