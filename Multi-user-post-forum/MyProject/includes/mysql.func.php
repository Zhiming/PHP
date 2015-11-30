<?php

//Protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//connect to database
/**
 * 
 * _connect() connects to MySQL database
 * @access public
 * @return void
 */
function _connnect(){
	//create a connection to database
	global $_conn;
	if(!$_conn = mysql_connect(DB_HOST,DB_USER,DB_PWD)){
		exit('fail to connect to database'.mysql_error());
	}
}

/**
 * 
 * _select_db selects a database
 * @access public
 * @return void
 */
function _select_db(){
	//select a  database
	if(!mysql_select_db(DB_NAME)){
		exit('wrong database name'.mysql_error());
	}
}

/**
 * 
 * _set_names()set character set
 * @access public
 * @return void
 */
function _set_names(){
	//set character set
	if(!mysql_query('SET NAMES UTF8')){
		exit('wrong character set'.mysql_error());
	}
}

/**
 * 
 * _query() executes a SQL statement
 * @param string $_sql
 * @access public
 * @return SQL resource handle
 */
function _query($_sql){
	if(!$_result = mysql_query($_sql)){
		exit('fail to execute SQL statement '.mysql_error());
	}
	return $_result;
}

/**
 * _insert() inserts data into the database
 * @access public
 * @param string $_sql
 * @return void
 */
function _insert($_sql){
	_query($_sql);
}

/**
 * 
 * _fetch_array() receives a SQL statement and return only one record in the database
 * @access public
 * @param string $_sql
 * @return array
 */
function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

/**
 * return the number of records in database
 * @access public
 * @param SQL resource handle $_result
 * @return int
 */
function _num_rows($_result){
	return mysql_num_rows($_result);
}

/**
 * Receive a SQL resource handle and return an array in that handle_fetch_array_list()
 * @access public
 * @param SQL resource handle $_result
 * @return array
 */
function _fetch_array_list($_result){
	return mysql_fetch_array($_result, MYSQL_ASSOC);
}

/**
 * 
 * _affect_rows() returns the number of affected records
 * @access public
 * return int
 */
function _affected_rows(){
	return mysql_affected_rows();
}

/**
 * free the memory stored in a SQL resource handle
 * @access public
 * @param SQL resource handle $_result
 * @return void
 */
function _free_result($_result){
	mysql_free_result($_result);
}

/**
 * get the id number in the previous "insert" statement-_insert_id()
 * @access public
 * @return int
 */
function _insert_id(){
	return mysql_insert_id();
}

/**
 * 
 * _is_repeat() checks whether a username has been registered
 * @access public
 * @param string $_sql
 * @param string $_info
 * @return void
 */
function _is_repeat($_sql,$_info){
	if(_fetch_array($_sql)){
		_alert_back($_info);
	}
}

function _close(){
	if(!mysql_close()){
		exit('fail to close database'.mysql_error());
	}
}

?>