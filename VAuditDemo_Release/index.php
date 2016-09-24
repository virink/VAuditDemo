<?php 
require_once('sys/config.php');
require_once('header.php');
?>
<div class="row">
	<?php
	$m = array('about','xxx');
	/* Include */
	if (isset($_GET['module'])){
		$a = $_GET['module'];
		if(in_array($a, $m))
			include('./'.$_GET['module'].'.inc');
		else
			exit('include error');
		// phar://uploads/u_1470339033_v.png/v.inc
	}else{
	?>
	<div class="jumbotron" style="text-align: center;">
		<h1><b>VAuditDemo</b></h1>
		<p>一个简单的Web漏洞演练平台</p><br />
	</div>
	<div class="col-lg-12">
		<h2>用於演示講解PHP基本漏洞</h2>
		<p></p>
	</div>
	<?php
	}
	?>
</div>
		
<?php
require_once('footer.php');
?>
