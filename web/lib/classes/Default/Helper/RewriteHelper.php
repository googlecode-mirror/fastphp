<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        RewriteAction.php
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

class RewriteHelper {
	public static function getURL($type, $params=null) {
		switch($type) {
			case 'css':
			case 'img':
			case 'js':
			case 'file':
				$url = self::getResource($type, $params['file']);
				break;
			case 'css_c':
			case 'js_c':
				$url = self::getCompiledResource($type, $params);
				break;
			default:
				$url = self::getCustomPage($type, $params);
				break;
		}
		return $url;
	}
	
	protected static function getCustomPage($type, $params) {
		//Note: 在此编写自定义的URL规则
		switch($type) {
		default:
			$url = self::getDefaultPage($type, $params);
		}
		return $url;
	}

	protected static function getDefaultPage($type, $params) {
		$url = __HOME_URL."action.php?actionkey=".$type;
		if(empty($params)) {
			return $url;
		}
		$str = "";
		foreach($params as $key => $val) {
			$str .= "&{$key}=".urlencode($val);
		}
		$url .= $str;
		return $url;
	}

	protected static function getResource($type, $url) {
		$baseURL = __RESOURCE_BASE_URL;
		$prefix = "";
		$version = "";
		switch($type) {
			case 'css':
				$prefix = "css/";
				if(defined("__VERSION_CSS")) $version = __VERSION_CSS;
				break;
			case 'img':
				$prefix = "img/";
				if(defined("__VERSION_IMG")) $version = __VERSION_IMG;
				break;
			case 'js':
				$prefix = "js/";
				if(defined("__VERSION_JS")) $version = __VERSION_JS;
				break;
			case 'file':
				$domain = self::getImageDomain($url);
				$baseURL = "http://{$domain}/";
				break;
			default:
				throw new Exception("unknown type.({$type})");
		}
		$url = $baseURL . $prefix . $url;
		if($version != "") $url .= "?".$version;
		return $url;
	}
	
	protected static function getCompiledResource($type, $params) {
		$url = __HOME_URL . "resource.php?type_c=".$type;
		$str = "";
		foreach($params as $key => $val) {
			$str .= "&{$key}=".urlencode($val);
		}
		$url .= $str;
		return $url;
	}
	
}