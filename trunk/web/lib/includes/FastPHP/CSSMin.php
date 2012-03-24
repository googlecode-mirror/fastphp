<?php
/**
 * Project:     ActionPHP (The MVC Framework)
 * File:        CSSMin.php
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

class FastPHP_CSSMin {
	
	public static function minify($css, $baseURL) {
	  	$baseURL = trim($baseURL);
		if(substr($baseURL, -1) != "/") {
			$baseURL .= "/";
		}
		//提取所有URL
		$matches = array();
		if(preg_match_all('/url\s*\(([^\)]+)\)/i', $css, $matches)) {
			$cnt = count($matches[0]);
			$searchArr = array();
			$replaceArr = array();
			$map = array();
			for($i=0; $i<$cnt; $i++) {
				if(isset($map[$matches[0][$i]])) {
					continue;
				}
				$map[$matches[0][$i]] = 1;
				$searchArr[] = $matches[0][$i];
				$replaceArr[] = $matches[1][$i];
			}
			$cnt = count($replaceArr);
			for($i=0; $i<$cnt; $i++) {
				$url = trim($replaceArr[$i]);
				if($url != "http://" && $url != "https://" && substr($url, 0, 1) != '/') {
					$url = $baseURL . $url;
				}
				$replaceArr[$i] = "url({$url})";
			}
			//替换操作
			$css = str_replace($searchArr, $replaceArr, $css);
		}
		return $css;
	}
}