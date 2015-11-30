<?php

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","article_modify");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

if(isset($_SERVER["HTTP_REFERER"])){
	$_skinurl = $_SERVER["HTTP_REFERER"];
	if(empty($_skinurl) || !isset($_GET['id'])){
		_alert_back('Illegal access');
	} else{
		//validate id
		if($_GET['id'] != 1 && $_GET['id'] != 2 && $_GET['id'] != 3){
			_alert_back('Invalid ID');
		}
		//create a cookie to save the skin id
		setcookie('skin',$_GET['id']);
		_location(null,$_skinurl);
	}
}


?>