<?php 
include_once('../sys/config.php');

if (isset($_SESSION['admin'])) {
	include_once('../header.php');

	
?>
<div class="span10">
	<div id="content">
		<div class="page-header">
			<h4>Ping</h4>
			<hr>
			<form name="ping" action="" method="post">
				<input type="text" name="target" size="30" class="form-control">
				<input type="submit" value="Ping" name="submit" class="btn btn-primary">
			</form>
			<?php
			if( isset( $_POST[ 'submit' ] ) ) {
				$target = $_POST[ 'target' ];

				if(preg_match('/^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$|^((25[0-5]|2[0-4]\d|[01]?\d\d?)($|(?!\.$)\.)){4}$/',$target)){
					if (stristr(php_uname('s'), 'Windows NT')) { 
						$cmd = 'ping ' . $target;
					} else { 
						$cmd = 'ping -c 3 ' . $target;
					}
					$res = shell_exec( $cmd );
					echo "<br /><pre>$cmd\r\n".iconv('GB2312', 'UTF-8',$res)."</pre>";
				}else{
					echo "IP is error";
				}
			}
			?>
		</div>
	</div>
</div>


<a href="manage.php">返回</a>
	<?php 
	require_once('../footer.php');
	}
else {
	not_find($_SERVER['PHP_SELF']);
}
 ?>
