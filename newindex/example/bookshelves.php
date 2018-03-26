<?php 
header("Content-Type:text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
if(!empty($_SESSION['openId'])){
	$openId = $_SESSION['openId'];
}else{
	require_once "../lib/WxPay.Api.php";
	require_once "WxPay.JsApiPay.php";
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;
}
$userid = $_GET['userid'];
	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$charset = mysql_query("set names utf8");
	$sql = "select *,t1.id as preid from bib_v1_fpage t1 join qm_total_info t2 on t1.orderid = t2.attach and t2.result_code = 'SUCCESS' left join bib_v1_bookinfo t3 on t1.bookid = t3.id where t1.openid = '{$openId}'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$info[] = $a;
	}
	$sql = "select a3.id as preid,a3.*,a4.*
	from bibtest.bib_v1_orders as a1 
	join bibtest.bib_v1_order_detail as a2 on a1.orderid=a2.orderid 
	join bibtest.bib_v1_fpage as a3 on a2.fpage=a3.id 
    join bibtest.bib_v1_bookinfo as a4 on a3.bookid = a4.id
	where a1.userid='{$userid}' and a1.paystatus=1;";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$oderinfo[] = $a;
	}
	
	
	foreach($info as $key=>$value){
$matches = "/name1\/([\s\S]*)\/name2\//";
preg_match_all($matches, $value['url'],$bookid);
$info[$key]['name1'] = base64_decode($bookid[1][0]);
$matches = "/name2\/([\s\S]*)\/top\//";
preg_match_all($matches, $value['url'],$bookid);
$info[$key]['name2'] = base64_decode($bookid[1][0]);
	}
	foreach($oderinfo as $key=>$value){
$matches = "/name1\/([\s\S]*)\/name2\//";
preg_match_all($matches, $value['url'],$bookid);
$oderinfo[$key]['name1'] = base64_decode($bookid[1][0]);
$matches = "/name2\/([\s\S]*)\/top\//";
preg_match_all($matches, $value['url'],$bookid);
$oderinfo[$key]['name2'] = base64_decode($bookid[1][0]);
	}

?>	
	<html>
	<head><meta charset="utf-8"><title>宝贝在书里 · 我的书架</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script>
		<script type="text/javascript">

</script></head>
<body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content">
		
	<div style="margin-top:10px; margin-right:7px;" class="pure-g">
	<?php foreach($info as $key=>$value){ ?>
		<div class="pure-u-1-24" style="margin-top: 40px;height:150px;"></div>
	<div class="pure-u-11-24" style="margin-top: 20px;height:150px;position:relative;">
		<form action="brepreview.php" method="post">
		<input type="hidden" name="bookid" value="<?php echo $value['bookid']; ?>" />
		<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
		<input type="hidden" name="url" value="<?php echo $value['url'].'/repreview/'.$value['preid']; ?>" />
						
		<input type="submit"  class="btn-delete" style="width:100%;height:100%;position:absolute;left:0px;top:0px;border:none;background:url('http://www.babyinbook.com/babyinbook/Public/upload/3.png');float:right" value="" />
							
		</form>
		<img style="width:100%" src="<?php echo $value['index_page']; ?>">
		<div style="height:20px; width:100%;text-align: center;font-size:15px;" >《<?php echo $value['name1'];?><?php if($value['rolenum'] == 2){ echo "和".$value['name2'];} ?><?php echo $value['name']; ?>》</div>
	</div>
	<?php } ?>
	<?php foreach($oderinfo as $key=>$value){ ?>
		<div class="pure-u-1-24" style="margin-top: 40px;height:150px;"></div>
	<div align="center" class="pure-u-11-24" style="margin-top: 20px;height:150px;position:relative;">
	<?php if($value['kind'] == 1){ ?>
		<form action="brepreview.php" method="post">
	<?php }else{ ?>
		<form action="repreviewcand.php" method="post">
	<?php } ?>
		<input type="hidden" name="bookid" value="<?php echo $value['bookid']; ?>" />
		<input type="hidden" name="userid" value="<?php echo $userid; ?>" />
		<input type="hidden" name="url" value="<?php echo $value['url'].'/repreview/'.$value['preid']; ?>" />
						
		<input type="submit"  class="btn-delete" style="width:100%;height:100%;position:absolute;left:0px;top:0px;border:none;background:url('http://www.babyinbook.com/babyinbook/Public/upload/3.png');float:right" value="" />
							
		</form>
		<img style="width:<?php if($value['kind'] == 1){ echo "100%";}else{echo "60%";};?>;height:100%;" src="<?php echo $value['index_page']; ?>">
		<div style="height:40px; width:100%;text-align: center;font-size:15px;" >
		<marquee direction="left" truespeed="truespeed" height="40px" behavior="scroll">
		《<?php echo $value['name1'];?><?php if($value['rolenum'] == 2){ echo "和".$value['name2'];} ?><?php echo $value['name']; ?>》
		</marquee></div>
	</div>
	<?php } ?>
	</div>
	<nav class="bar bar-tab">
		<a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a>
		<a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a>
		<a href="/newindex/example/cart.php" class="tab-item "><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>
	
</html>
