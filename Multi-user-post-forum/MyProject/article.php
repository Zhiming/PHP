<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","article");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//processing reply
if(isset($_GET['action'])&&$_GET['action']=='rearticle'){
    //protect from illegal registration	
	_check_code($_POST['code'],$_SESSION['RandCode']);
	//echo $_POST['code'].' and '.$_SESSION['RandCode'];
	if (!!$_rows = _fetch_array("SELECT 
																	tg_uniqid,
																	tg_article_time 
														FROM 
																	tg_user 
													 WHERE 
																	tg_username='{$_COOKIE['username']}' 
														 LIMIT 
																	1"
			)) {
			_uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
			global $_system;
			//protect from spamming
			_timed(time(), $_rows['tg_article_time'],$_system['re']);
			//echo "<script>alert('".$_system['re']."')</script>";
			
			//receive reply in the post
			$_clean = array();
			$_clean['reid'] = $_POST['reid'];
			$_clean['type'] = $_POST['type'];
			$_clean['title'] = $_POST['title'];
			$_clean['content'] = $_POST['content'];
			$_clean['username'] = $_COOKIE['username'];
			$_clean = _mysql_string($_clean);
			//write into database
			_query("INSERT INTO tg_article (
																	tg_reid,
																	tg_username,
																	tg_title,
																	tg_type,
																	tg_content,
																	tg_date
																)
												 VALUES (
												 					'{$_clean['reid']}',
												 					'{$_clean['username']}',
												 					'{$_clean['title']}',
												 					'{$_clean['type']}',
												 					'{$_clean['content']}',
												 					NOW()
												 				)"
			);
			if (_affected_rows() == 1) {
				//setcookie('article_time',time());
				$_clean['time'] = time();
				_query("UPDATE 
				                         tg_user 
				                    SET 
				                         tg_article_time='{$_clean['time']}' 
				               WHERE 
				                         tg_username='{$_COOKIE['username']}'");
				_query("UPDATE 
				                         tg_article 
				                    SET 
				                         tg_commentcount=tg_commentcount+1 
				               WHERE 
				                         tg_reid=0 
				                    AND 
				                         tg_id='{$_clean['reid']}'");
				_close();
				//_session_destroy();
				_location('Successfully reply£¡','article.php?id='.$_clean['reid']);
			} else {
				_close();
				//_session_destroy();
				_alert_back('Fail to replay');
			}
	} else {
		_alert_back('Illegal access');
	}
}

//read data
if(isset($_GET['id'])){
		if (!!$_rows = _fetch_array("SELECT 
							                                   tg_id,
							                                   tg_username,
							                                   tg_title,
							                                   tg_type,
							                                   tg_content,
							                                   tg_readcount,
							                                   tg_commentcount,
							                                   tg_last_modify_date,
							                                   tg_date
	                                  					from
	                                  						   tg_article
	                                  				  where
	                                  				  		   tg_reid = 0
	                                  				  	  and
	                                 						   tg_id='{$_GET['id']}'")){
		
		//the number of reading
		_query("update 
								tg_article
							set 
							    tg_readcount=tg_readcount+1 
					   where 
					           tg_id='{$_GET['id']}'");
		
		$_html = array();
		$_html['reid'] = $_rows['tg_id'];
		$_html['username'] = $_rows['tg_username'];
	  	$_html['title'] = $_rows['tg_title'];
		$_html['type'] = $_rows['tg_type'];
		$_html['content'] = $_rows['tg_content'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commentcount'] = $_rows['tg_commentcount'];
		$_html['last_modify_date'] = $_rows['tg_last_modify_date'];
		$_html['date'] = $_rows['tg_date'];
		
		//read username and look up the user information
		if (!!$_rows = _fetch_array("SELECT 
																tg_id,
																tg_sex,
																tg_profile,
																tg_email,
																tg_url,
																tg_switch,
																tg_autograph
									                    FROM 
							  				                    tg_user 
									                 WHERE 
											                    tg_username='{$_html['username']}'")) {
			//read user information
			$_html['userid'] = $_rows['tg_id'];
			$_html['sex'] = $_rows['tg_sex'];
			$_html['face'] = $_rows['tg_profile'];
			$_html['email'] = $_rows['tg_email'];
			$_html['url'] = $_rows['tg_url'];
			$_html['switch'] = $_rows['tg_switch'];
			$_html['autograph'] = $_rows['tg_autograph'];
			$_html = _html($_html);	
			
			//paging with id as a parameter
			global $_id;
			$_id = 'id='.$_html['reid'].'&';
			
			//main topic post modification
			if(isset($_COOKIE['username'])&& $_html['username'] == $_COOKIE['username']){
				$_html['subject_modify'] = '[<a href="article_modify.php?id='.$_html['reid'].'">Modify</a>]';
			}
			
			//read the last modification date
			if ($_html['last_modify_date'] != '0000-00-00 00:00:00') {
				$_html['last_modify_date_string'] = 'This post is modified by ['.$_html['username'].'] at '.$_html['last_modify_date'].'.';
			}
			
			//reply to the main post 
            if (isset($_COOKIE['username'])) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="Reply to '.$_html['username'].'. 1#.">Reply</a>]</span>';
			}
			
			//autograph
			if ($_html['switch'] == 1) {
				$_html['autograph_html'] = '<p class="autograph">'.$_html['autograph'].'</p>';
			}
			
			//read reply
			global $_pagesize,$_pagenum,$_page,$_page;
			_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_html['reid']}'",2); 
			
			$_result = _query("SELECT 
												     tg_username,tg_type,tg_title,tg_content,tg_date 
									          FROM 
												     tg_article 
									       WHERE
												     tg_reid='{$_html['reid']}'
							          ORDER BY 
												    tg_date ASC 
									        LIMIT 
												   $_pagenum,$_pagesize
			");	
			
	 	}else{
	 		//The user was deleted
	 	}
	}else{
		_alert_back('This post does not exist');
	}						
}else{
	_alert_back('Illegal access');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
<script type="text/javascript"src="js/article.js"></script>
<script type="text/javascript"src="js/code.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="article">
	<h2>Post Detail</h2>
	
	<?php 
		if($_page == 1){
	?>
	<div id="subject">
		<dl>
			<dd class="user"><?php echo $_html['username'];?>(<?php echo $_html['sex'];?>)</dd>
			<dt><img src="<?php echo $_html['face'];?>" alt="<?php echo $_html['username'];?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'];?>">Message</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'];?>">+Friend</a></dd>
			<dd class="guest">Post</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'];?>">Flower</a></dd>
			<dd class="email">Email:<a href="mailto:<?php echo $_html['email'];?>"><?php echo $_html['email'];?></a></dd>
			<dd class="url">URL:<a href="<?php echo $_html['url'];?>" target="_blank"><?php echo $_html['url'];?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php if(isset($_html['subject_modify'])) {echo $_html['subject_modify'];}?> 1#</span><?php echo $_html['username'];?> | post at:<?php echo $_html['date'];?>
			</div>
			<h3>Topic: <?php echo $_html['title'];?> <img src="images/icon<?php echo $_html['type'];?>.gif"alt="icon"/><?php if(isset($_html['re'])) {echo $_html['re'];}?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content']);?>
				<?php if(isset($_html['autograph_html'])) echo _ubb($_html['autograph_html']);?>
			</div>
			<div class="read">
				<p><?php if(isset($_html['last_modify_date_string'])) {echo $_html['last_modify_date_string'];}?></p>
				Popularity: (<?php echo $_html['readcount'];?>)  Comment:(<?php echo $_html['commentcount'];?>)
			</div>
		</div>
	</div>
	<?php } ?>
	
	<!--disply reply-->
	<p class="line"></p>
		<?php 
			$_i = 2;
			while (!!$_rows = _fetch_array_list($_result)) {
				$_html['username'] = $_rows['tg_username'];
				$_html['type'] = $_rows['tg_type'];
				$_html['retitle'] = $_rows['tg_title'];
				$_html['content'] = $_rows['tg_content'];
				$_html['date'] = $_rows['tg_date'];
				$_html = _html($_html);
				
			if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_sex,
																	tg_profile,
																	tg_email,
																	tg_url, 
																	tg_switch,
																	tg_autograph
														    FROM 
															  		tg_user 
														 WHERE 
																    tg_username='{$_html['username']}'")) {
				//read reply user information
				$_html['userid'] = $_rows['tg_id'];
				$_html['sex'] = $_rows['tg_sex'];
				$_html['face'] = $_rows['tg_profile'];
				$_html['email'] = $_rows['tg_email'];
				$_html['url'] = $_rows['tg_url'];
				$_html['switch'] = $_rows['tg_switch'];
				$_html['autograph'] = $_rows['tg_autograph'];
				$_html = _html($_html);			
			} else {
				//This user was deleted
			}
			
			//reply to a post
			if(isset($_COOKIE['username'])){
				$_html['re'] = '<span>[<a href="#ree"name="re"title="Reply '.($_html['username']).' in '.($_i+(($_page-1)*$_pagesize)).'.#.">Reply</a>]</span>';
			}
		?>
			<div class="re">
		<dl>
			<dd class="user"><?php echo $_html['username'];?>(<?php echo $_html['sex'];?>)</dd>
			<dt><img src="<?php echo $_html['face'];?>" alt="<?php echo $_html['username'];?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'];?>">Message</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'];?>">+Friend</a></dd>
			<dd class="guest">Post</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'];?>">Flower</a></dd>
			<dd class="email">Email:<a href="mailto:<?php echo $_html['email'];?>"><?php echo $_html['email'];?></a></dd>
			<dd class="url">URL:<a href="<?php echo $_html['url'];?>" target="_blank"><?php echo $_html['url'];?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_i+(($_page-1)*$_pagesize);?>#</span><?php echo $_html['username'];?> | post at:<?php echo $_html['date'];?>
			</div>
			<h3>Topic: <?php echo $_html['retitle'];?> <img src="images/icon<?php echo $_html['type'];?>.gif"alt="icon"/><?php if(isset($_html['re'])) {echo $_html['re'];}?></h3>
			<div class="detail">
				<?php echo _ubb($_html['content']);?>
				<?php 
					if ($_html['switch'] == 1) {
						echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
				}
				?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php 
			$_i++;
			} 
		_free_result($_result);
		_paging(1);
	?>
	
	
	
	
	<?php if(isset($_COOKIE['username'])){?>
	<a name="ree"></a>
	<form method="post"action="?action=rearticle">
		<input type="hidden" name="reid"value="<?php echo $_html['reid'];?>"/>
		<input type="hidden" name="type"value="<?php echo $_html['type'];?>"/>
		<dl>
			<dd>Title:<input type="text" name="title" class="text"value="RE:<?php echo $_html['title'];?>"/>(*Two words)</dd>
			<dd id="q">Expression:<?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[1]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[2]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content"rows="9"></textarea>
			</dd>
			<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
			<dd><input type="submit" class="submit" value="Post" /></dd>
		</dl>
	</form>
	<?php } ?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


