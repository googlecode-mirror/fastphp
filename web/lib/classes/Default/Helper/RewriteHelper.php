<?php
class RewriteHelper {
	public static function getURL($type, $params=null) {
		switch($type) {
			case 'css':
			case 'img':
			case 'js':
			case 'file':
				$url = self::getResource($type, $params['url']);
				break;
			default:
				$url = self::getCustomPage($type, $params);
				break;
		}
		return $url;
	}
	
	protected static function getCustomPage($type, $params) {
		switch($type) {
		default:
			$url = __HOME_URL."action.php?actionphp=".$type;
			if(empty($params)) {
				return $url;
			}
			$str = "";
			foreach($params as $key => $val) {
				$str .= "&{$key}=".urlencode($val);
			}
			$url .= $str;
		}
		return $url;
	}

	protected static function getOtherPage($type, $params) {
		
	}

	protected static function getResource($type, $params) {
		$domain = self::getResourceDomain($url);
		$version = "";
		switch($type) {
			case 'css':
				$prefix = "/res/css/";
				if(defined("__VERSION_CSS")) $version = __VERSION_CSS;
				break;
			case 'img':
				$prefix = "/res/img/";
				if(defined("__VERSION_IMG")) $version = __VERSION_IMG;
				break;
			case 'js':
				$prefix = "/res/js/";
				if(defined("__VERSION_JS")) $version = __VERSION_JS;
				break;
			case 'file':
				$domain = self::getImageDomain($url);
				$url = "http://{$domain}".$url;
				break;
			default:
				throw new Exception("unknown type.({$type})");
		}
		$url = "http://{$domain}".$prefix . $url;
		if($version != "") $url .= "?".$version;
		return $url;
	}
	
	protected static function getResourceDomain($key) {
		global $__RESOURCE_DOMAINS;
		$len = strlen($key);
		$sum = 0;
		for($i=0; $i<$len; $i++) {
			$sum += ord($key[$i]);
		}
		$mode = $sum % count($__RESOURCE_DOMAINS);
		return $__RESOURCE_DOMAINS[$mode];
	}
	
	
}