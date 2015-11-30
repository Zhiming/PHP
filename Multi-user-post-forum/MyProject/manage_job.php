<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","manage_job");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

_manage_login();

//Resign
if (isset($_GET['action'])&&$_GET['action'] == 'job' && isset($_GET['id'])) {
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
			//Resign
			_query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' AND tg_id='{$_GET['id']}'");
			if (_affected_rows() == 1) {
				_close();
				_session_destroy();
				_location('Successfully resign','index.php');
			} else {
				_close();
				_alert_back('Fail to resign');
			}
	} else {
		_alert_back('Illegal access');
	}
}

global $_pagesize,$_pagenum;
_page("SELECT tg_id FROM tg_user where tg_level=1",15); 
$_result = _query("SELECT 
											tg_id,
											tg_username,
											tg_email,
											tg_reg_time
								  FROM 
											tg_user 
							    WHERE
							                tg_level=1
						   ORDER BY 
											tg_reg_time DESC 
								  LIMIT 
												$_pagenum,$_pagesize
							");	
$_resultcount = _query("SELECT 
													COUNT(tg_id) as count
										  FROM 
													tg_user 
									    WHERE
									                tg_level=1
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
			<tr><th>ID</th><th>Administrator</th><th>Email</th><th>Registration date</th><th>Operation</th></tr>
			<?php 
					$_html = array();
					$_html = _fetch_array_list($_resultcount);
					//echo $_html['count'];
					while (!!$_rows = _fetch_array_list($_result)) {
						$_html['id'] = $_rows['tg_id'];
						$_html['username'] = $_rows['tg_username'];
						$_html['email'] = $_rows['tg_email'];
						$_html['reg_time'] = $_rows['tg_reg_time'];
						$_html = _html($_html);
						if ($_COOKIE['username'] == $_html['username'] && $_html['count'] >1) {
							$_html['job_html'] = '<a href="manage_job.php?action=job&id='.$_html['id'].'">Resign</a>';
						} else {
							$_html['job_html'] = '';
						}
			?>
			<tr><td><?php echo $_html['id']?></td><td><?php echo $_html['username']?></td><td><?php echo $_html['email']?></td><td><?php echo $_html['reg_time']?></td><td><?php echo $_html['job_html']?></td></tr>
			<?php }?>
			</table>
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