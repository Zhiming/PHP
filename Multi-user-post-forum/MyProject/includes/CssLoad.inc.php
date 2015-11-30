<?php
//protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//Only HTML could call it
if(!defined('SCRIPT')){
	exit('Script Error');
}
global $_system;
?>
<title><?php echo $_system['webname'];?></title>
<link rel="stylesheet" type="text/css" href="styles/<?php echo $_system['skin'];?>/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/<?php echo $_system['skin'];?>/<?php echo SCRIPT?>.css" />
