<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        Cache.php
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