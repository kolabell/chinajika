<?php
include 'global.inc.php';

$mod = $_REQUEST['mod'];
if('addsubmit' === $mod){
	$qishu = $_REQUEST['qishu'];
	$content = $_REQUEST['content'];
	$sequence = $_REQUEST['sequence'];
	
}


include template('redbud_saloon:header');

include template('redbud_saloon:addsaloon');

include template('redbud_saloon:footer');
