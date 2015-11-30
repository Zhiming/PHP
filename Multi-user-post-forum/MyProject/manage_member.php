<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","manage_member");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

_manage_login();

//add an administrator
if(isset($_GET['action'])&&$_GET['action']=='add'){
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
			$_clean = array();
			$_clean['username'] = $_POST['manage'];
			$_clean = _mysql_string($_clean);
			//upgrade a user's level
			_query("UPDATE 
			                         tg_user 
			                    SET 
			                         tg_level=1 
			               WHERE 
			                         tg_username='{$_clean['username']}'");
			if (_affected_rows() == 1) {
						_close();
						_location('Successfully added',SCRIPT.'.php');
			} else {
						_close();
						_alert_back('Fail to add');
			}
	}  else {
			_alert_back('Illegal access');
	}
}

global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user",15); 
$_result = _query("SELECT 
											tg_id,
											tg_username,
											tg_email,
											tg_reg_time
								  FROM 
											tg_user 
						   ORDER BY 
											tg_reg_time DESC 
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
<script type="text/javascript"src="js/member_message.js"></script>
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
		<h2>Member List</h2>
		<table cellspacing="1">
			<tr><th>ID</th><th>Username</th><th>Email</th><th>Registration date</th></tr>
			<?php 
					$_html = array();
					while (!!$_rows = _fetch_array_list($_result)) {
						$_html['id'] = $_rows['tg_id'];
						$_html['username'] = $_rows['tg_username'];
						$_html['email'] = $_rows['tg_email'];
						$_html['reg_time'] = $_rows['tg_reg_time'];
						$_html = _html($_html);
			?>
			<tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td></tr>
			<?php }?>
			</table>
			<form method="post"action="?action=add">
				<input type="text"name="manage"class="text"/><input type="submit"value="Add an administrator"/>
			</form>
	<?php 
		_free_result($_result);
		_paging(2);
	?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>