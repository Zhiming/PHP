<?php

//protect from illegal access
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

?>

<div id="member_sidebar">
		<h2>Management Guidance</h2>
		<dl>
			<dt>System Management</dt>
			<dd><a href="manage.php">Background Mainpage</a></dd>
			<dd><a href="manage_set.php">System Setting</a></dd>
		</dl>
		<dl>
			<dt>Administrator Management</dt>
			<dd><a href="manage_member.php">Member List</a></dd>
			<dd><a href="manage_job.php">Level Setting</a></dd>
		</dl>
</div>