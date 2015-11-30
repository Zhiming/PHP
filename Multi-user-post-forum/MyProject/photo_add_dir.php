<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","photo_add_dir");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//only administrators access
_manage_login();
//Add directory
if (isset($_GET['action'])&&$_GET['action'] == 'adddir') {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
	)) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include 'includes/check.func.php';
		//receive data from form
		$_clean = array();
		$_clean['name'] = _check_dir_name($_POST['name']);
		$_clean['type'] = $_POST['type'];
		if(!empty($_clean['type'])){
			$_clean['password'] = _check_dir_password(($_POST['password']));
		}
		$_clean['content'] = $_POST['content'];
		$_clean['dir'] = time();
		$_clean = _mysql_string($_clean);
		//Check whether the directory-photo exists
		if (!is_dir('photo')) {
			//if not, create a directory named photo
			mkdir('photo',0777);
		}
		//Create another directory with current time under the photo directory
		if (!is_dir('photo/'.$_clean['dir'])) {
			mkdir('photo/'.$_clean['dir']);
		}
		//write the current directory into database
		if (empty($_clean['type'])) {
			_query("INSERT INTO tg_dir (
																tg_name,
																tg_type,
																tg_content,
																tg_dir,
																tg_date
															)
											 VALUES (
																'{$_clean['name']}',
																'{$_clean['type']}',
																'{$_clean['content']}',
																'photo/{$_clean['dir']}',
																NOW()
											 				)
			");
		} else {
			_query("INSERT INTO tg_dir (
																tg_name,
																tg_type,
																tg_content,
																tg_dir,
																tg_date,
																tg_password
															)
											 VALUES (
																'{$_clean['name']}',
																'{$_clean['type']}',
																'{$_clean['content']}',
																'photo/{$_clean['dir']}',
																NOW(),
																'{$_clean['password']}'
											 				)
			");
		}
		//目录添加成功
		if (_affected_rows() == 1) {
			_close();
			_location('Successfully add a directory','photo.php');
		} else {
			_close();
			_alert_back('Fail to add');
		}
	} else{
		_alert_back('Illegal access');
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
<script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>Add albums directory</h2>
	<form method="post" action="?action=adddir">
		<dl>
			<dd>Album name: <input type="text" name="name" class="text" /></dd>
			<dd>Album type: <input type="radio" name="type" value="0" checked="checked" /> public <input type="radio" name="type" value="1" /> Private </dd>
			<dd id="pass">Password:<?php echo "&nbsp&nbsp&nbsp";?><input type="password" name="password" class="text" /></dd>
			<dd>Description: <textarea name="content"></textarea></dd>
			<dd><input type="submit" class="submit" value="Add directory" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>