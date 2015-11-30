<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member_message_detail");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//whether login
if(!isset($_COOKIE['username'])){
	_alert_back('Please login first');
}

//deleting message module
//$_GET['action'] from "location.href = '?action=delete';" in member_message_detail.js
if(isset($_GET['action'])&& isset($_GET['id'])){
	if(($_GET['action']=='delete')){
		$_rows = _fetch_array("SELECT 
								tg_id,tg_fromuser,tg_content,tg_date
							FROM 
								tg_message 
		  				   WHERE 
								tg_id='{$_GET['id']}' 
						   LIMIT 1
						  ");
		//check whether a message exist
		if($_rows){
			//protect from illegal deleting by validating unique identifier
			if (!!$_rows = _fetch_array("SELECT 
												tg_uniqid 
		 								   FROM 
												tg_user 
										  WHERE 
												tg_username='{$_COOKIE['username']}' 
										  LIMIT 1"
			)){
			//Protect from faking unique identifier
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			//delete a single message
			_query("DELETE FROM 
								tg_message 
				   		  WHERE 
								tg_id='{$_GET['id']}' 
						  LIMIT 1
				");
			if (_affected_rows() == 1) {
					_close();
					_session_destroy();
					_location('Message deleted','member_message.php');
				} else {
					_close();
					_session_destroy();
					_alert_back('Fail to delete');
				}
			}else{
				_alert_back('Illegal access');
			}
		}else{
			_alert_back('This message does not exist');
		}
	}
}

if(isset($_GET['id'])){
	$_rows = _fetch_array("SELECT 
								tg_id,tg_state,tg_fromuser,tg_content,tg_date
							FROM 
								tg_message 
		  				   WHERE 
								tg_id='{$_GET['id']}' 
						   LIMIT 1
						  ");
	if($_rows){
		//check whether a message is readed
		if (empty($_rows['tg_state'])) {
			_query("UPDATE 
						tg_message 
					  SET 
						tg_state=1 
					WHERE 
						tg_id='{$_GET['id']}' 
					LIMIT 1
		         ");
			if (!_affected_rows()) {
				_alert_back('Abnormal');
			}
		}
		$_html= array();
		$_html['id'] = $_rows['tg_id'];
		$_html['fromuser'] = $_rows['tg_fromuser'];
		$_html['content'] = $_rows['tg_content'];
		$_html['date'] = $_rows['tg_date'];
		$_html = _html($_html);
	}else{
		_alert_back('This message does not exist!');
	}
}else{
	_alert_back('Illegal access');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
<script type="text/javascript"src="js/member_message_detail.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
<?php 
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>Message Detail</h2>
		<dl>
			<dd>Sender:<?php echo $_html['fromuser'];?></dd>
			<dd>Contents:<strong><?php echo $_html['content'];?></strong></dd>
			<dd>Delivery time:<?php echo $_html['date'];?></dd>
			<dd class="button"><input type="button"id="delete"name="<?php echo $_html['id'];?>"value="Delete"/><input type="button"value="return to list"id="return"/></dd>
		</dl>
		</div>
	</div>
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>