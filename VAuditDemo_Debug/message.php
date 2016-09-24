<?php
require_once('sys/config.php');
require_once('header.php');

$query = "SELECT * FROM comment ORDER BY comment_id";
$data = mysql_query($query, $conn) or die('Error!!');
mysql_close($conn);
?>
<div class="bs-example table-responsive">
	<table class="table table-striped table-hover ">
	<tr>
		<th>#</th>
		<th>Column heading</th>
	</tr>
<?php
while($com = mysql_fetch_array($data)) {
	$html['username'] = htmlspecialchars($com['user_name']);
	$html['comment_text'] = htmlspecialchars($com['comment_text']);
	
	echo '<tr>';
	echo '<td>'.$html['username'].'</td>';
	echo '<td><a href="messageDetail.php?id='.$com['comment_id'].'">'.$html['comment_text'].'</td></a>';
	echo '</tr>';
}
?>
</table>
</div>
<?php 
if (isset($_SESSION['username']))
{?>
<form action="messageSub.php" method="post" name="message">
	<div class="col-lg-10">
        <textarea class="form-control" rows="3" id="textArea" name="message"></textarea>
    </div>
    <input type="submit" name="submit" value="留言"/>
	<a href="user/user.php">返回</a><br /><br /><br /><br /><br />
</form>

<?php 
}

require_once('footer.php');
?>