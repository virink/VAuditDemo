<?php
include_once 'sys/config.php';
include_once 'header.php';

if ( !empty( $_GET['id'] ) ) {
	$id = sqlwaf( $_GET['id'] );
	$query = "SELECT * FROM comment WHERE comment_id = $id";
	$data = mysql_query( $query, $conn ) or print_r(mysql_error());
?>
<div class="bs-example table-responsive">
	<?php echo 'The result for ['.$id.'] is:'?>
	<table class="table table-striped table-hover ">
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Content</th>
		<th>Date</th>
	</tr>
	<?php
	while ( $com = mysql_fetch_array( $data ) ) {

		$html['username'] = htmlspecialchars( $com['user_name'] );
		$html['comment_text'] = htmlspecialchars( $com['comment_text'] );

		echo '<tr>';
		echo '<td>'.$com['comment_id'].'</td>';
		echo '<td>'.$html['username'].'</td>';
		echo '<td>'.$html['comment_text'].'</td>';
		echo '<td>'.$com['pub_date'].'</td>';
		echo '</tr>';
	}
?>
	</table>
</div>
	<?php
	if ( isset( $_SESSION['username'] ) ) {
	?>
	<form action="messageSub.php" method="post" name="message">
		<div class="col-lg-10">
	        <textarea class="form-control" rows="3" id="textArea" name="message"></textarea>
	    </div>
	    <input type="submit" name="submit" value="留言"/>
	</form>
	<a href="user/user.php">返回</a><br /><br /><br /><br /><br />
	<?php
	}
}
require_once 'footer.php';
?>
