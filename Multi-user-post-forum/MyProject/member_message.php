<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member_message");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//whether login
if(!isset($_COOKIE['username'])){
	_alert_back('Please login first');
}

//delete message seleted
if(isset($_GET['action'])&&($_GET['action']=='delete')&&isset($_POST['ids'])){
	$_clean = array();
	$_clean['ids'] = _mysql_string(implode(',', $_POST['ids']));
	//protect from illegal deleting by validating unique identifier
	if (!!$_rows = _fetch_array("SELECT 
									 tg_uniqid 
		 						   FROM 
									 tg_user 
								  WHERE 
									 tg_username='{$_COOKIE['username']}' 
								LIMIT 1"
			)){
				//Protect from faking unique identifier
				_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
				_query("DELETE FROM 
								  tg_message 
							  WHERE 
								  tg_id 
								 IN 
								  ({$_clean['ids']})"
					  );
				if (_affected_rows()) {
					_close();
					_location('Message deleted','member_message.php');
				} else {
					_close();
					_alert_back('Fail to delete');
				}
			}else{
				_alert_back('Illegal access');
			}
}

//Paging module
global $_pagesize, $_pagenum;
//the first parameter is the number of records and the second one is the number of records displayed on each page
_page("select 
             tg_id 
		 from 
		     tg_message 
		where 
		     tg_touser ='{$_COOKIE['username']}'" ,10);

$_result = _query("select 
						tg_id,tg_state,tg_fromuser,tg_touser,tg_content,tg_date 
				   from 
				   		tg_message
				  where
				   		tg_touser = '{$_COOKIE['username']}'
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
		<h2>Message Management</h2>
		<form method="post"action="?action=delete">
		<table cellspacing="1">
			<tr><th>Sender</th><th>Content</th><th>Date</th><th>State</th><th>Check</th></tr>
			<?php 
				while(!!$_rows=_fetch_array_list($_result)){
					$_html = array();
					$_html['id'] = $_rows['tg_id'];
					$_html['fromuser'] = $_rows['tg_fromuser'];
					$_html['content'] = $_rows['tg_content'];
					$_html['date'] = $_rows['tg_date'];
					$_html = _html($_html);
					if(empty($_rows['tg_state'])){
						$_html['state'] = '<img src="images/read.gif" alt="Not read" title="Not read" />';
						$_html['content_html'] = '<strong>'._title($_html['content']).'</strong>';
					}else{
						$_html['state'] = '<img src="images/noread.gif" alt="Read title="Read" />';
						$_html['content_html'] = _title($_html['content']);
					}
			?>
			<tr><td><?php echo $_html['fromuser'];?></td><td><a href="member_message_detail.php?id=<?php echo $_html['id'];?>"title="<?php echo $_html['content'];?>"><?php echo _title($_html['content_html']);?></a></td><td><?php echo $_html['date'];?></td><td><?php echo $_html['state'];?></td><td><input name="ids[]"value="<?php echo $_html['id'];?>" type="checkbox"/></td></tr>
			                                                                                                                   
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