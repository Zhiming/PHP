<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","blog");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//Paging module
global $_pagesize, $_pagenum,$_system;
_page("select tg_id from tg_user",$_system['blog']);

//get data from database
//Notice here we can't put this SQL statement into _fetch_array()
//for this would result in forever loop. This SQL statement would execute
//forever. The right thing to do is search the database once, and read the
//resource handle several time with a while loop(this is what we do below)
$_result = _query("select 
									tg_id,tg_username,tg_sex,tg_profile 
				 	  			from 
				   					tg_user 
				   		 order by 
				   					tg_reg_time desc 
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
<script type="text/javascript"src="js/blog.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
	<h2>Friends List</h2>
	<?php
		while(!!$_rows=_fetch_array_list($_result)){
		$_html = array(); 
		$_html['id'] = $_rows['tg_id'];
		$_html['username'] = $_rows['tg_username'];
		$_html['face'] = $_rows['tg_profile'];			
		$_html['sex'] = $_rows['tg_sex'];
		$_html = _html($_html);
	?>
	<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex'] ?>)</dd>
		<dt><img src="<?php echo $_html['face']?>" alt="st_ao" /></dt>
		<dd class="message"><a href="javascript:;"name="message"title="<?php echo $_html['id'];?>">Message<input type="hidden"name="id"value="<?php echo $_html['id'];?>"/></a></dd>
		<dd class="friend"><a href="javascript:;"name="friend"title="<?php echo $_html['id'];?>">+Friend</a></dd>
		<dd class="flower"><a href="javascript:;"name="flower"title="<?php echo $_html['id'];?>">Flower</a></dd>
		<dd class="guest"><a href="post.php">Post</a></dd>
	</dl>
	<?php }
		_free_result($_result);
		//_paging calls paging, 1 for number paging and 2 for text paging
		_paging(2);
	?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>