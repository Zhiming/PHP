<?php 
//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","active");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

if (!isset($_GET['active'])) {
	_alert_back('illegal access');
}
if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
	$_active = _mysql_string($_GET['active']);
	if (_fetch_array("SELECT 
						tg_active 
					  FROM 
					    tg_user 
					  WHERE 
					    tg_active='$_active' 
					  LIMIT 1"
		)) {
		//clear tg_active
		_query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if (_affected_rows() == 1) {
			_close();
			_location('successfully activated','login.php');
		} else {
			_close();
			_location('fail to activate','register.php');
		}
	} else {
		_alert_back('illegal access');
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
<script type="text/javascript"src = "js/register.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="active">
	<h2>activate your account</h2>
	<p>click the following URL to activate your account</p>
	<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>