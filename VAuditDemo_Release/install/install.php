<?php

if ( file_exists($_SERVER["DOCUMENT_ROOT"].'/sys/install.lock') ) {
	header( "Location: ../index.php" );
	exit;
}

require_once '../header.php';

function check_writeable( $file ) {
	if ( file_exists( $file ) ) {
		if ( is_dir( $file ) ) {
			$dir = $file;
			if ( $fp = @fopen( "$dir/test.txt", 'w' ) ) {
				@fclose( $fp );
				@unlink( "$dir/test.txt" );
				$writeable = 1;
			}
			else {
				$writeable = 0;
			}
		}
		else {
			if ( $fp = @fopen( $file, 'a+' ) ) {
				@fclose( $fp );
				$writeable = 1;
			}
			else {
				$writeable = 0;
			}
		}
	}
	else {
		$writeable = 2;
	}
	return $writeable;
}

$sys_info['mysql_ver']     = extension_loaded( 'mysql' ) ? 'OK' : 'NO';
$sys_info['zlib']          = function_exists( 'gzclose' ) ? 'OK' : 'NO';
$sys_info['gd']            = extension_loaded( "gd" ) ? 'OK' : 'NO';
$sys_info['socket']        = function_exists( 'fsockopen' ) ? 'OK' : 'NO';
$sys_info['curl_init']        = function_exists( 'curl_init' ) ? 'OK' : 'NO';

echo '<div id="ourhp_er">';
echo '<h1>系統環境</h1>';
echo '<p>服務器操作系統:&nbsp;....................................................................&nbsp;'.PHP_OS.'</p>';
echo '<p>Web 服務器:&nbsp;....................................................&nbsp;'.$_SERVER['SERVER_SOFTWARE'].'</p>';
echo '<p>PHP 版本:&nbsp;....................................................................&nbsp;'.PHP_VERSION.'</p>';
echo '<p>MySQL 版本:&nbsp;....................................................................&nbsp;'.$sys_info['mysql_ver'].'</p>';
echo '<p>Zlib 支持:&nbsp;....................................................................&nbsp;'.$sys_info['zlib'].'</p>';
echo '<p>GD2 支持:&nbsp;....................................................................&nbsp;'.$sys_info['gd'].'</p>';
echo '<p>Socket 支持:&nbsp;....................................................................&nbsp;'.$sys_info['socket'].'</p>';
echo '<p>curl 支持:&nbsp;....................................................................&nbsp;'.$sys_info['curl_init'].'</p>';
echo '<h1>目錄權限</h1>';

/* 检查目录 */
$check_dirs = array (
	'../sys',
	'../uploads'
);

$i = 0;
foreach ( $check_dirs as $dir ) {
	$full_dir = $dir;
	$check_writeable = check_writeable( $full_dir );
	if ( $check_writeable == '1' ) {
		echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<font color='#00CC33'>可寫</font></p>";
	}
	elseif ( $check_writeable == '0' ) {
		echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<font color='#ff0000'>不可寫</font></p>";
		$no_write = true;
	}
	elseif ( $check_writeable == '2' ) {
		echo "<p>".$check_dirs[$i]."&nbsp;...................................................................&nbsp;<b>不存在</b></p>";
		$no_write = true;
	}
	$i = $i + 1;
}

if ( $sys_info['gd'] == 'NO' || $sys_info['curl_init'] == 'NO' ) {
	exit( '組建不支持，無法安裝使用！' );
}else if ( $check_writeable == '0' || $check_writeable == '2' ) {
	exit( '關鍵目錄不可寫，無法安裝使用！' );
}

if ( $_POST ) {

	if ( $_POST["dbhost"] == "" ) {
		exit( '数据库连接地址不能为空' );
	}elseif ( $_POST["dbuser"] == "" ) {
		exit( '数据库数据库登录名' );
	}elseif ( $_POST["dbname"] == "" ) {
		exit( '请先创建数据库名称' );
	}

	$dbhost = $_POST["dbhost"];
	$dbuser = $_POST["dbuser"];
	$dbpass = $_POST["dbpass"];
	$dbname = $_POST["dbname"];

	$con = mysql_connect( $dbhost, $dbuser, $dbpass );
	if ( !$con ) {
		die( '数据库链接出错，请检查账号密码及地址是否正确: ' . mysql_error() );
	}

	$result = mysql_query('show databases;') or die ( mysql_error() );;
	While($row = mysql_fetch_assoc($result)){       
		$data[] = $row['Database'];
	}
	unset($result, $row);
	if (in_array(strtolower($dbname), $data)){
		mysql_close();
		echo "<script>if(!alert('數據庫已存在')){window.history.back(-1);}</script>";
		exit();
	}

	// exp;-- -";phpinfo();//

	mysql_query( "CREATE DATABASE $dbname", $con ) or die ( mysql_error() );

	$str_tmp="<?php\r\n";
	$str_end="?>";
	$str_tmp.="\r\n";
	$str_tmp.="error_reporting(0);\r\n";
	$str_tmp.="\r\n";
	$str_tmp.="if (!file_exists(\$_SERVER[\"DOCUMENT_ROOT\"].'/sys/install.lock')){\r\n\theader(\"Location: /install/install.php\");\r\nexit;\r\n}\r\n";
	$str_tmp.="\r\n";
	$str_tmp.="include_once('../sys/lib.php');\r\n";
	$str_tmp.="\r\n";
	$str_tmp.="\$host=\"$dbhost\"; \r\n";
	$str_tmp.="\$username=\"$dbuser\"; \r\n";
	$str_tmp.="\$password=\"$dbpass\"; \r\n";
	$str_tmp.="\$database=\"$dbname\"; \r\n";
	$str_tmp.="\r\n";
	$str_tmp.="\$conn = mysql_connect(\$host,\$username,\$password);\r\n";
	$str_tmp.="mysql_query('set names utf8',\$conn);\r\n";
	$str_tmp.="mysql_select_db(\$database, \$conn) or die(mysql_error());\r\n";
	$str_tmp.="if (!\$conn)\r\n";
	$str_tmp.="{\r\n";
	$str_tmp.="\tdie('Could not connect: ' . mysql_error());\r\n";
	$str_tmp.="\texit;\r\n";
	$str_tmp.="}\r\n";
	$str_tmp.="\r\n";
	$str_tmp.="session_start();\r\n";
	$str_tmp.="\r\n";
	$str_tmp.=$str_end;

	$fp=fopen( "../sys/config.php", "w" );
	fwrite( $fp, $str_tmp );
	fclose( $fp );

	//创建表
	mysql_select_db( $dbname, $con );
	mysql_query( "set names 'utf8'", $con );
	//导入数据库
	$sql=file_get_contents( "install.sql" );
	$a=explode( ";", $sql );
	foreach ( $a as $b ) {
		mysql_query( $b.";" );
	}
	mysql_close( $con );
	file_put_contents($_SERVER["DOCUMENT_ROOT"].'/sys/install.lock', 'virink');
	echo "<script>if(!alert('安裝成功')){window.location.href='../index.php';}</script>";
	exit;
}else {
	echo "<form id='form1' name='form1' method='post' action=''>";
	echo "<table width='100%' border='0' align='center' cellpadding='10' id='table'>";
	echo "<tr>";
	echo "<td colspan='2'><h1></h1></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>數據庫连接地址：</div></td>";
	echo "<td><input name='dbhost' type='text' id='input' value='localhost'/> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>數據庫登錄名：</div></td>";
	echo "<td><input name='dbuser' type='text' id='input' value='root'/> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>數據庫登錄密碼：</div></td>";
	echo "<td><input name='dbpass' type='password' id='input' value='root'/> *</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><div align='right'>創建數據庫名稱：</div></td>";
	echo "<td><input name='dbname' type='text' id='input' value='vauditdemo'/> *</td> ";
	echo "</tr>";
	echo "<tr>";
	echo "<td></td>";
	echo "<td><input type='submit' class='btn' name='Submit' value='安裝' /></td>";
	echo "</tr>";
	echo "</table>";
	echo "</form>";
}
?>


<?php
require_once '../footer.php';
?>
