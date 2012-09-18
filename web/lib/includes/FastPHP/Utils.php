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

class FastPHP_Utils {
	
	/**
	 * 列出目录的文件列表,不包括目录
	 * @path 路径
	 * @sortBy 排序方式(默认,文件名称,更新时间)
	 */
	public static function listFiles($path, $orderBy=NULL, $orderType="SORT_ASC") {
		if(is_dir($path) == false) {
			return NULL;
		}
		$handle = opendir($path);
		if($handle == false) {
			return NULL;
		}
		$fileList = array();
		while( false != ($file = readdir($handle)) ) {
			if(is_dir($path . $file)) {
				continue;
			}
			$fileInfo['Name'] = $file;
			$fileInfo['Modified'] = filemtime($path . $file);
			$fileList[] = $fileInfo;
		}
		closedir($handle);
		if($orderBy == "Name") {
			$fileList = sortArray($fileList, "Name", $orderType);
		} else if($orderBy == "Modified") {
			$fileList = sortArray($fileList, "Modified", $orderType);
		}
		return $fileList;
	}
	
}