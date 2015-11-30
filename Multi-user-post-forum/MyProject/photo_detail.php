<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","photo_detail");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//comment
if(isset($_GET['action'])&&$_GET['action']=='rephoto'){
	//protect from illegal registration	
	_check_code($_POST['code'],$_SESSION['RandCode']);
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
			//receive data
			$_clean = array();
			$_clean['sid'] = $_POST['sid'];
			$_clean['title'] = $_POST['title'];
			$_clean['content'] = $_POST['content'];
			$_clean['username'] = $_COOKIE['username'];
			$_clean = _mysql_string($_clean);
			
			//write into database
			_query("INSERT INTO tg_photo_comment (
																	tg_sid,
																	tg_username,
																	tg_title,
																	tg_content,
																	tg_date
																)
												 VALUES (
												 					'{$_clean['sid']}',
												 					'{$_clean['username']}',
												 					'{$_clean['title']}',
												 					'{$_clean['content']}',
												 					NOW()
												 				)"
			);
			if (_affected_rows() == 1) {
				_query("UPDATE 
				                         tg_photo 
				                    SET 
				                         tg_commentcount=tg_commentcount+1 
				               WHERE 
				                         tg_id='{$_clean['sid']}'");
				_close();
				_location('Successfully post£¡','photo_detail.php?id='.$_clean['sid']);
			} else {
				_close();
				_alert_back('Fail to post');
			}
		} else{
			_alert_back('Illegal access');
		}
}

//receive id
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,
																	tg_name,
																	tg_sid,
																	tg_url,
																	tg_username,
																	tg_readcount,
																	tg_commentcount,
																	tg_date,
																	tg_content
														FROM
																	tg_photo
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
		
		 //protect from changing ID to access Encryption album
		 $_dirs = _fetch_array("SELECT 
			                                                      tg_type,tg_id,tg_name 
			                                               FROM 
			                                                      tg_dir 
			                                            WHERE 
			                                                      tg_id='{$_rows['tg_sid']}'");
		if (!isset($_SESSION['admin'])) {
			if (!!$_dirs) {
				if ( !empty($_dirs['tg_type']) && (!isset($_COOKIE['photo'.$_rows['tg_sid']]) || $_COOKIE['photo'.$_rows['tg_sid']] != $_dirs['tg_name'])) {
					_alert_back('Illegal access');
				}
			} else {
				_alert_back('Album directory error');
			}
		}
		
		//picture view
		_query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	
		$_html = array();
		$_html['id'] = $_rows['tg_id'];
		$_html['sid'] = $_rows['tg_sid'];
		$_html['name'] = $_rows['tg_name'];
		$_html['url'] = $_rows['tg_url'];
		$_html['username'] = $_rows['tg_username'];
		$_html['readcount'] = $_rows['tg_readcount'];
		$_html['commentcount'] = $_rows['tg_commentcount'];
		$_html['date'] = $_rows['tg_date'];
		$_html['content'] = $_rows['tg_content'];
		//echo $_html['url'];
		$_html = _html($_html);
		
		
		//paging with id as a parameter
		global $_id;
		$_id = 'id='.$_html['id'].'&';
	
		
		//read comment
		global $_pagesize,$_pagenum,$_page,$_page;
		_page("SELECT tg_id FROM tg_photo_comment WHERE tg_sid='{$_html['id']}'",10); 
		
		$_result = _query("SELECT 
											     tg_username,
											     tg_title,
											     tg_content,
											     tg_date
								          FROM 
											     tg_photo_comment
								       WHERE
											     tg_sid='{$_html['id']}'
						          ORDER BY 
											    tg_date ASC 
								        LIMIT 
											   $_pagenum,$_pagesize
		");	
		
		
		//previous page, obtaining the smallest id which is bigger than $_html['id]
		$_html['preid'] = _fetch_array("SELECT 
																			min(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id>'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['preid']['id'])) {
			$_html['pre'] = '<a href="photo_detail.php?id='.$_html['preid']['id'].'#pre">Prev Page</a>';
		} else {
			$_html['pre'] = '<span></span>';
		}
		
		//next page, obtaining the biggest id which is smaller than $_html['id']
		$_html['nextid'] = _fetch_array("SELECT 
																			max(tg_id) 
																	AS 
																			id 
																FROM 
																			tg_photo 
															WHERE 
																			tg_sid='{$_html['sid']}' 
																	AND 
																			tg_id<'{$_html['id']}'
																LIMIT
																			1
		");
		
		if (!empty($_html['nextid']['id'])) {
			$_html['next'] = '<a href="photo_detail.php?id='.$_html['nextid']['id'].'#next">Next Page</a>';
		} else {
			$_html['next'] = '<span></span>';
		}
		
		
	} else {
		_alert_back('This picture does not exist');
	}
} else {
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

<div id="photo">
	<h2>Picture detail</h2>
	<a name="pre"></a><a name="next"></a>
	<dl class="detail">
		<dd class="name"><?php echo $_html['name'];?></dd>
		<dt><?php echo $_html['pre'];?><img src="<?php echo $_html['url']?>" /><?php echo $_html['next']?></dt>
		<dd>[<a href="photo_show.php?id=<?php echo $_html['sid'];?>">Return</a>]</dd>
		<dd>Picture view(<strong><?php echo $_html['readcount'];?></strong>) Comment(<strong><?php echo $_html['commentcount'];?></strong>) Uploader:<?php echo $_html['username'];?> Upload date:<?php echo $_html['date'];?></dd>
		<dd>Description:<?php echo $_html['content']?></dd>
	</dl>
	
	
	<?php 
	
		$_i = 1;
			while (!!$_rows = _fetch_array_list($_result)) {
				$_html['username'] = $_rows['tg_username'];
				$_html['retitle'] = $_rows['tg_title'];
				$_html['content'] = $_rows['tg_content'];
				$_html['date'] = $_rows['tg_date'];
				$_html = _html($_html);
	
				//user information
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
	?>
	
	<p class="line"></p>
	
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
			<h3>Topic: <?php echo $_html['retitle'];?></h3>
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
	
	<?php 
			$_i++;
		} 
		_free_result($_result);
		_paging(1);
	?>
	
	
	<?php if(isset($_COOKIE['username'])){?>
	<p class="line"></p>
		<form method="post"action="?action=rephoto">
			<input type="hidden" name="sid"value="<?php echo $_html['id'];?>"/>
			<dl class="rephoto">
				<dd>Title:<input type="text" name="title" class="text"value="RE:<?php echo $_html['name'];?>"/>(*Two words)</dd>
				<dd id="q">Expression:<?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[1]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[2]</a><?php echo'&nbsp&nbsp';?><a href="javascript:;">Collect[3]</a></dd>
				<dd>
					<?php include ROOT_PATH.'includes/ubb.inc.php'?>
					<textarea name="content"rows="9"></textarea>
				</dd>
				<dd>Identifying code:<input type="text" name="code" class="text yzm"  /><img src = "Randomcode.php" id="RandCode"/></dd>
				<dd><input type="submit" class="submit" value="Post" /></dd>
			</dl>
		</form>
		<?php	}?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>