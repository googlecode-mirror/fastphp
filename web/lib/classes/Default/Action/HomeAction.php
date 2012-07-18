<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        HomeAction.php
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


class HomeAction extends BaseAction {
	
	public function doIndexAction() {
		//这是站点首页
		//可通过以下URL访问：
		//		/index.php  -  不带任何参数
		//		/action.php?actionkey=Home  -  仅使用Action名
		//		/action.php?actionkey=Default_Home  -  Module+Action
		//		/action.php?actionkey=Default_Home.Index  -  Module+Action+Method
		
		//TODO：正式编写代码前，移除下两行代码 
		$url = RewriteHelper::getURL("Sample");
		echo "<a href='{$url}'>Demo</a>";
		
	}
}