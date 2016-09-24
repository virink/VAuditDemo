<?php
include_once '../sys/config.php';

if ( isset( $_SESSION['username'] ) ) {

	include_once '../header.php';

	if ( !isset( $SESSION['user_id'] ) ) {
		$query = "SELECT * FROM users WHERE user_name = '{$_SESSION['username']}'";
		$data = mysql_query( $query, $conn ) or die( 'Error!!' );
		mysql_close( $conn );
		$result = mysql_fetch_array( $data );
		$_SESSION['user_id'] = $result['user_id'];
	}

	$html_avatar = htmlspecialchars( $_SESSION['avatar'] );
?>
<div class="row">
	<div style="float:left;">
		<img src="avatar.php" width="100" height="100" class="img-thumbnail" >
		<div class="text-center"><?php echo $_SESSION['username']?></div>
	</div>

	<div style="float:right;padding-right:900px">
		<div><a href="logout.php"><button type="button" class="btn btn-primary">退出</button></a></div>
		<br />
		<div><a href="edit.php"><button type="button" class="btn btn-primary">编辑</button></a></div>
		<br />
		<div><a href="../message.php"><button type="button" class="btn btn-primary">发留言</button></a></div><br /><br /><br /><br />
	</div>
</div>
<?php
	require_once '../footer.php';
}
else {
	not_find( $_SERVER['PHP_SELF'] );
}
?>
