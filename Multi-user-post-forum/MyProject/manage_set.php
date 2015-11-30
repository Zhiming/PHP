<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","manage_set");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//protect from illegal accessing management
_manage_login();

//set system
if(isset($_GET['action'])&&$_GET['action'] == 'set'){
	if (!!$_rows = _fetch_array("SELECT 
															 tg_uniqid 
												    FROM 
															 tg_user 
											     WHERE 
															 tg_username='{$_COOKIE['username']}' 
												   LIMIT 1"
	)) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		
		$_clean = array();
		$_clean['webname'] = $_POST['webname'];
		$_clean['article'] = $_POST['article'];
		$_clean['blog'] = $_POST['blog'];
		$_clean['photo'] = $_POST['photo'];
		$_clean['skin'] = $_POST['skin'];
		$_clean['post'] = $_POST['post'];
		$_clean['re'] = $_POST['re'];
		$_clean = _mysql_string($_clean);
		
		//write into database
		_query("UPDATE tg_system SET 
															tg_webname='{$_clean['webname']}',
															tg_article='{$_clean['article']}',
															tg_blog='{$_clean['blog']}',
															tg_photo='{$_clean['photo']}',
															tg_skin='{$_clean['skin']}',
															tg_post='{$_clean['post']}',
															tg_re='{$_clean['re']}'
												WHERE
															tg_id=1
												  LIMIT 1
		");
		if (_affected_rows() == 1) {
			_close();
			//_session_destroy();
			_location('Successfully set','manage_set.php');
		} else {
			_close();
			//_session_destroy();
			_location('Fail to set','manage_set.php');
		}
	} else{
		_alert_back('Abnormal access');
	}
}

//read system table
if (!!$_rows = _fetch_array("SELECT 
															tg_webname,
															tg_article,
															tg_blog,
															tg_photo,
															tg_skin,
															tg_post,
															tg_re
												FROM 
															tg_system 
											 WHERE 
															tg_id=1 
												 LIMIT 
															1")){
	$_html = array();
	$_html['webname'] = $_rows['tg_webname'];
	$_html['article'] = $_rows['tg_article'];
	$_html['blog'] = $_rows['tg_blog'];
	$_html['photo'] = $_rows['tg_photo'];
	$_html['skin'] = $_rows['tg_skin'];
	$_html['post'] = $_rows['tg_post'];
	$_html['re'] = $_rows['tg_re'];
	$_html = _html($_html);
	
	//article in index
	if($_html['article'] == 8){
		$_html['article_html'] = '<select name="article"><option value="8" selected="selected">8 posts each page</option><option value="10">10 posts each page</option></select>';
	} elseif($_html['article'] == 10){
		$_html['article_html'] = '<select name="article"><option value="8">8 posts each page</option><option value="10" selected="selected">10 posts each page</option></select>';
	}
	
	//blogs
	if ($_html['blog'] == 15) {
		$_html['blog_html'] = '<select name="blog"><option value="15" selected="selected">15 people each page</option><option value="20">20 people each page</option></select>';
	} elseif ($_html['blog'] == 20) {
		$_html['blog_html'] = '<select name="blog"><option value="15">15 people each page</option><option value="20" selected="selected">20 people each page</option></select>';
	}
	
	//albums
	if ($_html['photo'] == 8) {
		$_html['photo_html'] = '<select name="photo"><option value="8" selected="selected">8 photos each page</option><option value="12">12 photos each page</option></select>';
	} elseif ($_html['photo'] == 12) {
		$_html['photo_html'] = '<select name="photo"><option value="8">8 photos each page</option><option value="12" selected="selected">12 photos each page</option></select>';
	}
	
	//skin
	if ($_html['skin'] == 1) {
		$_html['skin_html'] = '<select name="skin"><option value="1" selected="selected">No.1 Skin</option><option value="2">No.2 Skin</option><option value="3">No.3 Skin</option></select>';
	} elseif ($_html['skin'] == 2) {
		$_html['skin_html'] = '<select name="skin"><option value="1">No.1 Skin</option><option value="2" selected="selected">No.2 Skin</option><option value="3">No.3 Skin</option></select>';
	} elseif ($_html['skin'] == 3) {
		$_html['skin_html'] = '<select name="skin"><option value="1">No.1 Skin</option><option value="2">No.2 Skin</option><option value="3" selected="selected">No.3 Skin</option></select>';
	}
	
	//post time interval
	if ($_html['post'] == 30) {
		$_html['post_html'] = '<input type="radio" name="post" value="30" checked="checked" />30 seconds <input type="radio" name="post" value="60" />1 minute <input type="radio" name="post" value="180" />3 minutes';
	} elseif ($_html['post'] == 60) {
		$_html['post_html'] = '<input type="radio" name="post" value="30" />30 seconds <input type="radio" name="post" value="60" checked="checked" />1 minute <input type="radio" name="post" value="180" />3 minutes';
	} elseif ($_html['post'] == 180) {
		$_html['post_html'] = '<input type="radio" name="post" value="30" />30 seconds <input type="radio" name="post" value="60" />1 minute <input type="radio" name="post" value="180" checked="checked" />3 minutes';
	}
	
	//reply time interval
	if ($_html['re'] == 15) {
		$_html['re_html'] = '<input type="radio" name="re" value="15" checked="checked" />15 seconds <input type="radio" name="re" value="30" />30 seconds <input type="radio" name="re" value="45" />45 seconds';
	} elseif ($_html['re'] == 30) {
		$_html['re_html'] = '<input type="radio" name="re" value="15" />15 seconds <input type="radio" name="re" value="30" checked="checked" />30 seconds <input type="radio" name="re" value="45" />45 seconds';
	} elseif ($_html['re'] == 45) {
		$_html['re_html'] = '<input type="radio" name="re" value="15" />15 seconds <input type="radio" name="re" value="30" />15 seconds <input type="radio" name="re" value="45" checked="checked" />45 seconds';
	}
	
} else{
	_alert_back('Fail to read in system table, please check');
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
	require ROOT_PATH.'includes/manage.inc.php';
?>
	<div id="member_main">
		<h2>Management</h2>
			<form method="post" action="?action=set">
		<dl>
			<dd>Website name: <input type="text"name="webname"class="text"value="<?php echo $_html['webname']; ?>"/></dd>
			<dd>number of articles on each page: <?php echo $_html['article_html'];?></dd>
			<dd>number of blogs on each page: <?php echo $_html['blog_html'];?></dd>
			<dd>number of albumns on each page: <?php echo $_html['photo_html'];?></dd>
			<dd>default skin: <?php echo $_html['skin_html'];?></dd>
			<dd>Post time interval: <?php echo $_html['post_html'];?></dd>
			<dd>Reply time interval: <?php echo $_html['re_html'];?></dd>
			<dd><input type="submit"value="Apply"class="submit"/></dd>
		</dl>
		</form>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
