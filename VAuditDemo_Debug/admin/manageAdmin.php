<?php 
include_once('../sys/config.php');

if (isset($_SESSION['admin'])) {
	include_once('../header.php');

	if(isset($_POST['username']) && isset($_POST['password'])){
		$clean_name = clean_input($_POST['username']);
		$clean_pass = clean_input($_POST['password']);
		$query = "SELECT * FROM admin WHERE admin_name = '$clean_name'";
	    $data = mysql_query($query, $conn);
		if (mysql_num_rows($data) == 1) {
			$_SESSION['error_info'] = '用户名已存在';
			header('Location: manageUser.php');
			exit;
		} else {
			$query = "INSERT INTO admin(admin_name,admin_pass) VALUES ('$clean_name',SHA('$clean_pass'))";
			mysql_query($query, $conn) or die("Error!!");
		}
	}

	$query = "SELECT * FROM admin ORDER BY admin_id";
	$data = mysql_query($query, $conn) or die('Error');
	mysql_close($conn);
?>
<table class="items table">
	<thead>
	<tr>
		<th id="yw0_c0">Name</th>
		<th id="yw0_c4">Manege</th>
	</thead>
	<tbody>
<?php while ($admin = mysql_fetch_array($data)) {
	$html_user_name = htmlspecialchars($admin['admin_name']);
?>
	<tr class="odd">
		<td><?php echo $html_user_name;?></td>
		<td><a href="delUser.php?id=<?php echo $admin['user_id'];?>">删除</a></td>
	</tr>
<?php } ?>
</tbody>
</table>

<form class="bs-example form-horizontal" action="manageAdmin.php" method="post" name="log">
	<legend>添加管理員</legend>
    <div class="form-group">
        <label for="inputEmail" class="col-lg-2 control-label">用户名：</label>
        <div class="col-lg-3">
            <input type="text" name="username" class="form-control" id="inputEmail">
        </div>
	</div>
	<div class="form-group">
		<label for="inputEmail" class="col-lg-2 control-label">密码：</label>
        <div class="col-lg-3">
			<input type="password" name="password" class="form-control" id="inputEmail" onblur="check()">
        </div>
		<div><input type="submit" name="submit" class="btn btn-primary" value="添加"/></div>
    </div>				  
</form>

<a href="manage.php">返回</a>
<?php 
require_once('../footer.php');
}
else {
	not_find($_SERVER['PHP_SELF']);
}
 ?>