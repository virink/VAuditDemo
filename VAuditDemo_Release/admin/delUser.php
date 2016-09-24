<?php
include_once('../sys/config.php');

if (isset($_SESSION['admin']) && !empty($_GET['id'])) {

	$clean_id = clean_input($_GET['id']);
	$query = "DELETE FROM users WHERE user_id = '$clean_id' LIMIT 1";
	mysql_query($query, $conn) or die('Error');
	mysql_close($conn);
	header('Location: manageUser.php');
}
else {
	not_find($_SERVER['PHP_SELF']);
}	
?>