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

//modify
if (isset($_GET['action'])&&$_GET['action'] == 'modify') {
	if (!!$_rows = _fetch_array("SELECT 
															tg_uniqid,
															tg_article_time 
												    FROM 
															tg_user 
											     WHERE 
															tg_username='{$_COOKIE['username']}' 
												 LIMIT  1"
	)) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		//receive data
		include 'includes/check.func.php';
		$_clean = array();
		$_clean['id'] = $_POST['id'];
		$_clean['name'] = _check_dir_name($_POST['name'],2,20);
		$_clean['type'] = $_POST['type'];
		if (!empty($_clean['type'])) {
			$_clean['password'] = _check_dir_password($_POST['password'],6);
		}
		$_clean['face'] = $_POST['face'];
		$_clean['content'] = $_POST['content'];
		$_clean = _mysql_string($_clean);
		//modify directory
		if (empty($_clean['type'])) {
			_query("UPDATE 
										tg_dir 
							    SET 
										tg_name='{$_clean['name']}',
										tg_type='{$_clean['type']}',
										tg_password=NULL,
										tg_face='{$_clean['face']}',
										tg_content='{$_clean['content']}'
						  WHERE
										tg_id='{$_clean['id']}'
							LIMIT   1
	                ");
		} else {
			_query("UPDATE 
												tg_dir 
									SET 
												tg_name='{$_clean['name']}',
												tg_type='{$_clean['type']}',
												tg_password='{$_clean['password']}',
												tg_face='{$_clean['face']}',
												tg_content='{$_clean['content']}'
								WHERE
												tg_id='{$_clean['id']}'
									LIMIT 
												1
			");
		}
		if (_affected_rows() == 1) {
			_close();
			_location('Successfully modified','photo.php');
		} else {
			_close();
			_alert_back('Fail to modify');
		}
	} else {
		_alert_back('Fail to modify');
	}
}

//read data from database
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																tg_id,
																tg_name,
																tg_type,
																tg_face,
																tg_content 
													FROM 
																tg_dir 
												  WHERE 
																tg_id='{$_GET['id']}'
													LIMIT   1
	")) {
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['name'] = $_rows['tg_name'];
		$_html['type'] = $_rows['tg_type'];
		$_html['face'] = $_rows['tg_face'];
		$_html['content'] = $_rows['tg_content'];
		$_html = _html($_html);
	} else {
		_alert_back('This album does not exist');
	}
} else {
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
<script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>Modify albums directory</h2>
	<form method="post" action="?action=modify">
		<dl>
			<dd>Album name: <input type="text" name="name" class="text"value="<?php echo $_html['name'];?>" /></dd>
			<dd>Album type:<?php echo '&nbsp&nbsp';?><input type="radio" name="type" value="0" <?php if ($_html['type'] == 0) echo 'checked="checked"'?> /> Public <input type="radio" name="type" value="1" <?php if ($_html['type'] == 1) echo 'checked="checked"'?> /> Private</dd>
			<dd id="pass" <?php if ($_html['type'] == 1) echo 'style="display:block;"'?>>Password:<?php echo '&nbsp&nbsp&nbsp;'?><input type="password" name="password" class="text" /></dd>
			<dd>Album cover:<input type="text" name="face" value="<?php echo $_html['face']?>" class="text" />(URL)</dd>
			<dd>Description: <textarea name="content"><?php echo $_html['content'];?></textarea></dd>
			<dd><input type="submit" class="submit" value="Modify directory" /></dd>
		</dl>
		<input type="hidden" value="<?php echo $_html['id']?>" name="id" />
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>