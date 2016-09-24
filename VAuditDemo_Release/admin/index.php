<?php
session_start();
if(isset($_SESSION['admin']))
	header('Location: manage.php');
else
	header('Location: login.php');
?>