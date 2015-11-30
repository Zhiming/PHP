<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member_friend");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//whether login
if(!isset($_COOKIE['username'])){
	_alert_back('Please login first');
}

//validate friend request
if(isset($_GET['id'])&&($_GET['action']=='check')){
	//protect from illegal deleting by validating unique identifier
	if (!!$_rows = _fetch_array("SELECT 
									   tg_uniqid 
								   FROM 
									   tg_user 
								  WHERE 
									   tg_username='{$_COOKIE['username']}' 
									 LIMIT 1"
	                            )) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
	    //update state in tg_friend to approve the request
		_query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
		if (_affected_rows() == 1) {
			_close();
			_location('Request approved','member_friend.php');
		} else {
			_close();
			_alert_back('Fail to approve the request');
		}
	} else {
		_alert_back('Illegal access');
	}
}

//delete friend requests
if ((isset($_GET['action']))&&($_GET['action'] == 'delete') && (isset($_POST['ids']))) {
	$_clean = array();
	$_clean['ids'] = _mysql_string(implode(',',$_POST['ids']));
	//protect from illegal deleting by validating unique identifier
	if (!!$_rows = _fetch_array("SELECT 
									   tg_uniqid 
								   FROM 
									   tg_user 
								  WHERE 
									   tg_username='{$_COOKIE['username']}' 
									 LIMIT 1"
	                            )) {
		_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
		_query("DELETE FROM 
						   tg_friend 
					  WHERE 
						   tg_id 
						 IN 
						   ({$_clean['ids']})"
			  );
		if (_affected_rows()) {
			_close();
			_location('Friend request deleted','member_friend.php');
		} else {
			_close();
			_alert_back('Fail to delete');
		}
	} else {
		_alert_back('Illegal access');
	}
}

//Paging module
global $_pagesize, $_pagenum;
//the first parameter is the number of records and the second one is the number of records displayed on each page
_page("select 
             tg_id 
		 from 
		     tg_friend
		where 
		     tg_touser ='{$_COOKIE['username']}'
		   or
		     tg_fromuser='{$_COOKIE['username']}'" ,10);

$_result = _query("select 
						tg_id,tg_state,tg_fromuser,tg_touser,tg_content,tg_date 
				   from 
				   		tg_friend
				  where
				   		tg_touser = '{$_COOKIE['username']}'
				   	 or
		                tg_fromuser='{$_COOKIE['username']}'
				   order by 
				   		tg_date desc 
				   limit 
						$_pagenum, $_pagesize"
				  );
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
	require ROOT_PATH.'includes/member.inc.php';
?>
	<div id="member_main">
		<h2>Friend Request Management</h2>
		<form method="post"action="?action=delete">
		<table cellspacing="1">
			<tr><th>Friend</th><th>Request</th><th>Date</th><th>State</th><th>Check</th></tr>
			<?php 
				while(!!$_rows=_fetch_array_list($_result)){
					$_html = array();
					$_html['id'] = $_rows['tg_id'];
					$_html['touser'] = $_rows['tg_touser'];
					$_html['fromuser'] = $_rows['tg_fromuser'];
					$_html['content'] = $_rows['tg_content'];
					$_html['state'] = $_rows['tg_state'];
					$_html['date'] = $_rows['tg_date'];
					$_html = _html($_html);
					if ($_html['touser'] == $_COOKIE['username']) {
						$_html['friend'] = $_html['fromuser'];
						if (empty($_html['state'])) {
							$_html['state_html'] = '<a href="?action=check&id='.$_html['id'].'" style="color:red;">Please validate the request</a>';
						} else {
							$_html['state_html'] = '<span style="color:green;">Approved</span>';
						}
					} elseif ($_html['fromuser'] == $_COOKIE['username']) {
						$_html['friend'] = $_html['touser'];
						if (empty($_html['state'])) {
							$_html['state_html'] = '<span style="color:blue;">Request not being confirmed by the user</span>';
						} else {
							$_html['state_html'] = '<span style="color:green;">Approved</span>';
						}
					}
			?>
			<tr><td><?php echo $_html['friend']?></td><td title="<?php echo $_html['content']?>"><?php echo _title($_html['content'])?></td><td><?php echo $_html['date']?></td><td><?php echo $_html['state_html']?></td><td><input name="ids[]" value="<?php echo $_html['id']?>" type="checkbox" /></td></tr>			                                                                                                                   
			<?php 
			  }
			  _free_result($_result);
			?>
			<tr><td colspan="5"><label for="all">All <input type="checkbox" name="chkall" id="all" /></label> <input type="submit" value="Delete selected" /></td></tr>
		</table>                                                                         <!-- send id="all" to member_message.js -->
		</form>
		<?php 
		//_paging calls paging, 1 for number paging and 2 for text paging
		_paging(2);
		?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>