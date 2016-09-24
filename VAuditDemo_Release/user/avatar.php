<?php
error_reporting(0);
session_start();
header("Content-type:image/jpeg");
echo file_get_contents($_SESSION['avatar']);// LFR SSRF
?> 
