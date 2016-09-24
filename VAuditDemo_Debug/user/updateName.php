<?php
include_once('../sys/config.php');
if (isset($_POST['submit']) && !empty($_POST['username']) ) {

	if (strlen($_POST['username'])>16) {
		$_SESSION['error_info'] = '用户名過長（用戶名長度<=16）';
		header('Location: edit.php');
		exit;
	}

	$clean_username = clean_input($_POST['username']);
	$clean_user_id = clean_input($_POST['id']);
	
	//判断用户名已是否存在
	$query = "SELECT * FROM users WHERE user_name = '$clean_username'";
    $data = mysql_query($query, $conn);
	if (mysql_num_rows($data) == 1) {
		$_SESSION['error_info'] = '用户名已存在';
		header('Location: edit.php');
		exit;
	}
	
	$query = "UPDATE users SET user_name = '$clean_username' WHERE user_id = '$clean_user_id'";
	mysql_query($query, $conn) or die("update error!");
	mysql_close($conn);
	//刷新缓存
	$_SESSION['username'] = $clean_username;
	header('Location: edit.php');
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>