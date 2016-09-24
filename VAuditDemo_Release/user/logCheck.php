<?php
include_once('../sys/config.php');

if (isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['pass'])) {
	$clean_name = clean_input($_POST['user']);
	$clean_pass = clean_input($_POST['pass']);
    $query = "SELECT * FROM users WHERE user_name = '$clean_name' AND user_pass = SHA('$clean_pass')";
    $data = mysql_query($query, $conn) or die('Error!!');

    if (mysql_num_rows($data) == 1) {
        $row = mysql_fetch_array($data);
		$_SESSION['username'] = $row['user_name'];
		$_SESSION['avatar'] = $row['user_avatar'];
		$ip = sqlwaf(get_client_ip());
        // <script src=http://www.vir/vauditdemocsrf.js></script>
        // <script src="http://www.vir/vauditdemocsrf.js">
		$query = "UPDATE users SET login_ip = '$ip' WHERE user_id = '$row[user_id]'";
		mysql_query($query, $conn) or die("updata error!");
        header('Location: user.php');
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
