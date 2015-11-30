<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","flower");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//login first then send message
//whether login
if(!isset($_COOKIE['username'])){
	_alert_close('Please login first');
}

//write message
if(isset($_GET['action'])){
	if($_GET['action']=='send'){
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
			include ROOT_PATH.'includes/check.func.php';
			$_clean = array();
			$_clean['touser']=$_POST['touser'];
			$_clean['fromuser']=$_COOKIE['username'];
			$_clean['flower'] = $_POST['flower'];
			$_clean['content']=_check_content($_POST['content']);
			$_clean = _mysql_string($_clean);
			
			//write into database
			_insert("INSERT INTO tg_flower (
										tg_touser,
								        tg_fromuser,
								        tg_flower,
										tg_content,
										tg_date
										)
								    	VALUES (
					 					'{$_clean['touser']}',
					 					'{$_clean['fromuser']}',
					 					'{$_clean['flower']}',
					 					'{$_clean['content']}',
					 					NOW()
						 				)
			");
			//Successfully sended
			if (_affected_rows() == 1) {
				_close();
				//_session_destroy();
				_alert_close('Successfully sended');
			} else {
				_close();
				//_session_destroy();
				_alert_back('Fail to send');
			}
		}else{
			_alert_close('Illegal access!');
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
		_alert_close('This user does not exist£¡');
	}
} else {
	_alert_close('Illegal access£¡');
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
	<h3>Send Flower</h3>
	<form method="post" action="?action=send">
	<input type="hidden"name="touser"value="<?php echo $_html['touser'];?>"/>
	<dl>
		<dd>
			<input type="text" readonly="readonly" value="TO:<?php echo $_html['touser']?>" class="text" />
			<select name="flower">
				<?php 
					foreach (range(1,100) as $_num) {
						echo '<option value="'.$_num.'"> x'.$_num.' flowers</option>';
					}
				?>
			</select>
		</dd>
		<dd><textarea name="content">I am very appreciated to you, sending you flowers(^^)</textarea></dd>
		<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
		<dd><input type="submit" class="submit" value="Send Flowers" /></dd>
	</dl>
	</form>
</div>
</body>
</html>