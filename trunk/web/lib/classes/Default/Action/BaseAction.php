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

/**
 * 响应对象,保存了用于在View层显示的数据
 * @author XuLH <hansen@fastphp.org>
 * @date 2006-06-17
 */
abstract class BaseAction extends FastPHP_ActionClass {
	private $messages = array();
	private $displayDisabled = false;
	private $startTime = 0;
	
	/**
	 * 检查入力参数,若是系统错误(严重错误,则抛出异常)
	 */
	protected function check() {
	}

	/**
	 * 资源回收
	 */
	protected function release() { }

	/**
	 * 禁用显示
	 */
	public function setDisplayDisabled($flag) {
		$this->displayDisabled = $flag;
	}
	
	/**
	 * 发送消息
	 *
	 * @param $msg - 消息内容
	 * @param $sendtoNextPage - 发布到下一个页面
	 */
	public function sendMessage($msg, $sendtoNextPage=false) {

		if($sendtoNextPage) {
			$_SESSION['base_messages'][] = $msg;

		} else {
			$this->messages[] = $msg;
		}
	}
	
	public function beforeExecute() {
		$this->startTime = microtime(true);
		session_start();
		header("Content-type: text/html; charset=".__CHARSET);
		//提取SESSION中的message
		if(isset($_SESSION['base_messages']) && $_REQUEST["ajax"] != 'yes') {
			$this->messages = $_SESSION['base_messages'];
			unset($_SESSION['base_messages']);
		}
	}
	
	public function beforeDisplay() {
		//设置默认值(项目相关)
		$this->smarty->assign("__DOCTYPE", '<!DOCTYPE HTML PUBLIC '
			. '"-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">');
		$this->smarty->assign("__CHARSET", __CHARSET);
		$this->smarty->assign("__MESSAGES", $this->messages);
		$this->smarty->assign("__MESSAGE_STR", implode("\n",$this->messages));
		//默认增加页面类型的META规则调用
		$tplValues = array();
		if(!isset($tplValues['meta']) && ($actionkey = $this->request->getParameter("actionkey"))) {
		//	$tplValues['meta'] = SEOMetaDao::getMeta($actionkey);
		}
		$this->smarty->assign($tplValues);
	}
	
	public function afterExecute() {
		if($this->displayDisabled == false && $this->isAjaxFlag == false) {
			logDebug("<center>页面执行时间 ".(microtime(true)-$$this->startTime)."s</center>");
		}
		
	}
}
