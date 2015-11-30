<?php

if(!isset($_SESSION)){
	session_start();
}

//No illegal access
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","index");

//include the common file
require dirname(__FILE__).'/includes/common.inc.php'; //absolute path

//read XML
$_html = _html(_get_xml('new.xml'));

//read post list
global $_pagesize,$_pagenum,$_system;
_page("SELECT tg_id FROM tg_article where tg_reid=0",$_system['article']); 
$_result = _query("SELECT 
										tg_id,tg_title,tg_type,tg_readcount,tg_commentcount 
								  FROM 
										tg_article 
							   WHERE
										tg_reid=0
						   ORDER BY 
										tg_date DESC 
								  LIMIT 
										$_pagenum,$_pagesize
							");	

//read the lastes public picture
$_photo = _fetch_array("SELECT
															tg_id AS id,
															tg_name AS name,
															tg_url AS url 
												FROM 
															tg_photo 
											WHERE
															tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0)
										ORDER BY 
															tg_date DESC 
												LIMIT 
															1
");
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

<div id="list">
	<h2>Post</h2>
	<a href="post.php"class="post">New Topic</a>
		<ul class="article">
		<?php
			$_htmllist = array();
			while (!!$_rows = _fetch_array_list($_result)) {
				$_htmllist['id'] = $_rows['tg_id'];
				$_htmllist['type'] = $_rows['tg_type'];
				$_htmllist['readcount'] = $_rows['tg_readcount'];
				$_htmllist['commentcount'] = $_rows['tg_commentcount'];
				$_htmllist['title'] = $_rows['tg_title'];
				$_htmllist = _html($_htmllist);
				echo '<li class="icon'.$_htmllist['type'].'"><em>Popularity(<strong>'.$_htmllist['readcount'].'</strong>) Comments(<strong>'.$_htmllist['commentcount'].'</strong>)</em> <a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
			}
			_free_result($_result);
		?>
		</ul>
		<?php _paging(2);?>
</div>

<div id="user">
	<h2>New User</h2>
		<dl>
		<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
		<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>"/></dt>
		<dd class="message"><a href="javascript:;"name="message"title="<?php echo $_html['id']?>">Message</a></dd>
		<dd class="friend"><a href="javascript:;"name="friend"title="<?php echo $_html['id']?>">+Friend</a></dd>
		<dd class="guest"><a href="post.php">Post</a></dd>
		<dd class="flower"><a href="javascript:;"name="flower"title="<?php echo $_html['id']?>">Flower</a></dd>
		<dd class="email">Email:<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
		<dd class="url">URL:<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
	</dl>
</div>

<div id="pics">
	<h2>Latest pictures -- <?php echo $_photo['name'];?></h2>
	<a href="photo_detail.php?id=<?php echo $_photo['id']?>"><img src="thumb.php?filename=<?php echo $_photo['url']?>&percent=0.4" alt="<?php echo $_photo['name']?>" /></a>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
