<?php
/**
 * Project:     ActionPHP (The MVC Framework) 
 * File:        define.php
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

// Site Runtime Environment. Two value options: DEVELOPMENT or PRODUCTION
// Note: Please set PRODUCTION when your site released.
define("__SITE_ENV", "DEVELOPMENT");

/// web urls ///
define("__HOME_URL", dirname($_SERVER['PHP_SELF'])."/");

/// DB config ///
define("__DEFAULT_DSN", "mysql://root:@localhost/test?charset=UTF8");

define("__RESOURCE_BASE_URL", __HOME_URL."res/");

$__IMAGE_DOMAINS = array(
	$_SERVER['HTTP_HOST'],
);

// sphinx search
define("__SPHINX_HOST", "127.0.0.1");
define("__SPHINX_PORT", 9312);

/// directory ///
define("__PHP_CLI", "php ");

/// physical path ///
define("__FILES_PATH", __ROOT_PATH."files/");
define("__SETTING_PATH", __ROOT_PATH."files/setting/");

// Site Fingerprint - recommend you to change to a random security code
define("__SITE_FINGERPRINT", md5(__DEFAULT_DSN.__FILE__));

// Log Level - smaller value will more log
// Note: __LOG_LEVEL==0 and __SITE_ENV=='DEVELOPMENT' 
//       __LOG_LEVEL==0 and __SITE_ENV=='PRODUCTION' and $_COOKIE['HP_DEBUG_MSG'] == md5('PRINT-'.__SITE_FINGERPRINT)
//       will print debug message on the bottom of html page  
define("__LOG_LEVEL", 2); //0: DEBUG and PRINT; 1: DEBUG; 2: INFO; 3: WARN; 4: ERROR

// The default timezone for PHP runtime
define("__TIMEZONE", "Asia/Shanghai");
// The default charset for mbstring, DB, HTML page
define("__CHARSET", "UTF-8");

// Email Sender
define("__MAIL_SMTP", "smtp.exmail.qq.com");
define("__MAIL_SMTP_PORT", 465);
define("__MAIL_SMTP_USER", "youname@fastphp.org");
define("__MAIL_SMTP_PASSWORD", "youpassword");
define("__MAIL_SMTP_SSL", "ssl");


