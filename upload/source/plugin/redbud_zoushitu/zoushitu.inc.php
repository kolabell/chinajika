<?php
//include 'global.inc.php';
$path = "/upload/source/plugin/redbud_zoushitu";




$sql = "select * from ".DB::table('plugin_zoushitu')." where 1";
$query = DB::query($sql);
$cardnames=array();
$cardid = null;
$card = null;
$json_zoushi=null;

while ($res = DB::fetch($query)) {
	if(isset($_GET['cardid']) && is_numeric($_GET['cardid'])){
		$cardid = $_GET['cardid'];
		if($_GET['cardid'] == $res['id']){
			$card = $res;
		}
	}else{
		if(!isset($mark)){
			$mark = 1;
			$cardid= $res['id'];
			$card = $res;
		}
	}
	$cardnames[$res['id']] = $res['mingcheng'];
}

if(isset($card)){
	$zoushistr = $card['zoushi'];
	$arr= unserialize($zoushistr);
	foreach($arr as $key=>$value){
		$array1[]=array($key*1000,$value);
	}
	$json_zoushi = json_encode($array1);
}


/*
if(isset($_GET['cardid']) && is_numeric($_GET['cardid'])){
	$cardid = $_GET['cardid'];
	while ($res = DB::fetch($query)) {
		if($res['id'] == $_GET['cardid']){
			$GLOBALS['zoushicard'] = $res;
		}
	}
}else{
	$GLOBALS['zoushicard'] = DB::fetch_first($sql);
	$cardid = $GLOBALS['zoushicard']['id'];
}*/


include template('redbud_zoushitu:header');

include template('redbud_zoushitu:zoushitu');

include template('redbud_zoushitu:footer');
