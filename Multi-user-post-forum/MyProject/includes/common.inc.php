<?php

//Absolute pathname
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//This constant is used to set automatic escaping
//get_magic_quotes_gpc() is used to check whether automatic escaping is turned on
define('GPC', get_magic_quotes_gpc());

//include the function library
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

//Protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//Lower PHP version couldn't access
if (PHP_VERSION < '4.1.0') {
	exit('Version is to Low!');
}

//For measuring loading tiime, if needed
//define('START_TIME', _runtime());

define('DB_HOST', 'localhost');
define('DB_USER','root');
define('DB_PWD','');
define('DB_NAME', 'testguest');

//initiate a database
_connnect();
_select_db();
_set_names();


//message reminder
if(isset($_COOKIE['username'])){
	$_message = _fetch_array("SELECT 
									COUNT(tg_id) 
						          AS 
									count 
							    FROM 
									tg_message 
							   WHERE 
									tg_state=0
								 and
								    tg_touser='{$_COOKIE['username']}'
	                         ");
	if(empty($_message['count'])){
		$GLOBALS['message'] = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
	} else{
		$GLOBALS['message'] = '<strong class="read"><a href="member_message.php">('.$_message['count'].')</a></strong>';
	}
}
	
//website initialization
if (!!$_rows = _fetch_array("SELECT 
															tg_webname,
															tg_article,
															tg_blog,
															tg_photo,
															tg_skin,
															tg_post,
															tg_re
												FROM 
															tg_system 
											 WHERE 
															tg_id=1 
												 LIMIT 
															1"
)){
	$_system = array();
	$_system['webname'] = $_rows['tg_webname'];
	$_system['article'] = $_rows['tg_article'];
	$_system['blog'] = $_rows['tg_blog'];
	$_system['photo'] = $_rows['tg_photo'];
	$_system['skin'] = $_rows['tg_skin'];
	$_system['post'] = $_rows['tg_post'];
	$_system['re'] = $_rows['tg_re'];
	$_system = _html($_system);
	
	//if the cookie['skin'] exists, assign its value to $_system['skin']
	if (isset($_COOKIE['skin'])) {
		$_system['skin'] = $_COOKIE['skin'];
	}
	
} else{
	exit('Abnormal system table, please check it');
}

?>