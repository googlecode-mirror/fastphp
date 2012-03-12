<?php
if(!defined("__FILE_GLOBAL_PHP")) {

define("__FILE_GLOBAL_PHP", true);
define("__ROOT_PATH", dirname(__FILE__)."/");

date_default_timezone_set("Asia/Shanghai");
mb_internal_encoding("UTF-8");

/**
 * 自动装载类
 * 类目录结构：
 * 		1. ClassName中以“_”分隔，作为类的各级目录名。
 * 		2. “Action, Dao”后缀的根目录是：lib/classes/{ModuleName}/{action|dao}/。 
 *	 			{ModuleName}是类名中“_”分隔的部分，默认取“default”
 * 		3. 默认类的根目录为lib/includes/
 */
function __autoload($class) {
	$pathArr = explode("_", $class);
	//echo $class."<br>";
	$className = $pathArr[count($pathArr) - 1];
	if(count($pathArr) > 1) {
		$classPath = implode("/", array_slice($pathArr, 0, -1));
	} else {
		$classPath = "";
	}
	
	if(substr($class, -3) == "Dao") {
		if($classPath == "") {
			$classPath = "Default";
		}
		$classPath = __ROOT_PATH . "lib/classes/" . $classPath . "/Dao/";
	} else if(substr($class, -6) == "Action") {
		if($classPath == "") {
			$classPath = "Default";
		}
		$classPath = __ROOT_PATH . "lib/classes/" . $classPath . "/Action/";
	} else if(substr($class, -6) == "Helper") {
		if($classPath == "") {
			$classPath = "Default";
		}
		$classPath = __ROOT_PATH . "lib/classes/" . $classPath . "/Helper/";
	} else {
		$classPath = __ROOT_PATH . "lib/includes/" . $classPath . "/";
	}
	//echo $classPath . $className."<br>";
	include_once($classPath . $className . ".php");
}

require_once(__ROOT_PATH . "etc/define.php");
require_once(__ROOT_PATH . "lib/functions/func.Common.php");

//自动创建必要目录
if(file_exists(__FILES_PATH . "templates_c/") == false) {
	mkdir(__FILES_PATH . "logs/");
	mkdir(__FILES_PATH . "templates_c/");
}

} //end of __FILE_GLOBAL_PHP
