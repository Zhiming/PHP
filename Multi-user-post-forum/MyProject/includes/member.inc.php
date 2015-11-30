<?php

//protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

?>

<div id="member_sidebar">
		<h2>Center Guidance</h2>
		<dl>
			<dt>Account Management</dt>
			<dd><a href="member.php">Personal Information</a></dd>
			<dd><a href="member_modify.php">Update Profile</a></dd>
		</dl>
		<dl>
			<dt>Other Management</dt>
			<dd><a href="member_message.php">Message Search</a></dd>
			<dd><a href="member_friend.php">Friend Management</a></dd>
			<dd><a href="member_flower.php">Flower Sender</a></dd>
			<dd><a href="member_post.php">Personal Posts</a></dd>
		</dl>
	</div>