<?php
set_time_limit(300);
require __DIR__ . '/vendor/autoload.php';

use Knp\Snappy\Image;

$snappy = new Image('/var/www/html/babyinbook/snap/wkhtmltox/bin/wkhtmltoimage');
$url = $_GET['url'];
$url = "localhost:8080/".$url;
$xishu = 1;
$xishu1 = $_GET['width']/1024;
$xishu2 = $_GET['height']/1024;
if($xishu1 >1 || $xishu2 >1){
	$xishu = $xishu1>$xishu2?$xishu1:$xishu2;
}
if(!empty($_GET['width'])){
	$width = ceil($_GET['width']/$xishu);
	$snappy->setOption('crop-w',$width );
}

if(!empty($_GET['height'])){
	$height = ceil($_GET['height']/$xishu);
	$snappy->setOption('crop-h', $height);
}
$zoom = 1/$xishu;
$url = $url;

	$snappy->setOption('zoom', $zoom);
//$url = "http://localhost/babyinbook/index.php/Draw/MkHtml/id/{$_GET['id']}/type/{$_GET['type']}/style/{$_GET['style']}/language/1/role/{$_GET['role']}/page/{$_GET['page']}";
//$url = "./MkHtml.html";
header('Content-Type: image/jpeg');
echo $snappy->getOutput($url);
