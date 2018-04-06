<?php
$value = "";
for($i = 0; $i < 20; $i++){
	for($j=0; $j < 100; $j++){
		$value .= $i . ':' . $j . ';';
	}
}

if(!isset($_COOKIE['my_big_cookie'])){
	setcookie('my_big_cookie', $value, strtotime('+1hour'));
	//$_COOKIE['my_big_cookie'] = $value;
}else {
	setcookie('my_big_cookie', '', strtotime('+1hour'));
}

include('./cookie.inc');
