<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","login");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//flag login state
_login_state();

//Processing login
if(isset($_GET['action'])){
	if($_GET['action'] == 'login'){
		//protect from illegal registration		
		_check_code($_POST['code'], $_SESSION['RandCode']);
		//include register.func.php
		include ROOT_PATH.'includes/login.func.php';
		//receive data from form
		$_clean = array();
		$_clean['username'] = _check_username($_POST['username']);
		$_clean['password'] = _check_password($_POST['password']);
		$_clean['time'] = _check_time($_POST['time']);
		
		//validate data in database
		if (!!$_rows = _fetch_array("SELECT 
		                                                        tg_username,tg_uniqid,tg_level 
		                                                 FROM 
		                                                        tg_user 
		                                              WHERE 
		                                                        tg_username='{$_clean['username']}' 
		                                                   and 
		                                                        tg_password='{$_clean['password']}' 
		                                                   and 
		                                                        tg_active='' LIMIT 1")) {
			//登录成功后，记录登录信息
			_query("UPDATE tg_user SET 
															tg_last_time=NOW(),
															tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',
															tg_login_count=tg_login_count+1
												WHERE 
															tg_username='{$_rows['tg_username']}'				
													");
			//_session_destroy();
			//store cookies into client to raise security
			_setcookies($_rows['tg_username'], $_rows['tg_uniqid'], $_clean['time']);
		     if ($_rows['tg_level'] == 1) {
				$_SESSION['admin'] = $_rows['tg_username'];
			}
			_close();
			_location(null,'member.php');
		} else {
			_close();
			//_session_destroy();
			_location('wrong username or password or the account is not activated','login.php');
		}
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
<script type="text/javascript"src = "js/code.js"></script>
<script type="text/javascript"src = "js/login.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="login">
	<h2>Login</h2>
	<form method="post" name = "login" action="login.php?action=login">
		<dl>
			<dt>  </dt>
			<dd>Username:   <input type="text" name="username" class="text" /></dd>
			<dd>Password:   <input type="password" name="password" class="text" /></dd>
			<dd class="format">Auto login: <input type="radio" name="time" value="0" checked="checked" /> Not auto login <input type="radio" name="time" value="1" /> One day <input type="radio" name="time" value="2" /> One week <input type="radio" name="time" value="3" />One month</dd>
			<dd>Identifing code: <input type="text" name="code" class="text code"  /><img src = "Randomcode.php" id="RandCode"/></dd>
			<dd><input type="submit" value="Login" class="button" /><a href="register.php"><input type="button" value="Register" id="location" class="button location" /></a> </dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>