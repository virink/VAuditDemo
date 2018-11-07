<?php

error_reporting(0);

if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/sys/install.lock')) {
	header("Location: /install/install.php");
	exit;
}

include_once '../sys/lib.php';

$host = "localhost";
$username = "root";
$password = "root";
$database = "vauditdemo";

$conn = mysql_connect($host, $username, $password);
mysql_query('set names utf8', $conn);
mysql_select_db($database, $conn) or die(mysql_error());
if (!$conn) {
	die('Could not connect: ' . mysql_error());
	exit;
}

session_start();

?>