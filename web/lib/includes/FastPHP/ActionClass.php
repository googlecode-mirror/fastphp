<?php
/**
 * Project:     ActionPHP (The MVC Framework)
 * File:        ActionClass.php
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

class InputCheckException extends Exception {}

/**
 * 请求对象,用于在各个模块之间传递参数
 * @author XuLH <hansen@fastphp.org>
 * @date 2006-06-17
 */
class HttpRequest {
	/** 分支KEY,即$_REQUEST['method'] **/
	private static $METHOD_KEY = "method";
	/** 保存从浏览器提交变量,即$_REQUEST.不可修改 **/
	private $parameters = NULL;
	/** 保存在应用模块内部使用的变量 **/
	private $attributes = NULL;
	/** 分支 **/
	private $methodValue = NULL;

	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->parameters = $_REQUEST;
		if(($pos=strpos($_SERVER['REQUEST_URI'], '?')) !== false) {
			$tmpReturn = array();
			parse_str(substr($_SERVER['REQUEST_URI'], $pos+1), $tmpReturn);
			$this->parameters = array_merge($tmpReturn, $this->parameters);
		}

		/*if(isset($_GET['__xparam'])) {
			$xparam = $_GET['__xparam'];
			$arr = explode("--", $xparam);
			foreach($arr as $data) {
				list($key, $value) = explode("-", $data);
				if(empty($key)) {
					continue;
				}
				$this->parameters[$key] = $value;
			}
		}*/
		if(isset($_GET['__paramstr'])) {
			$paramstr = $_GET['__paramstr'];
			$xparam = explode("?", $paramstr);
			$param = explode('.htm', $xparam[0]);
			$arr = explode("--", $param[0]);
			foreach($arr as $data) {
				list($key, $value) = explode("-", $data);
				if(empty($key)) {
					continue;
				}
				$this->parameters[$key] = $value;
			}

		}
		$this->attributes = array();
	}

	/**
	 * 取得内部分支
	 */
	public function getMethod() {
		if($this->methodValue == null) {
			$this->methodValue = $this->getParameter(self::$METHOD_KEY);
			if($this->methodValue == null) {
				$this->methodValue = $this->getParameter("method");
			}
		}
		return $this->methodValue;
	}

	/**
	 * 取得内部分支
	 */
	public function setMethod($methodValue) {
		$this->methodValue = $methodValue;
	}

	/**
	 * 取得$_REQUEST中的参数
	 */
	public function get($name) {
		return $this->getParameter($name);
	}
	
	public function getParameter($name) {
		if(isset($this->parameters[$name])) {
			return $this->parameters[$name];
		}
		//debug model can log
		//logDebug("NOTICE: $name is not exists.");
		return null;
	}

	public function existsName($name) {
		if(isset($this->parameters[$name])) {
			return true;
		}
		return false;
	}

	/**
	 * 取得属性
	 */
	public function getAttribute($name) {
		if(isset($this->attributes[$name])) {
			return $this->attributes[$name];
		}
		return null;
	}

	/**
	 * 设置属性
	 */
	public function setAttribute($name, $value) {
		if(empty($name)) {
			throw new Exception("attribute name cann't empty.");
		}
		$this->attributes[$name] = $value;
	}
}

/**
 * 响应对象,用于设置向View层传递的参数
 * @author XuLH <hansen@fastphp.org>
 * @date 2006-06-17
 */
class HttpResponse {
	/** 模板文件名 **/
	private $tplName = NULL;
	/** 模板参数 **/
	private $tplValues = NULL;

	/**
	 * 构造函数
	 */
	public function __construct() {
		$this->tplName = NULL;
		$this->tplValues = array();
	}

	/**
	 * 取得模板名
	 */
	public function getTplName() {
		return $this->tplName;
	}

	/**
	 * 设定模板名
	 */
	public function setTplName($tplName) {
		$this->tplName = $tplName;
	}

	/**
	 * 设定(添加)模板参数
	 */
	public function setTplValue($name, $value) {
		if(empty($name)) {
			throw new Exception("tpl value's name cann't empty.");
		}
		$this->tplValues[$name] = $value;
	}

	/**
	 * 取得模板中的值(返回数组)
	 */
	public function getTplValues() {
		return $this->tplValues;
	}
}

/**
 * 响应对象,保存了用于在View层显示的数据
 * @author XuLH <hansen@fastphp.org>
 * @date 2006-06-17
 */
abstract class FastPHP_ActionClass {
	protected $isAjaxFlag = false;
	private $smartyData = "";
	private $defaultMethod = "Index";
	protected $request = null;
	protected $response = null;
	protected $smarty = null;
	
	/**
	 * 检查入力参数,若是系统错误(严重错误,则抛出异常)
	 */
	protected function check() {
	}

	/**
	 * 执行应用逻辑
	 *
	 * @param HttpRequest $request
	 * @param HttpResponse $response
	 * @return void
	 */
	protected function service() {
		if(! $this->request->getMethod()) {
			$this->request->setMethod($this->defaultMethod);
		}
		//设置默认的TPL文件名
		$className = get_class($this);
		if(strlen($className) <= 6 || substr($className, -6) != "Action") {
			throw new Exception("class name({$className}) must end by 'Action'");
		}
		$dirName = substr($className, 0, -6);
		if($pos = strrpos($dirName, "_")) {
			//process Module
			$dirName = str_replace("_", DIRECTORY_SEPARATOR, substr($dirName, 0, $pos+1))
					. substr($dirName, $pos+1);
		} else {
			$dirName = "Default" . DIRECTORY_SEPARATOR . $dirName;
		}
		$method = ucwords($this->request->getMethod());
		$this->request->setAttribute("__TPL_NAME", $dirName.DIRECTORY_SEPARATOR.$method.".tpl");
		$method = 'do'.$method."Action";
		if(method_exists($this, $method)) {
			call_user_func(array($this, $method));
		} else {
			$error = "un-defined method: {$className}.{$method}";
			throw new Exception($error);
		}
	}


	/**
	 * Ajax响应
	 */
	public function setIsAjax($flag) {
		$this->isAjaxFlag = $flag;
	}

	public function getSmartyData() {
		return $this->smartyData;
	}

	public function beforeExecute() { }
	public function beforeDisplay() { }
	public function occurException(Exception $e) { return true; } //返回true表示继续默认处理
	public function afterExecute() { }
	
	/**
	 * Controller层的调用入口函数,在scripts中调用
	 */
	public function execute($method=NULL) {
		static $runCount = 0;
		$runCount++;
		
		// include smarty class
		require_once(__ROOT_PATH . '/lib/includes/Smarty/Smarty.class.php');
		try {
			//开始执行
			$this->beforeExecute();
			
			$this->request = new HttpRequest();
			$this->response = new HttpResponse();
			$this->smarty = new Smarty;
			$this->smarty->template_dir = __ROOT_PATH . "tpls/";
			$this->smarty->compile_dir  = __FILES_PATH . "templates_c/";
			$this->smarty->plugins_dir[] = __ROOT_PATH . 'lib/smarty_plugins';
			$this->smarty->template_dir = __ROOT_PATH . "tpls/";
			//指定method
			if($method != NULL) {
				$this->request->setMethod($method);
			}
			//入力检查
			$this->check();
			//执行方法
			$this->service();
			//完成运行
			$this->afterExecute();
		} catch (InputCheckException $e) {
			if($this->occurException($e)) {
				logWarn($e->getMessage() . "\n" . $e->getTraceAsString());
				if($runCount <= 1) fastphp_run_action("NotFound.Exception");
			}
		} catch (Exception $e) {
			if($this->occurException($e)) {
				logError($e->getMessage() . "\n" . $e->getTraceAsString());
				if($runCount <= 1) fastphp_run_action("NotFound.Exception");
			}
		}
	}

	/**
	 * 调用View层输出
	 */
	public function display($tplName="", $return=false) {
		$this->beforeDisplay();
		if(empty($tplName)) {
			$tplName = $this->request->getAttribute("__TPL_NAME");
		}
		if(empty($tplName)) {
			throw new Exception("template name cann't empty.");
		}
		// diplay the template
		$data = $this->smarty->fetch($tplName);
		$this->smartyData = &$data;
		if($return == false) {
			echo $data;
		} else {
			return $data;
		}
	}
}
