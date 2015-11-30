<?php

//protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}
?>
<script type="text/javascript" src="js/skin.js"></script>
<div id="header">
	<h1><a href="index.php">Multi-Users Forum</a></h1>
	<ul>
		<li><a href = "index.php">Main Page</a></li>
		<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="member.php">'.$_COOKIE['username'].'\'s Personal Center</a>'.$GLOBALS['message'].'</li>';
				echo "\n";
			} else {	
				echo '<li><a href="register.php">Register</a></li>';
				echo "\n";
				echo "\t\t";
				echo '<li><a href="login.php">Login</a></li>';
				echo "\n";
			}
		?>
		<li><a href="blog.php">Blog Friends</a></li>
		<li><a href="photo.php">Albums</a></li>
		<li class="skin" onmouseover='inskin()' onmouseout='outskin()'>
			<a href="javascript:;">Style</a>
			<dl id="skin">
				<dd><a href="skin.php?id=1">No.1 skin</a></dd>
				<dd><a href="skin.php?id=2">No.2 skin</a></dd>
				<dd><a href="skin.php?id=3">No.3 skin</a></dd>
			</dl>
		</li>
		<?php 
			if(isset($_COOKIE['username'])&&isset($_SESSION['admin'])){
				echo'<li><a href="manage.php"class="manage">Manage</a></li> ';
			}
		
			if (isset($_COOKIE['username'])){
				echo '<li><a href="logout.php">Logout</a></li>';
			}
		?>
	</ul>
</div>