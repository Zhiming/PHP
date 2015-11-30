<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","member_post");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//whether login
if(!isset($_COOKIE['username'])){
	_alert_back('Please login first');
}


//Paging module
global $_pagesize, $_pagenum;
//the first parameter is the number of records and the second one is the number of records displayed on each page
_page("select 
             tg_id 
		 from 
		     tg_article 
		where 
			 tg_reid=0
		and
		     tg_username ='{$_COOKIE['username']}'" ,10);


$_result = _query("select 
										tg_id,tg_title,tg_content,tg_date 
								   from 
								   		tg_article
								  where
								   		tg_username = '{$_COOKIE['username']}'
								   	and
								   		tg_reid = 0
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
		<h2>Post Management</h2>
		<form method="post"action="?action=delete">
		<table cellspacing="1">
			<tr><th>Title</th><th>Content</th><th>Date</th></tr>
			<?php 
				while(!!$_rows=_fetch_array_list($_result)){
					$_html = array();
					$_html['id'] = $_rows['tg_id'];
					$_html['title'] = $_rows['tg_title'];
					$_html['content'] = $_rows['tg_content'];
					$_html['date'] = $_rows['tg_date'];
					$_html = _html($_html);
			?>
			<tr><td><?php echo $_html['title'];?></td><td><a href="article.php?id=<?php echo $_html['id'];?>"><?php echo _title($_html['content']);?></a></td><td><?php echo $_html['date'];?></td></tr>
		   <?php 
			  }
			  _free_result($_result);
			?>
			
		</table>                                                                      
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