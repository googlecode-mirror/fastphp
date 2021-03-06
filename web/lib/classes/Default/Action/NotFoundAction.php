<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        NotFoundAction.php
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


class NotFoundAction extends BaseAction {
	
	public function doIndexAction() {
		header("HTTP/1.1 404 NotFound");
		println("404 NotFound");
	}
	/**
	 * 程序异常处理
	 */
	public function doExceptionAction() {
		global $fastphp_ErrorMessage;
		header("HTTP/1.1 500 Internal Server Error");
		if(empty($fastphp_ErrorMessage) || !ini_get("display_errors")) {
			println("500 Internal Server Error");
		} else {
			println("<pre>");
			println("500 Internal Server Error\r\n");
			println($fastphp_ErrorMessage);
			println("</pre>");
		}
	}
}