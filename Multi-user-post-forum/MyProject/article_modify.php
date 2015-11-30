<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","article_modify");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

if(!isset($_COOKIE['username'])){
	_location('Please login before post', 'login.php');
}

//modify
if (isset($_GET['action'])&&$_GET['action'] == 'modify') {
	_check_code($_POST['code'], $_SESSION['RandCode']);
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
		
		//begin modifying
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		$_clean['id'] = $_POST['id'];
		$_clean['type'] = $_POST['type'];
		$_clean['title'] = _check_post_title($_POST['title'],2,40);
		$_clean['content'] = _check_post_content($_POST['content'],10);
		$_clean = _mysql_string($_clean);
		
		//execute SQL
		_query("UPDATE tg_article SET 
																tg_type='{$_clean['type']}',
																tg_title='{$_clean['title']}',
																tg_content='{$_clean['content']}',
																tg_last_modify_date=NOW()
													WHERE
																tg_id='{$_clean['id']}'
		");
		if (_affected_rows() == 1) {
			_close();
			//_session_destroy();
			_location('Successfully modified!','article.php?id='.$_clean['id']);
		} else {
			_close();
			//_session_destroy();
			_alert_back('Fail to modify');
		}
	} else {
		_alert_back('Illegal access');
	}
}
//¶ÁÈ¡Êý¾Ý
if (isset($_GET['id'])) {
		if (!!$_rows = _fetch_array("SELECT 
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content
													  FROM 
																	tg_article 
													WHERE
																	tg_reid=0
															AND
																	tg_id='{$_GET['id']}'")) {
			$_html = array();
			$_html['id'] = $_GET['id'];
			$_html['username'] = $_rows['tg_username'];
			$_html['title'] = $_rows['tg_title'];
			$_html['type'] = $_rows['tg_type'];
			$_html['content'] = $_rows['tg_content'];
			$_html = _html($_html);		

			//validate authority
			if ($_COOKIE['username'] != $_html['username']) {
				_alert_back('No authority');
			}
			
		} else {
			_alert_back('This post does not exist');
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
<script type="text/javascript"src = "js/code.js"></script>
<script type="text/javascript"src = "js/post.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="post">
	<h2>Modify a post</h2>
	<form method="post" name = "post" action="?action=modify">
		<input type="hidden" value="<?php echo $_html['id']?>" name="id" />
		<dl>
			<dt>Please modify the information below</dt>
			<dd>
				Type:
				<?php 
					foreach (range(1,16) as $_num) {
						if ($_num == $_html['type']) {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" checked="checked"/> ';
						} else {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" /> ';
						}
						echo ' <img src="images/icon'.$_num.'.gif" alt="T" /></label>';
						if ($_num == 8) {
							echo '<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
						}
					}
				?>
			</dd>
			<dd>Title:<input type="text" name="title"value="<?php echo $_html['title'];?>" class="text" />(*Two words)</dd>
			<dd id="q">Expression:<?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[1]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[2]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content"rows="9"><?php echo $_html['content'];?></textarea>
			</dd>
			<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
			<dd><input type="submit" class="submit" value="Modify" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>