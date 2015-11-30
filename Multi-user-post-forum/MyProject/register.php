<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","register");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//flag login state
_login_state();

//whether the form is submitted
if(isset($_POST['action'])){
	if($_POST['action']=='register'){
	
		//protect from illegal registration		
		_check_code($_POST['code'], $_SESSION['RandCode']);
		
		//include register.func.php
		include ROOT_PATH.'includes/check.func.php';
		$_clean = array();
		//protect from illegal registration by unique identifier
		$_clean['uniqid'] = _check_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
		// For a registered user to activate the account
		$_clean['active'] = _sha1_uniqid();
		$_clean['username'] = _check_username($_POST['username']);
		$_clean['password'] = _check_password($_POST['password'], $_POST['notpassword']);
		$_clean['question'] = _check_question($_POST['question']);
		$_clean['answer'] = _check_answer($_POST['question'], $_POST['answer']);
		$_clean['sex'] = _check_sex($_POST['sex']);
		$_clean['profile'] = _check_profile($_POST['profile']);
		$_clean['email'] = _check_email($_POST['email']);
		$_clean['msn'] = _check_msn($_POST['msn']);
		$_clean['url'] = _check_url($_POST['url']);
		
		//check whether this username has been registered
		_is_repeat(
		"select tg_username from tg_user where tg_username = '{$_clean['username']}'limit 1" 
		,'This username has been registered');
	
		//insert information into database
		//Between double quotation marks, a variable's name could be used; However, an array element can't.
		//A pair of braces are used to fix this problem
			_insert(
						"INSERT INTO tg_user (
																tg_uniqid,
																tg_active,
																tg_username,
																tg_password,
																tg_question,
																tg_answer,
																tg_sex,
																tg_profile,
																tg_email,
																tg_msn,
																tg_url,
																tg_reg_time,
																tg_last_time,
																tg_last_ip
																) 
												VALUES (
																'{$_clean['uniqid']}',
																'{$_clean['active']}',
																'{$_clean['username']}',
																'{$_clean['password']}',
																'{$_clean['question']}',
																'{$_clean['answer']}',
																'{$_clean['sex']}',
																'{$_clean['profile']}',
																'{$_clean['email']}',
																'{$_clean['msn']}',
																'{$_clean['url']}',
																NOW(),
																NOW(),
																'{$_SERVER["REMOTE_ADDR"]}'
																)"
	);
	//_SERVER["REMOTE_ADDR"] would acquire the current login IP address
	if(_affected_rows() == 1){
		//receive the id number in the previous "insert" statement
		$_clean['id'] = _insert_id();
		_close();
		//_session_destroy();
		//XML
		_set_xml('new.xml',$_clean);
		//skip to main page
		_location('congratulation, registration succeed','active.php?active='.$_clean['active']);
	} else {
		_location('registration fails','register.php');
		//_session_destroy();
		_close();
	}

	}
}else {
	$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
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
<script type="text/javascript"src = "js/register.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="register">
	<h2>Register</h2>
	<form method="post" name = "register" action="register.php">
	 <input type = "hidden" name = "action" value = "register"/>
	 <input type = "hidden" name = "uniqid" <?php $_uniqid = _sha1_uniqid(); $_SESSION['uniqid'] = $_uniqid;?> value = "<?php echo $_uniqid;?>"/>	
		<dl>
			<dt>Please fill in the information below</dt>
			<dd>Username:<input type="text" name="username" class="text" />(*Two characters)</dd>
			<dd>Password:<input type="password" name="password" class="text" />(*Six characters)</dd>
			<dd>Password confirm:<input type="password" name="notpassword" class="text" />(*Six characters)</dd>
			<dd>Password question:<input type="text" name="question" class="text" />(*Two characters)</dd>
			<dd>Password answer:<input type="text" name="answer" class="text" />(*Two characters)</dd>
			<dd>Gender:<input type="radio" name="sex" value="Male" checked="checked" />Male <input type="radio" name="sex" value="Female" />Female</dd>
			<dd class="profile"><input type="hidden" name="profile" value="profile/profile1.jpg" /><img src="profile/profile1.jpg" alt="choose profile" id="profileimg"/></dd>
			<dd>Email:<input type="text" name="email" class="text" />(*For activating account)</dd>
			<dd>MSN:<input type="text" name="msn" class="text" /></dd>
			<dd>Main page address:<input type="text" name="url" class="text" value="http://" /></dd>
			<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
			<dd><input type="submit" class="submit" value="Register" /></dd>
			<dd class = "notif">(* is required)</dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>