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
		
	}

	protected static function getOtherPage($type, $params) {
		
	}

	protected static function getResource($type, $params) {
		
	}
}