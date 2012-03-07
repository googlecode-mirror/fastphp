<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        SampleAction.php
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
 * 获得当前时间
 * @return datetime Format:2006-03-06 18:10:10
 */
function getDateTime() {
	//GMT
	return date("Y-m-d H:i:s");
	//GMT+8
	//return date("Y-m-d H:i:s", strtotime('+8 HOUR'));
}

/**
 * 作日志并终止程序: 系统错误,用于输入的关键参数错误
 * @param message
 */
function logFatal($message, $model="", $level="FATAL") {
	writeLog("fatal.log", $message);
	echo "fatal.";
	exit;
}

/**
 * 错误日志: 系统错误,用在处理模块中被检测到
 * @param message
 */
function logError($message, $model="", $level="ERROR") {
	writeLog("error.log", $message);
	if(defined("__LOG_LEVEL") && __LOG_LEVEL <= 1 && $model != __MODEL_EMPTY) { // 1: DEBUG
		printDebugMessage($message);
	}
}

/**
 * 警告日志: 数据错误
 * @param message
 */
function logWarn($message, $model="", $level="WARN") {
	if(defined("__LOG_LEVEL") && __LOG_LEVEL <= 3) { // 3: WARN
		writeLog("warn.log", $message);
	}
}

/**
 * 消息日志: 重要操作的日志
 * @param message
 */
function logInfo($message, $model="", $level="INFO") {
	if(defined("__LOG_LEVEL") && __LOG_LEVEL <= 2) { // 2: INFO
		writeLog("info.log", $message);
	}
}

/**
 * 调试(详细)日志
 * @param message
 */
function logDebug($message, $model="", $level="DEBUG") {
	if(defined("__LOG_LEVEL") && __LOG_LEVEL <= 1) { // 1: DEBUG
		writeLog("debug.log", $message);
		if(__LOG_LEVEL == 0) {
			printDebugMessage($message);
		}
	}
}

function writeLog($file, $message) {
	$path = __FILES_PATH . "logs/";
	if(file_exists($path) == false) {
		mkdir($path, 0777, true);
	}
	$message = getDateTime() . " - " . $message . "\r\n";
	$fp = fopen($path.$file, "a+");
	flock($fp, LOCK_EX);
	fwrite($fp, $message);
	flock($fp, LOCK_UN);
	fclose($fp);
}

function printDebugMessage($message) {
	static $sMessage = "";
	static $sPrintNow = "SYS_2xzWu[2,u/1aoz";
	static $sRegisterShutdown = false;
	if(defined("__SITE_ENV") && __SITE_ENV == "PRODUCTION"
		&& $_COOKIE['HP_DEBUG_MSG'] != "PRINT") {
		return;
	}
	if($message == $sPrintNow) {
		$message = "";
		if($sMessage != "") {
			println("\n<BR><HR><PRE>");
			println($sMessage);
			$sMessage = "";
			println("</PRE>");
		}
		return;
	}
	if($message == "") {
		return;
	}
	$sMessage .= $message ."\n";
	if($sRegisterShutdown == false) {
		register_shutdown_function(printDebugMessage, $sPrintNow);
		$sRegisterShutdown = true;
	}
}

function println($msg) {
	echo $msg."\r\n";
}
function redirect302($url) {
	header("Location: ".$url);
	exit;
}

function md5long($md5str) {
	if(strlen($md5str) != 32) return 0;
	$long = 0;
	$k = 1;
	for($i=0; $i<16; $i++) {
		$ch = ord($md5str[$i]);	
		
		if($ch >= 48 && $ch <= 57) {
			$num = $ch - 48;
		} else if($ch >= 97 && $ch <= 102) {
			$num = $ch - 87;
		} else if($ch >= 65 && $ch <= 70) {
			$num = $ch - 55;
		} else { //unknown char
			return 0;
		}
		if($i % 15 == 0) $k = 1;
		$long += $num * $k;
		$k *= 16;
	}
	return $long;
}

// 二维数组排序函数
function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR")
{
  if(!is_array($ArrayData))
  {
    return $ArrayData;
  }
  // Get args number.
  $ArgCount = func_num_args();
  // Get keys to sort by and put them to SortRule array.
  for($I = 1;$I < $ArgCount;$I ++)
  {
    $Arg = func_get_arg($I);
    if(!preg_match("/SORT/",$Arg))
    {
      $KeyNameList[] = $Arg;
      $SortRule[]    = '$'.$Arg;
    }
    else
    {
      $SortRule[]    = $Arg;
    }
  }
  // Get the values according to the keys and put them to array.
  foreach($ArrayData AS $Key => $Info)
  {
    foreach($KeyNameList AS $KeyName)
    {
      ${$KeyName}[$Key] = $Info[$KeyName];
    }
  }
  
  // Create the eval string and eval it.
  $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
  eval ($EvalString);
  return $ArrayData;
}


