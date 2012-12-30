<?php
error_reporting(E_ALL);
set_time_limit(0);

$time1 = time();

$con = mysql_connect("localhost","root","123456");
if (!$con) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("test", $con);

/** PHPExcel_IOFactory */
include 'Classes/PHPExcel/IOFactory.php';

$inputFileType = 'Excel5';
$inputFileName = 'source/plugin/redbud_zoushitu/sampleData/example1.xls';

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($inputFileName);

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$header = $sheetData[1];
$header['A'] = 'mingcheng';
$header['B'] = 'mianzhi';
$header['C'] = 'faxingliang';
$header['D'] = 'faxingshijian';
$header['E'] = 'faxingjia';
foreach($header as $key=>$h){
	if(is_float($h)){
		//$header[$key] = (string)$h;
		$header[$key] = PHPExcel_Shared_Date::ExcelToPHP($h);
	}
}

$header = array_flip($header);

unset($sheetData[1]);

foreach ($sheetData as $key1=>$arr1){
	$temp = array();
	foreach ($header as $key2=>$arr2){
		if($key2 == 'mingcheng' || $key2 == 'faxingliang'|| $key2 == 'faxingshijian'|| $key2 == 'faxingjia'){
			$temp[$key2]=$arr1[$arr2];
		}else{
			if($key2 == 'mianzhi'){
				$arr_mz_ms = explode('/', $arr1[$arr2]);
				$temp['mianzhi'] = $arr_mz_ms[0];
				$temp['meishu'] = $arr_mz_ms[1];
			}else{
				$arr1[$key2] = $arr1[$arr2];
			}	
		}
		
		unset($arr1[$arr2]);
		$temp['zoushi']= serialize($arr1);
		$sheetData[$key1] = $temp;
	}
	//mysql_insert('kapian',$temp);
}

echo '<pre>';
var_dump($sheetData);
echo '</pre>';


function mysql_insert($table, $inserts) {
	$values = array_map('mysql_real_escape_string', array_values($inserts));
	$keys = array_keys($inserts);
	return mysql_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
}

$time2 = time();
echo $time2 - $time1;











