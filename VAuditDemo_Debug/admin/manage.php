<?php 
include_once($_SERVER["DOCUMENT_ROOT"].'/sys/config.php');

if (isset($_SESSION['admin'])) {
	include_once($_SERVER["DOCUMENT_ROOT"].'/header.php');
?>
	<table class="items table">
	<thead>
	<tr>
	<th id="yw0_c0">管理</th>
	<th id="yw0_c1">入口</th>
	</thead>
	<tbody>
		<tr class="odd">
			<td>管理員</td>
			<td><a href="manageAdmin.php">进入</a></td>
		</tr>
		<tr class="odd">
			<td>用户</td>
			<td><a href="manageUser.php">进入</a></td>
		</tr>
		<tr class="odd">
			<td>评论</td>
			<td><a href="manageCom.php">进入</a></td>
		</tr>
		<tr class="odd">
			<td>Ping</td>
			<td><a href="ping.php">进入</a></td>
		</tr>
	</tbody>
	</table>
	<?php
	require_once($_SERVER["DOCUMENT_ROOT"].'/footer.php');
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>
