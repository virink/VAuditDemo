<?php
include_once('../sys/config.php');

if (isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
	include_once('../header.php');

	if(@$_POST['captcha'] !== $_SESSION['captcha']){
		header('Location: login.php');
		exit;
	}

	$name = $_POST['user'];
	$pass = $_POST['pass'];

    $query = "SELECT * FROM admin WHERE admin_name = '$name' AND admin_pass = SHA('$pass')";
    $data = mysql_query($query, $conn) or die('Error!!');

    if (mysql_num_rows($data) == 1) {
		$_SESSION['admin'] = $name;
        header('Location: manage.php');
        }
	else {
		$_SESSION['error_info'] = '用户名或密码错误';
		header('Location: login.php');
	}
	mysql_close($conn);
}
else {
	not_find($_SERVER['PHP_SELF']);
}
?>
