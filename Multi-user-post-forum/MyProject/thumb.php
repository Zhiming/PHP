<?php

define('IN_TG',true);

define('SCRIPT','thumb');

require dirname(__FILE__).'/includes/common.inc.php';

//����ͼ
if (isset($_GET['filename']) && isset($_GET['percent'])) {
	_thumb($_GET['filename'],$_GET['percent']);
}
?>