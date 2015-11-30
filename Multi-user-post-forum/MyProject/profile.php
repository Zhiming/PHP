<?php

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//a constant for different scripts calling
define("SCRIPT","profile");

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/CssLoad.inc.php';
?>
<script type="text/javascript"src="js/opener.js"></script>
</head>
<body>
<div id="profile">
	<h3>Choose a profile</h3>
	<dl>
		<?php foreach (range(1,8) as $num) {?>
		<dd><img src="profile/profile<?php echo $num?>.jpg" alt="profile/profile<?php echo $num?>.jpg" title="profile<?php echo $num?>" /></dd>
		<?php }?>
	</dl>
</div>
</body>
</html>