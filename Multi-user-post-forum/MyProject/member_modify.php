<?php

if(!isset($_SESSION)){
	session_start();
}

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member_modify");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//Update information
if(isset($_GET['action'])){
	if ($_GET['action'] == 'modify') {
		//protect from illegal registration		
		_check_code($_POST['code'], $_SESSION['RandCode']);
		//make sure this user does exist
		if(!!$_rows = _fetch_array("select 
										                     tg_uniqid 
									                   from 
										                     tg_user 
									                where 
										                     tg_username = '{$_COOKIE['username']}'
									                  limit 1"
		  )){
			//Protect from faking unique identifier
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			//include register.func.php
			include ROOT_PATH.'includes/check.func.php';
			$_clean = array();
			$_clean['password'] = _check_modify_password($_POST['password']);
			$_clean['sex'] = _check_sex($_POST['sex']);
			$_clean['face'] = _check_profile($_POST['face']);
			$_clean['email'] = _check_email($_POST['email']);
			$_clean['msn'] = _check_msn($_POST['msn']);
			$_clean['url'] = _check_url($_POST['url']);
			$_clean['switch'] = $_POST['switch'];
			$_clean['autograph'] = _check_autograph($_POST['autograph']);
			
			//update information
			if (empty($_clean['password'])) {
				_query("UPDATE 
				              			tg_user 
				                    SET 
									    tg_sex='{$_clean['sex']}',
									    tg_profile='{$_clean['face']}',
									    tg_email='{$_clean['email']}',
									    tg_msn='{$_clean['msn']}',
									    tg_url='{$_clean['url']}',
									    tg_switch='{$_clean['switch']}',
									    tg_autograph='{$_clean['autograph']}'
						      WHERE
							           tg_username='{$_COOKIE['username']}' 
						");
			} else {
				_query("UPDATE 
				              			   tg_user 
				                     SET 
										   tg_password='{$_clean['password']}',
									       tg_sex='{$_clean['sex']}',
										   tg_profile='{$_clean['face']}',
										   tg_email='{$_clean['email']}',
										   tg_msn='{$_clean['msn']}',
										   tg_url='{$_clean['url']}',
										   tg_switch='{$_clean['switch']}',
									   	   tg_autograph='{$_clean['autograph']}'
						       WHERE
							   			   tg_username='{$_COOKIE['username']}' 
						");
			}
		}
		//whether successfully update
		if (_affected_rows() == 1) {
			_close();
			//_session_destroy();
			_location('Congratulation, update succeed','member.php');
		} else {
			_close();
			//_session_destroy();
			_location('No information updated','member_modify.php');
		}
	}
}
//check login status
if(isset($_COOKIE['username'])){
	//Get data from database
	$_rows = _fetch_array("SELECT 
	                                                 tg_switch,tg_autograph,tg_username,tg_sex,tg_profile,tg_email,tg_url,tg_msn 
	                                          FROM 
	                                                 tg_user 
	                                       WHERE 
	                                                 tg_username='{$_COOKIE['username']}'");
	//check whether this username exists
	if($_rows){
		$_html = array();
		$_html['username'] = $_rows['tg_username'];
		$_html['sex'] = $_rows['tg_sex'];
		$_html['face'] = $_rows['tg_profile'];
		$_html['email'] = $_rows['tg_email'];
		$_html['url'] = $_rows['tg_url'];
		$_html['msn'] = $_rows['tg_msn'];
		$_html['switch'] = $_rows['tg_switch'];
		$_html['autograph'] = $_rows['tg_autograph'];
		$_html = _html($_html);
		
		//Gender selection
		if ($_html['sex'] == 'M') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="M" checked="checked" /> M <input type="radio" name="sex" value="F" /> F';
		} elseif ($_html['sex'] == 'F') {
			$_html['sex_html'] = '<input type="radio" name="sex" value="M" /> M <input type="radio" name="sex" value="F" checked="checked" /> F';
		}
		
		//profile choose
		$_html['face_html'] = '<select name="face">';
		foreach (range(1,8) as $_num) {
			if($_html['face'] == 'profile/profile'.$_num.'.jpg'){
				$_html['face_html'] .= '<option value="profile/profile'.$_num.'.jpg"selected="selected">profile/profile'.$_num.'.jpg</option>';
			} else{
				$_html['face_html'] .= '<option value="profile/profile'.$_num.'.jpg">profile/profile'.$_num.'.jpg</option>';
			}
		}
		$_html['face_html'] .= '</select>';
		
		//autograph switch
		if ($_html['switch'] == 1) {
			$_html['switch_html'] = '<input type="radio" checked="checked" name="switch" value="1" /> Turn on <input type="radio" name="switch" value="0" /> Turn off';
		} elseif ($_html['switch'] == 0) {
			$_html['switch_html'] = '<input type="radio" name="switch" value="1" /> Turn on <input type="radio" name="switch" value="0" checked="checked" /> Turn off';
		}
			
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
<script type="text/javascript"src="js/code.js"></script>
<script type="text/javascript"src="js/member_modify.js"></script>
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
		<form method="post" action="member_modify.php?action=modify">
		<dl>
			<dd>Username: <?php echo $_html['username'];?></dd>
			<dd>Password: <input type="password"class="text"name="password"/></dd>
			<dd>Gender: <?php echo $_html['sex_html'];?></dd>
			<dd>Figure: <?php echo $_html['face_html'].'</br>';?></dd>
			<dd>Email:<input type="text"class="text"name="email"value="<?php echo $_html['email'];?>"/></dd>
			<dd>Personal Page: <input type="text"class="text"name="url"value="<?php echo $_html['url'];?>"/></dd>
			<dd>MSN: <input type="text"class="text"name="msn"value="<?php echo $_html['msn'];?>"/></dd>
			<dd>Autograph: <?php echo $_html['switch_html'].' (ubb is available)';?>
				<p><textarea name="autograph"><?php echo $_html['autograph'];?></textarea></p>
			</dd>
			<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/><input type="submit" class="submit" value="Update" /></dd>
		</dl>
		</form>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
