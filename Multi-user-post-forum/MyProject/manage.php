<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","manage");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//protect from illegal accessing management
_manage_login();

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
		<dl>
			<dd>Server host name: <?php echo $_SERVER['SERVER_NAME']; ?></dd>
			<dd>Communication protocol name/version: <?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
			<dd>Server IP: <?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
			<dd>Client IP: <?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
			<dd>Server port: <?php echo $_SERVER['SERVER_PORT']; ?></dd>
			<dd>Client port: <?php echo $_SERVER["REMOTE_PORT"]; ?></dd>
			<dd>Admin email: <?php echo $_SERVER['SERVER_ADMIN'] ?></dd>
			<dd>Host head content: <?php echo $_SERVER['HTTP_HOST']; ?></dd>
			<dd>Server main diretory: <?php echo $_SERVER["DOCUMENT_ROOT"]; ?></dd>
			<dd>Script path: <?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
			<dd>Apache and PHP version: <?php echo $_SERVER["SERVER_SOFTWARE"]; ?></dd>
		</dl>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
