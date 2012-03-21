<?php
class FastPHP_Cache {
	
	public static function getFileCache($file) {
		if(file_exists($file) == false) return false;
		$data = file_get_contents($file);
		if(($pos=strpos($data, "\n")) === false) {
			return false;
		}
		if(time() >= substr($data, 0, $pos)) {
			return false;
		}
		return unserialize(substr($data, $pos+1));
	}
	
	public static function setFileCache($file, $data, $cacheTime=3600) {
		if(file_exists(dirname($file))) mkdir(dirname($file), 0777, true);
		$str = (time()+$cacheTime)."\n".serialize($data);
		file_put_contents($file, $str);
	}
	
}