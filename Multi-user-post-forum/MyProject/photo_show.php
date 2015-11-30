<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","photo_show");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//delete a picture
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
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

		//read the uploader of the picture
		if (!!$_rows = _fetch_array("SELECT 
																	tg_username,
																	tg_url,
																	tg_id,
																	tg_sid
														FROM 
																	tg_photo 
													 WHERE 
																	tg_id = '{$_GET['id']}'
														 LIMIT 
																	1"
		)){
			$_html = array();
			$_html['username'] = $_rows['tg_username'];
			$_html['url'] = $_rows['tg_url'];
			$_html['id'] = $_rows['tg_id'];
			$_html['sid'] = $_rows['tg_sid'];
			$_html = _html($_html);
			//validate the delete access
			if($_html['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])) {
				//deleting in database
				_query("DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'");
				if (_affected_rows() == 1) {
					//whether the url exists
					if(file_exists($_html['url'])){
						//deleting the picture physically
						unlink($_html['url']);
					} else{
						_alert_back('This picture does not exist');
					}
					_close();
					_location('Successfully deleted£¡','photo_show.php?id='.$_html['sid']);
				} else {
					_close();
					_alert_back('Fail to delete');
				}
			} else{
				_alert_back('Illegal access');
			}
		} else{
			_alert_back('This picture does not exist');
		}
	} else{
		_alert_back('Illegal access');
	}
}

//receive id
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT 
																	tg_id,tg_name,tg_type
														FROM
																	tg_dir
														WHERE
																	tg_id='{$_GET['id']}'
														LIMIT
																	1
	")) {
			$_dirhtml = array();
			$_dirhtml['id'] = $_rows['tg_id'];
			$_dirhtml['name'] = $_rows['tg_name'];
			$_dirhtml['type'] = $_rows['tg_type'];
			$_dirhtml = _html($_dirhtml);
			//validate information of the Encryption photo album
			if(isset($_POST['password'])){
				if (!!$_rows = _fetch_array("SELECT 
																		tg_id
															FROM
																		tg_dir
															WHERE
																		tg_password='".sha1($_POST['password'])."'
															LIMIT
																		1
				")) {
					  	//password validation
					  	setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
					  	//redirect
						_location(null,'photo_show.php?id='.$_dirhtml['id']);
					  } else{
					  		_alert_back('Wrong Password');
					  }
			}
		} else {
			_alert_back('This album does not exist');
			}
	} else {
		_alert_back('Illegal access');
	}

global $_pagesize,$_pagenum,$_system,$_id;
$_id = 'id='.$_dirhtml['id'].'&';

$_percent = 0.3;
_page("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}'",$_system['photo']);

$_result = _query("select
                                       tg_id,
                                       tg_username,
                                       tg_name,
                                       tg_url,
                                       tg_readcount,
                                       tg_commentcount
                                 from
								       tg_photo
							  where
							           tg_sid='{$_dirhtml['id']}'
						    order by
								       tg_date desc
								 limit
								       $_pagenum,$_pagesize
")
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2><?php echo $_dirhtml['name'];?></h2>
	<?php

		if(empty($_dirhtml['type']) || isset($_SESSION['admin']) || (isset($_COOKIE['photo'.$_dirhtml['id']])&& $_COOKIE['photo'.$_dirhtml['id']] == $_dirhtml['name'])){
	
			$_html = array();
			while (!!$_rows = _fetch_array_list($_result)) {
				$_html['id'] = $_rows['tg_id'];
				$_html['username'] = $_rows['tg_username'];
				$_html['name'] = $_rows['tg_name'];
				$_html['url'] = $_rows['tg_url'];
				$_html['readcount'] = $_rows['tg_readcount'];
				$_html['commentcount'] = $_rows['tg_commentcount'];
				$_html = _html($_html);
	?>
	<dl>
		<dt><a href="photo_detail.php?id=<?php echo $_html['id'];?>"><img src="thumb.php?filename=<?php echo $_html['url'];?>&percent=<?php echo $_percent?>" /></a></dt>
		<dd><a href="photo_detail.php?id=<?php echo $_html['id'];?>"><?php echo $_html['name'];?></a></dd>
		<dd>Picture view(<strong><?php echo $_html['readcount'];?></strong>) Comment(<strong><?php echo $_html['commentcount'];?></strong>)</dd>
		<dd> Uploader: <?php echo $_html['username'];?></dd>
	
		<?php 
			if((isset($_COOKIE['username'])&&$_html['username'] == $_COOKIE['username']) || isset($_SESSION['admin'])) {
		?>
		<dd>[<a href="photo_show.php?action=delete&id=<?php echo $_html['id'];?>">Delete</a>]</dd>
		<?php } ?>
	</dl>
	<?php } 
		_free_result($_result);
		_paging(1);
	?>
		<p><a href="photo_add_img.php?id=<?php if(isset($_dirhtml['id'])) echo $_dirhtml['id'];?>">Update pictures</a></p>

	<?php 
		} else{
			echo '<form method="post" action="photo_show.php?id='.$_dirhtml['id'].'">';
			echo '<p>Please enter the password:<input type="password" name="password" /> <input type="submit" value="Confirm" /></p>';
			echo '</form>';
		}
	?>

</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>