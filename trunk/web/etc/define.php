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

if(DIRECTORY_SEPARATOR == "/") { //linux
	define("__SITE_ENV", "PRODUCTION");

	/// web urls ///
	define("__HOME_URL","/");

	/// DB config ///
	define("__DEFAULT_DSN", "mysql://root:@localhost/test?charset=UTF8");
	
	$__RESOURCE_DOMAINS = array(
		$_SERVER['HTTP_HOST'],
	);
		
	$__IMAGE_DOMAINS = array(
		$_SERVER['HTTP_HOST'],
	);
	
	// sphinx search
	define("__SPHINX_HOST", "127.0.0.1");
	define("__SPHINX_PORT", 9312);
	
	/// directory ///
	define("__PHP_CLI", "php ");
} else { //windows
	define("__SITE_ENV", "DEVELOPMENT");
	/// web urls ///
	define("__HOME_URL","http://".$_SERVER['HTTP_HOST']."/");

	/// DB config ///
	define("__DEFAULT_DSN", "mysql://root:@localhost/test?charset=UTF8");

	$__RESOURCE_DOMAINS = array(
		$_SERVER['HTTP_HOST'],
	);
	$__IMAGE_DOMAINS = array(
		$_SERVER['HTTP_HOST'],
	);
	
	// sphinx search
	define("__SPHINX_HOST", "127.0.0.1");
	define("__SPHINX_PORT", 9312);
	
	/// directory ///
	define("__PHP_CLI", "php ");
}

/// physical path ///
define("__FILES_PATH", __ROOT_PATH."files/");
define("__SETTING_PATH", __ROOT_PATH."files/setting/");

// enable debug.
define("__LOG_LEVEL", 0); //0: Print DEBUG info; 1: DEBUG; 2: INFO; 3: WARN; 4: ERROR


define("__CHARSET", "UTF-8");

// Email Sender
define("__MAIL_SMTP", "smtp.exmail.qq.com");
define("__MAIL_SMTP_PORT", 465);
define("__MAIL_SMTP_USER", "youname@fastphp.org");
define("__MAIL_SMTP_PASSWORD", "youpassword");
define("__MAIL_SMTP_SSL", "ssl");


