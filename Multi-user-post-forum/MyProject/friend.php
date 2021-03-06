<?php

if(!isset($_SESSION)){
	session_start();
}

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","friend");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//login first then send message
//whether login
if(!isset($_COOKIE['username'])){
	_alert_close('Please login first');
}

if(isset($_GET['action'])){
	if($_GET['action']=='add'){
		//protect from illegal registration		
		_check_code($_POST['code'], $_SESSION['RandCode']);
		$_rows = _fetch_array("select 
									tg_uniqid 
								 from 
									tg_user 
								where 
									tg_username = '{$_COOKIE['username']}'"
		                          );
		if($_rows){ 		
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		}
	include ROOT_PATH.'includes/check.func.php';
	$_clean = array();
	$_clean['touser']=$_POST['touser'];
	$_clean['fromuser']=$_COOKIE['username'];
	$_clean['content']=_check_content($_POST['content']);
	$_clean = _mysql_string($_clean);
	//can't add self
	if ($_clean['touser'] == $_clean['fromuser']) {
		_alert_close('Can not send request to yourself��');
	}
	//validate whether request has been sended
	if (!!$_rows = _fetch_array("SELECT 
									   tg_id 
								   FROM 
									   tg_friend
								  WHERE
									   (tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}')
									 OR
									   (tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}')
								  LIMIT 1
	      						")) {
		_alert_close('You are friends or the request has been sended by either of you, plese check your friend request list');
	} else {
		//send request
			_query("INSERT INTO 
		                   tg_friend (
									tg_touser,
									tg_fromuser,
									tg_content,
									tg_date
									 )
							 VALUES (
				 					'{$_clean['touser']}',
				 					'{$_clean['fromuser']}',
				 					'{$_clean['content']}',
				 					NOW()
							 		)
		      ");
			if (_affected_rows() == 1) {
				_close();
				//_session_destroy();
				_alert_close('Successfully send request');
			} else {
				_close();
				//_session_destroy();
				_alert_back('Fail to send request');
					}
			}
	}
}
//Get data from database
//$_GET['id'] is from centerwindow() in blog.js
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
	                                  tg_username 
	                               FROM 
	                                  tg_user 
	                              WHERE 
	                                  tg_id='{$_GET['id']}' 
	                              LIMIT 1")
	   ){
		$_html = array();
		$_html['touser'] = $_rows['tg_username'];
		$_html = _html($_html);
	} else {
		_alert_close('This user does not exist��');
	}
} else {
	_alert_close('Illegal access��');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
<script type="text/javascript"src="js/code.js"></script>
<script type="text/javascript"src="js/message.js"></script>
</head>
<body>
<div id="message">
	<h3>Friend Request</h3>
	<form method="post" action="?action=add">
	<input type="hidden"name="touser"value="<?php echo $_html['touser'];?>"/>
	<dl>
		<dd><input type="text"readonly="readonly"value="TO:<?php echo $_html['touser'];?>"class="text"/></dd>
		<dd><textarea name="content">I would love to be your friend...</textarea></dd>
		<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
		<dd><input type="submit" class="submit" value="Send Request" /></dd>
	</dl>
	</form>
</div>
</body>
</html>