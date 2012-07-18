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

class ResourceHelper {
	public static function isExternalOpen() {
		global $_RESOURCE_CONFIG;
		$ret = false;
		if(defined("__EXTERNAL_RES_SWITCH") && __EXTERNAL_RES_SWITCH) {
			$ret = __EXTERNAL_RES_SWITCH;
		}
		if(isset($_RESOURCE_CONFIG['EXTERNAL_SWITCH'])) {
			$ret = $_RESOURCE_CONFIG['EXTERNAL_SWITCH'];
		}
		return $ret;
	}
	
	public static function getLoadMethod() {
		global $_RESOURCE_CONFIG;
		$ret = "ORIGIN";
		if(defined("__RESOURCE_LOAD_METHOD") && __RESOURCE_LOAD_METHOD) {
			$ret = __RESOURCE_LOAD_METHOD;
		}
		if(isset($_RESOURCE_CONFIG['LOAD_METHOD'])) {
			$ret = $_RESOURCE_CONFIG['LOAD_METHOD'];
		}
		return $ret;
	}
}