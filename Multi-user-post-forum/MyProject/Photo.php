<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","photo");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//delete directory
if (isset($_GET['action']) && ($_GET['action'] == 'delete') && isset($_GET['id'])) {
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
		//deleting the directory
		if (!!$_rows = _fetch_array("SELECT 
																		tg_dir
															FROM 
																		tg_dir 
														 WHERE 
																		tg_id='{$_GET['id']}' 
															 LIMIT 
																		1"
		)) {
			$_html = array();
			$_html['url'] = $_rows['tg_dir'];
			$_html = _html($_html);
			//deleting the directory physically
			if (file_exists($_html['url'])) {
				if (_remove_Dir($_html['url'])) {
					//deleting the pictures in database
					_query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
					//deleting the directory in database
					_query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
					_close();
					_location('Successfully deleted','photo.php');
				} else {
					_close();
					_alert_back('Fail to delete');
				}
			}
		}  else {
			_alert_back('This directory does not exist');
		}
	} else {
		_alert_back('Illegal access');
	}
}

//read data
global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_dir",$_system['photo']);
$_result = _query("SELECT 
												tg_id,tg_name,tg_type,tg_face
									FROM 
												tg_dir 
							ORDER BY 
												tg_date DESC 
									 LIMIT 
												$_pagenum,$_pagesize
							");	
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

<div id="photo">
	<h2>Albums List</h2>
	<?php 
		$_html = array();
		while (!!$_rows = _fetch_array_list($_result)) {
			$_html['id'] = $_rows['tg_id'];
			$_html['name'] = $_rows['tg_name'];
			$_html['type'] = $_rows['tg_type'];
			$_html['face'] = $_rows['tg_face'];
			$_html = _html($_html);
			if (empty($_html['type'])) {
				$_html['type_html'] = '(Public)';
			} else {
				$_html['type_html'] = '(Private)';
			}
		if (empty($_html['face'])) {
				$_html['face_html'] = '';
			} else {
				$_html['face_html'] = '<img src="'.$_html['face'].'" alt="'.$_html['name'].'"/>';
			}
			
			//total amount of pictures in an album
			$_html['photo'] = _fetch_array("SELECT COUNT(*) 
			                                                                           AS 
			                                                                                count 
	                                                                           FROM 
			                                                                                tg_photo 
                                                                             WHERE 
			                                                                                tg_sid={$_html['id']}");
	?>
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['face_html'];?></a></dt>
		<dd><a href="photo_show.php?id=<?php echo $_html['id']?>"><?php echo $_html['name']?> <?php echo'['.$_html['photo']['count'].']'. $_html['type_html'] ?></a></dd>
		<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
		<dd>[<a href="photo.php?action=delete&id=<?php echo $_html['id']?>">Del</a>] [<a href="photo_modify_dir.php?id=<?php echo $_html['id'];?>">Modify</a>]</dd>
		<?php } ?>
	</dl>
	<?php } ?>
	<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
		<p><a href="photo_add_dir.php">Add directory</a></p>
	<?php } ?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>