<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        BaseAction.php
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

class SampleDao {
	public static function fetchList($params, $ps, $pn=1) {
		$params = DBQuery::filter($params);
		$sql = "SELECT * FROM t_TestTable WHERE 1=1";
		$sql .= " LIMIT ".(($pn-1)*$ps).",".$pn;
		$rs = DBQuery::instance()->getAll($sql);
		return $rs;
	}
}