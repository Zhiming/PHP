<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","photo_add_img");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//member access
if(!isset($_COOKIE['username'])){
	_alert_back('Illegal access');
}


if (isset($_GET['action'])&&$_GET['action'] == 'addimg') {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT  1"
	)) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		include 'includes/check.func.php';
		//receive data
		$_clean = array();
		$_clean['name'] = _check_dir_name($_POST['name']);
		$_clean['url'] = _check_photo_url($_POST['url']);
		$_clean['content'] = $_POST['content'];
		$_clean['sid'] = $_POST['sid'];
		$_clean = _mysql_string($_clean);
		//write into database
		_query("INSERT INTO tg_photo (
																	tg_name,
																	tg_url,
																	tg_content,
																	tg_sid,
																	tg_username,
																	tg_date
															) 
											VALUES (	
																	'{$_clean['name']}',
																	'{$_clean['url']}',
																	'{$_clean['content']}',
																	'{$_clean['sid']}',
																	'{$_COOKIE['username']}',
																	NOW()
															)"
		);
		if (_affected_rows() == 1) {
			_close();
			_location('Successfully uploaded','photo_show.php?id='.$_clean['sid']);
		} else {
			_close();
			_alert_back('Fail to upload');
		}
	} else {
		_alert_back('Illegal access');
	}
}

//receive id
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_dir
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['dir'] = $_rows['tg_dir'];
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
<script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>Upload pictures</h2>
	<form method="post" action="?action=addimg">
	<input type="hidden" name="sid" value="<?php echo $_html['id']?>" />
		<dl>
			<dd>Picture name:<input type="text" name="name" class="text" /></dd>
			<dd>Picture path:<input type="text" name="url" id="url" readonly="readonly"class="text" /><a href="javascript:;" title="<?php echo $_html['dir'];?>"id="up">Upload</a></dd>
			<dd>Description:<?php echo '&nbsp&nbsp'?><textarea name="content"></textarea></dd>
			<dd><input type="submit" class="submit" value="Upload" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>