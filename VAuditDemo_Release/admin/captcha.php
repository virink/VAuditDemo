<?php
session_start();
$rand = '';
for($i=0; $i<4; $i++){
	$rand.= dechex(rand(1,15));
}
$_SESSION['captcha']=$rand;
$im = imagecreatetruecolor(100,30);
$bg=imagecolorallocate($im,0,0,0);
$te=imagecolorallocate($im,255,255,255);
imagestring($im,rand(5,6),rand(25,30),5,$rand,$te);
header("Content-type:image/jpeg");
imagejpeg($im);
?> 