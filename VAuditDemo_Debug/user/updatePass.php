<?php
include_once('../sys/config.php');

if (!empty($_GET['passwd'])) {
	$clean_passwd = clean_input($_GET['passwd']);
	
	$query = "UPDATE users SET user_pass = SHA('$clean_passwd') WHERE user_id = '{$_SESSION['user_id']}'";
	mysql_query($query, $conn) or die("update error!");
	mysql_close($conn);
	header('Location: edit.php');
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>