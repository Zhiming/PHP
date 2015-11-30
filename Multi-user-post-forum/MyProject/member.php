<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//check login status
if(isset($_COOKIE['username'])){
	//Get data from database
	$_rows = _fetch_array("SELECT 
								tg_username,tg_sex,tg_profile,tg_email,tg_url,tg_msn,tg_level,tg_reg_time 
							FROM 
								tg_user 
							WHERE 
								tg_username='{$_COOKIE['username']}'"
						 );
	//check whether this username exists
	if($_rows){
		$_html = array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_profile'];
		$_html['email'] = $_rows['tg_email'];
		$_html['url'] = $_rows['tg_url'];
		$_html['msn'] = $_rows['tg_msn'];
		$_html['reg_time'] = $_rows['tg_reg_time'];
		switch ($_rows['tg_level']){
			case 0:
				$_html['level'] = 'Regular member';
				break;
			case 1:
				$_html['level'] = 'Administrator';
				break;
			default:
				$_html['level'] = 'error';	
		}
		$_html = _html($_html);
	}else{
		_alert_back('This username does not exist');
	}
}else{
	_alert_back('illegal access');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
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
		<h2>Management</h2>
		<dl>
			<dd>Username: <?php echo $_html['username'];?></dd>
			<dd>Gender: <?php echo $_html['sex'];?></dd>
			<dd>Figure: <?php echo $_html['face'];?><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dd>
			<dd>Email: <?php echo $_html['email'];?></dd>
			<dd>Personal Page: <?php echo $_html['url'];?></dd>
			<dd>MSN: <?php echo $_html['msn'];?></dd>
			<dd>Registration Date: <?php echo $_html['reg_time'];?></dd>
			<dd>Identity: <?php echo $_html['level'];?></dd>
		</dl>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
