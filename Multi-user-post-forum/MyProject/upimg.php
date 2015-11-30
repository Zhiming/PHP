<?php

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","upimg");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

if (!$_COOKIE['username']) {
	_alert_back('Illegal access');
}
//upload pictures
if (isset($_GET['action'])&&$_GET['action'] == 'up') {
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
		//picture format could be accepted
		$_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
		
		//check the format of a uploaded picture
		if (is_array($_files)) {
			if (!isset($_FILES['userfile'])||(!in_array($_FILES['userfile']['type'],$_files))) {
				_alert_back('The format must be jpg, png or gif');
			}
		}
		
		//check error type
		if ($_FILES['userfile']['error'] > 0) {
			switch ($_FILES['userfile']['error']) {
				case 1: _alert_back('The picture is bigger than the first restriction');
					break;
				case 2: _alert_back('The picture is bigger than the second restriction');
					break;
				case 3: _alert_back('part of picture is uploaded');
					break;
				case 4: _alert_back('No picture is uploaded');
					break;
			}
			exit;
		}
		
		//picture size
		if ($_FILES['userfile']['size'] > 1000000) {
			_alert_back('The picture must less than 1M');
		}
		
		//obtain the extention name of a picture
		$_n = explode('.',$_FILES['userfile']['name']);
		$_name = $_POST['dir'].'/'.time().'.'.$_n[1];
		
		//move picture
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			if	(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)) {
				_alert_back('Fail to move');
			} else {
				//_alert_close('Successfully upload');
				echo "<script>alert('Successfully uploaded');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
				exit();
			}
		} else {
			_alert_back('The temp file does not exist');
		}
		
	} else {
		_alert_back('Illegal access');
	}
}

//receive dir
if (!isset($_GET['dir'])) {
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
</head>
<body>
<div id="upimg"style="padding:1px;">
	<form enctype="multipart/form-data"action="upimg.php?action=up"method="post">
	<input type="hidden"name="MAX_FILE_SIZE"value="1000000"/>
	<input type="hidden" name="dir" value="<?php echo $_GET['dir'];?>" />
	Choose a picture:<input type="file"name="userfile"/>
	<input type="submit"value="Upload"/>
	</form>
</div>
</body>
</html>