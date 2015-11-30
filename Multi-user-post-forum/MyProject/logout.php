<?php

if(!isset($_SESSION)){
	session_start();
}

//define the constant IN_TG to include common.inc.php
define('IN_TG',true);

//include common.inc.php
require dirname(__FILE__).'/includes/common.inc.php';

//logout
_unsetcookies();

?>