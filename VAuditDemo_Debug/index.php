<?php 
require_once('sys/config.php');
require_once('header.php');
?>
<div class="row">
	<?php
	/* Include */
	if (isset($_GET['module'])){
		include($_GET['module'].'.inc');
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
