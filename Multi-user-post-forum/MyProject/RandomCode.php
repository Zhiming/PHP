<?php
if(!isset($_SESSION)){
	session_start();
}

//No illegal access
define('IN_TG',true);


//include the common file
require dirname(__FILE__).'/includes/common.inc.php'; //absolute path

//Generate a random code
//the default size of code is 75*75, 4 digits, 4th parameter for black
//border, if needed, set it 1.
_RandCode();

?>