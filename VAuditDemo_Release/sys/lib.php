<?php

date_default_timezone_set('UTC');

header("Content-type: text/html; charset=utf-8");

if( !get_magic_quotes_gpc() ) {
	$_GET = sec ( $_GET );
	$_POST = sec ( $_POST );
	$_COOKIE = sec ( $_COOKIE ); 
}
$_SERVER = sec ( $_SERVER );

function sec( &$array ) {
	if ( is_array( $array ) ) {
		foreach ( $array as $k => $v ) {
			$array [$k] = sec ( $v );
		}
	} else if ( is_string( $array ) ) {
		$array = addslashes( $array );
	} else if ( is_numeric( $array ) ) {
		$array = intval( $array );
	}
	return $array;
}

/* Maybe bypass */
function sqlwaf( $str ) {
	$str = str_ireplace( "and", "sqlwaf", $str );
	$str = str_ireplace( "or", "sqlwaf", $str );
	$str = str_ireplace( "from", "sqlwaf", $str );
	$str = str_ireplace( "execute", "sqlwaf", $str );
	$str = str_ireplace( "update", "sqlwaf", $str );
	$str = str_ireplace( "count", "sqlwaf", $str );
	$str = str_ireplace( "chr", "sqlwaf", $str );
	$str = str_ireplace( "mid", "sqlwaf", $str );
	$str = str_ireplace( "char", "sqlwaf", $str );
	$str = str_ireplace( "union", "sqlwaf", $str );
	$str = str_ireplace( "select", "sqlwaf", $str );
	$str = str_ireplace( "delete", "sqlwaf", $str );
	$str = str_ireplace( "insert", "sqlwaf", $str );
	$str = str_ireplace( "limit", "sqlwaf", $str );
	$str = str_ireplace( "concat", "sqlwaf", $str );
	$str = str_ireplace( "script", "sqlwaf", $str );
	$str = str_ireplace( "\\", "\\\\", $str );
	$str = str_ireplace( "&&", "sqlwaf", $str ); // sel||ect -> select
	$str = str_ireplace( "||", "sqlwaf", $str );
	$str = str_ireplace( "'", "sqlwaf", $str ); // \' -> \
	$str = str_ireplace( "%", "\%", $str );
	$str = str_ireplace( "_", "\_", $str );
	return $str;
}

/* Maybe Inject */
function get_client_ip(){
	if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}else if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")){
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")){
		$ip = $_SERVER["REMOTE_ADDR"];
	}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
		$ip = $_SERVER['REMOTE_ADDR'];
	}else{
		$ip = "unknown";
	}
	return($ip);
}

function clean_input( $dirty ) {
	return mysql_real_escape_string( stripslashes( $dirty ) );
	// xxx\ -> xxx\\ -> xxx\ -> xxx\\
	// 2016-08-05 6:54	INSERT INTO users(user_name,user_pass,user_avatar,join_date) VALUES ('test\\',SHA('123456'),'../images/default.jpg','2016-08-04')
}

function is_pic( $file_name ) {
	$extend =explode( "." , $file_name );
	$va=count( $extend )-1;
	if ( $extend[$va]=='jpg' || $extend[$va]=='jpeg' || $extend[$va]=='png' ) {
		return 1;
	}
	else
		return 0;
}

function not_find( $page ) {
	echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1>
		<p>The requested URL ".$page." was not found on this server.</p></body></html>";
}
?>
