<?php
$array1=array();
if(isset($GLOBALS['zoushicard'])){
	$card = $GLOBALS['zoushicard'];
	$str= $card['zoushi'];
	$arr= unserialize($str);
	foreach($arr as $key=>$value){
		$array1[]=array($key*1000,$value);
	}
}
echo json_encode($array1);