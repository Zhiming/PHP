<?php

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","q");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//inicialize expression
if(isset($_GET['num'])&&isset($_GET['path'])){
	if(!is_dir(ROOT_PATH.$_GET['path'])){
		_alert_back('Illegal access');
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
<script type="text/javascript"src="js/qopener.js"></script>
</head>
<body>
<div id="q">
	<h3>Choose a expression</h3>
	<dl>
		<?php foreach (range(1,$_GET['num']) as $_num) {?>
		<dd><img src="<?php echo $_GET['path'].$_num;?>.gif" alt="<?php echo $_GET['path'].$_num;?>.gif" title="<?php echo $_GET['path'].$_num;?>.gif"/></dd>
		<?php }?>
	</dl>
</div>
</body>
</html>