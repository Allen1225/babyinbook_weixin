<?php
ini_set('memory_limit', '128M');
set_time_limit(300);
header("Content-Type:text/html; charset=utf-8");
require __DIR__ . '/vendor/autoload.php';

use Knp\Snappy\Pdf;
$res = file_get_contents($_GET['url']);
$res = json_decode($res,true);
foreach ($res as $key => $value) {
	$arr[] = "http://localhost:8080/".$value;
}

$width = $_GET['width']."mm";
$height = $_GET['height']."mm";


$snappy = new Pdf('/var/www/html/babyinbook/snap/wkhtmltox/bin/wkhtmltopdf');
$snappy->setOption('margin-left', 0);
$snappy->setOption('margin-right', 0);
$snappy->setOption('margin-bottom', 0);
$snappy->setOption('margin-top', 0);
$snappy->setOption('javascript-delay',5000);
$snappy->setOption('page-height', $height);
$snappy->setOption('page-width', $width);  //3.78
$nowurl =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="file.pdf"');
 //echo file_get_contents("/data/tmp/knp.pdf");
$res = $snappy->getOutput($arr);
if(!empty($res)){
	echo $res;
}else{
	header("Location: $nowurl");
}
