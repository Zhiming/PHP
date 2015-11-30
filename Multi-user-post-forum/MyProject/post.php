<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","post");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

if(!isset($_COOKIE['username'])){
	_location('Please login before post', 'login.php');
}

//write post into database
if(isset($_GET['action'])&&($_GET['action']=='post')){
	//protect from illegal registration		
	_check_code($_POST['code'], $_SESSION['RandCode']);
	//echo $_SESSION['RandCode'].' and '.$_POST['code'];
	//make sure this user does exist
		if(!!$_rows = _fetch_array("select 
										                     tg_uniqid, 
										                     tg_post_time
									                   from 
										                     tg_user 
									                where 
										                     tg_username = '{$_COOKIE['username']}'
									                   limit 1"
									
		  )){
			global $_system;
			//Protect from faking unique identifier
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			
			//protect from spamming
			_timed(time(),$_rows['tg_post_time'],$_system['post']);
			//echo "<script>alert('".$_system['post']."')</script>";
			include ROOT_PATH.'includes/check.func.php';
			//receive content in the post
			$_clean = array();
			$_clean['username'] = $_COOKIE['username'];
			$_clean['type'] = $_POST['type'];
			$_clean['title'] = _check_post_title($_POST['title'],2,40);
			$_clean['content'] = _check_post_content($_POST['content'],10);
			$_clean = _mysql_string($_clean);
			//write into database
			_insert("INSERT INTO 
			                                tg_article (
														tg_username,
														tg_title,
														tg_type,
														tg_content,
														tg_date
													        ) 
								VALUES (
											'{$_clean['username']}',
											'{$_clean['title']}',
											'{$_clean['type']}',
											'{$_clean['content']}',
											NOW()
					)");
			if (_affected_rows() == 1) {
				$_clean['id'] = _insert_id();
				//create a cookie to record post time to protect from spamming
				//setcookie('post_time', time());
				$_clean['time'] = time();
				_query("UPDATE 
				                         tg_user 
				                    SET 
				                         tg_post_time='{$_clean['time']}' 
				               WHERE 
				                         tg_username='{$_COOKIE['username']}'");
				_close();
				//_session_destroy();
				_location('Successfully post£¡','article.php?id='.$_clean['id']);
			} else {
				_close();
				//_session_destroy();
				_alert_back('Fail to post£¡');
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
<script type="text/javascript"src = "js/post.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="post">
	<h2>Write a post</h2>
	<form method="post" name = "post" action="?action=post">
		<dl>
			<dt>Please fill in the information below</dt>
			<dd>
				Type:
				<?php 
					foreach (range(1,16) as $_num) {
						if ($_num == 1) {
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
			<dd>Title:<input type="text" name="title" class="text" />(*Two words)</dd>
			<dd id="q">Expression:<?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[1]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[2]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content"rows="9"></textarea>
			</dd>
			<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
			<dd><input type="submit" class="submit" value="Post" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>