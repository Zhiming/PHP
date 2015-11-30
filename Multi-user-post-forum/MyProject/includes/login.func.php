<?php

//Protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//check whether function _alert_back() exists
if(!function_exists('_alert_back')){
	exit('_alert_back()doesn\'t exist, please check it');
}

if(!function_exists('_mysql_string')){
	exit('_mysql_string()doesn\'t exist, please check it');
}
/**
 * _setcookies() generates login cookie
 * @access public
 * @param string $_username
 * @param string $_uniqid
 * return void
 */

function _setcookies($_username, $_uniqid, $_time){
switch ($_time) {
		case '0':  //Explorer progress
			setcookie('username',$_username);
			setcookie('uniqid',$_uniqid);
			break;
		case '1':  //store cookie one day
			setcookie('username',$_username,time()+86400);
			setcookie('uniqid',$_uniqid,time()+86400);
			break;
		case '2':  //one week 
			setcookie('username',$_username,time()+604800);
			setcookie('uniqid',$_uniqid,time()+604800);
			break;
		case '3':  //one month
			setcookie('username',$_username,time()+2592000);
			setcookie('uniqid',$_uniqid,time()+2592000);
			break;
	}
}

/**
 * _check_username() is used for checking and filltering an entered username
 * @access public
 * @param string $_string username from entering
 * @param int_type $_min_num
 * @param int $_max_num
 * @return string username after filtered
 */
function _check_username($_string, $_min_num=2, $_max_num=20){
	//delete spaces around $_string
	$_string = trim($_string);
	
	//the length of username must be between 2-20 characters
	if(strlen($_string)<$_min_num ||strlen($_string)>$_max_num){
		_alert_back('The length of the username must be between '.$_min_num.'-'.$_max_num.' characters');
	}
	
	//restrict sensitive characters
	$_char_pattern = '/[<>\'\"\ \  ]/';
	if(preg_match($_char_pattern, $_string)){
		_alert_back('Username cannot contain special characters');
	}
	return _mysql_string($_string);
}

/**
 * check a password
 * @access public
 * @param string $_first_pass
 * @param string $_end_pass
 * @param int $length_pass
 * @return string $_firsti_pass encrypted by sha1
 */
function _check_password($_string, $length_pass=6){
	//check the password
	if(strlen($_string)<$length_pass){
		_alert_back('Password must be longer than '.$length_pass.' digits');
	}

	return _mysql_string(sha1($_string));
}

function _check_time($_string){
	$_time = array('0','1','2','3');
	if(!in_array($_string, $_time)){
		_alert_back('A mistake happened in auto login');
	}
	return  _mysql_string($_string);
}
?>