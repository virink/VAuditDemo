<?php
include_once 'sys/config.php';
include_once 'header.php';

if ( !empty( $_GET['search'] ) ) {
	$query = "SELECT * FROM comment WHERE comment_text LIKE '%{$_GET['search']}%'";
	$data = mysql_query($query, $conn);
?>
<div class="bs-example table-responsive">
	<?php echo 'The result for [ '.$_GET['search'].' ] is:'?>
	<table class="table table-striped table-hover ">
	<tr>
		<th>#</th>
		<th>Column heading</th>
	</tr>
	<?php
	while ( $com = mysql_fetch_array( $data ) ) {
		//净化输出变量
		$html['username'] = htmlspecialchars( $com['user_name'] );
		$html['comment_text'] = htmlspecialchars( $com['comment_text'] );

		echo '<tr>';
		echo '<td>'.$html['username'].'</td>';
		echo '<td><a href="messageDetail.php?id='.$com['comment_id'].'">'.$html['comment_text'].'</a></td>';
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
