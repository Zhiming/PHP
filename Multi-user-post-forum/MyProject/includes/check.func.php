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
 * 
 * _check_uniqid checks whether a form is submitted by the same website
 * @access public
 * @param string $_first_uniqid
 * @param string $_end_uniqid
 * @return string $_first_uniqid- the unique identifier
 */
function _check_uniqid($_first_uniqid, $_end_uniqid){
	if(($_first_uniqid != $_end_uniqid)){
		_alert_back('abnormal unique identifier');
	}
	//_alert_back('The first uniqid:'.$_first_uniqid .'\n'. $_end_uniqid);
	return _mysql_string($_first_uniqid);
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
function _check_password($_first_pass, $_end_pass, $_length_pass=6){
	//check the password
	if(strlen($_first_pass)<$_length_pass){
		_alert_back('Password must be longer than '.$_length_pass.' digits');
	}
	
	//match passwords.
	if($_first_pass != $_end_pass){
		_alert_back('Password Not Match');
	}
	return _mysql_string(sha1($_first_pass));
}

/**
 * check whether the updated password is satisfied requirements
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @return string
 */
function _check_modify_password($_string, $_min_num=6){
	//for password update
	if(!empty($_string)){
		if(strlen($_string)<$_min_num){
		_alert_back('Password must be longer than '.$_min_num.' digits');
		}
	}else{
		return null;
	}
	return sha1($_string);
}

/**
 * 
 * _check_question returns a password hint
 * @access public
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return string $_string as password hint
 */
function _check_question($_string,$_min_num=4, $_max_num=20){
	$_string = trim($_string);
	if(strlen($_string)<$_min_num ||strlen($_string)>$_max_num){
		_alert_back('The length of the password question must be between '.$_min_num.'-'.$_max_num.' characters');
	}
	
	//restrict sensitive characters
	$_char_pattern = '/[<>\'\"]/';
	if(preg_match($_char_pattern, $_string)){
		_alert_back('Password question cannot contain special characters');
	}
	return _mysql_string($_string);
}

/**
 * 
 * _check_sex() escapes
 * @access public
 * @param string $_string
 * @return string $_string
 */
function _check_sex($_string){
	return _mysql_string($_string);	
}

/**
 * 
 * _check_profile escapes
 * @access public
 * @param string $_string
 * @return string
 */
function _check_profile($_string){
	return _mysql_string($_string);
}

/**
 * 
 * _check_answer returns a password hint answer
 * @access public
 * @param string $_ques
 * @param string $_answ
 * @param int $_min_num
 * @param int $_max_num
 */
function _check_answer($_ques, $_answ, $_min_num=4, $_max_num=20){
	$_answ = trim($_answ);
	if(strlen($_answ)<$_min_num ||strlen($_answ)>$_max_num){
		_alert_back('The length of the password answer must be between '.$_min_num.'-'.$_max_num.' characters');
	}
	
	//password question can't be the same to the password answer
	if($_ques == $_answ){
		_alert_back('password question cannot be the same to the password answer');
	}
	return _mysql_string(sha1($_answ));
}

/**
 * 
 * _check_email is used for checking whether the email address is legal
 * @access public 
 * @param string $_string
 * @return string $_string format confirmed email address
 */
function _check_email($_string,$_min_num=6, $_max_num = 40){
	$_char_pattern = '/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/';
	if(!(preg_match( $_char_pattern , $_string ))){
		_alert_back('Wrong email address');
	}
	if (strlen($_string)<$_min_num || strlen($_string)>$_max_num){
		_alert_back('The length of email address is between 6 - 40 digits');
	}
	return _mysql_string($_string);
}

/**
 * 
 * _check_msn is used for checking whether the msn account is legal
 * @access public 
 * @param string $_string
 * @return string $_string format confirmed msn account
 */
function _check_msn($_string,$_min_num=6,$_max_num=40){
if(empty($_string)){
		return NULL;
	} else{
		$_char_pattern = '/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/';
		if(!(preg_match( $_char_pattern , $_string ))){
			_alert_back('Wrong msn address');
		}
	if (strlen($_string)<$_min_num || strlen($_string)>$_max_num){
		_alert_back('The length of msn account is between 6 - 40 digits');
	}
		return _mysql_string($_string);
	}
}

/**
 * 
 * _check_url checks an URL format
 * @access public
 * @param string $_string
 * @return string $_string checked URL
 */
function _check_url($_string, $_max_num =40){
	if(empty($_string)||($_string == 'http://')){
		return NULL;
	} else{
		$_char_pattern ='/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/';
		if(!preg_match($_char_pattern, $_string)){
			_alert_back('Wrong URL format');
		}
		if(strlen($_string)>$_max_num){
			_alert_back('The site is too long');
		}
	}
	return  _mysql_string($_string);
}

/**
 * check the lenght of a message- _check_content()
 * @access public
 * @param string $_string
 * @return string
 */
function _check_content($_string){
	if(strlen($_string)<10 ||strlen($_string)>800){
		_alert_back('The length of a message must be between 10 to 800 characters');
	}
	return $_string;
}

/**
 * measure the length of the title of a post-_check_post_title()
 * @access public
 * @param string $_string
 * @param int $_min
 * @param int $_max
 * @return sting
 */
function _check_post_title($_string,$_min=2,$_max=10){
	$_length = str_word_count($_string);
	if($_length<$_min ||$_length>$_max){
		_alert_back('The length of the title of a post must be between '.$_min.' to '.$_max.' words');
	}
	return $_string;
}

/**
 * measure the length of the content in a post-_check_post_content
 * @access public
 * @param string $_string
 * @param int $_num
 * @return string
 */
function _check_post_content($_string,$_num=10){
	$_length = str_word_count($_string);
	if($_length<$_num){
		_alert_back('The length of the content of a post must be bigger than '.$_num.' words');
	}
	return $_string;
}

/**
 * check the length of a autograph-_check_autograph()
 * @access public
 * @param string $_string
 * @param int $_num
 * @return string
 */
function _check_autograph($_string,$_num=40){
	$_length = str_word_count($_string);
	if($_length>=$_num){
		_alert_back('The length of the autograph must be less than '.$_num.' words');
	}
	return $_string;
}

/**
 * check the length of a directory-_check_dir_name()
 * @access public
 * @param string $_string
 * @param int $_min
 * @param int $_max
 * @return string
 */
function _check_dir_name($_string,$_min=2,$_max=20) {
	$_length = strlen($_string);
	if ($_length < $_min || $_length > $_max ) {
		_alert_back('The length of the name is between'.$_min.'-'.$_max.'characters');
	}
	return $_string;
}

/**
 * check the length of a password-_check_dir_password()
 * @access public
 * @param string $_string
 * @param int $_num
 * @return string
 */
function _check_dir_password($_string,$_num=6) {
	if (strlen($_string) < $_num) {
		_alert_back('The length of a password is bigger than'.$_num.'digits');
	}
	return sha1($_string);
}

/**
 * check whether url exists-_check_photo_url()
 * @access public
 * @param string $_string
 * @return string
 */
function _check_photo_url($_string){
	if(empty($_string)){
		_alert_back('URL could not be empty');
	}
	return $_string;
}
?>