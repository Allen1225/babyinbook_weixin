<?php
header("Content-type: text/html; charset=utf-8");
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
	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$charset = mysql_query("set names utf8");
	$sql = "select * from babyinbook.pb_member where m_wechat_openid = '$openId'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$member[] = $a;
	}
	if(empty($member)){
		header("Location: http://www.babyinbook.com/babyinbook/signup.php?openId={$openId}");
	}else{
		$_SESSION['member'] = $member;
	}
	
	
	
	
	
	
	$id1 = $_GET['bookid'];
	$id2 = $_GET['book2id'];
	
	$sql = "(select * from bib_v1_bookinfo where id = $id1) UNION ALL (select * from bib_v1_bookinfo where id = $id2)";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$book[] = $a;
	}

	

 ?>
<html>
<head>
	<meta charset="utf-8">
	<title>宝贝在书里 · 首页</title>
	<!-- Sets initial viewport load and disables zooming-->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<style type="text/css">
		.selected{
			border:2px solid black;
		}
		.unselected{
			border:1px solid #ccc;
		}
		.button {
    width:180px;
    height: 50px;

    border-radius:25px;

    background: rgb(144,206,39);

    text-align: center;
    line-height: 38px;
    font-family: 'Arial Negreta', 'Arial Normal', 'Arial';
    font-weight: 700;
    font-style: normal;
    font-size: 16px;
    color: #FFFFFF;
}
	</style>
</head>
<body >
	<div class="content content-home">
				<div style="width:100%;height:15px"></div>
				<div style="width:90%;margin-left:5%;border:1px solid #ccc">
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<div style="width:100%;margin-left:5px;letter-spacing:2px;height:40px;line-height:40px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 18px;"><?php echo $book[0]['name']; ?></div><br/>
				<!--<div style="width:100%;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 15px;">售价￥：<?php echo $book[0]['price']; ?></div> -->
				<p style="width:100%;letter-spacing:2px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;"><?php echo $book[0]['message']; ?></p>
				<div style="height:20px;clear:both"></div>
				</div>	
				<form method="post" style="margin:0 auto;text-align:center;" action="http://www.babyinbook.com/babyinbook/interface.php/Index/insert" onsubmit="return createCand();"  >
					<input type="text" id="name" name="name" placeholder="请输入署名" value="" style="width:90%;height:48px;border:1px solid rgb(136,180,34);border-radius:10px;padding-left:10px;" />
					<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
					<input type="hidden" name="bookid"  value="<?php echo $_GET['bookid']; ?>" />
				
				
				<input type="submit" value="开始定制" class="button" style="width:180px;" />
				</form>
				<div style="height:20px;clear:both"></div>
				</div>
				<div style="width:100%;height:15px"></div>
				<div style="width:90%;margin-left:5%;border:1px solid #ccc">
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<div style="width:100%;margin-left:5px;letter-spacing:2px;height:40px;line-height:40px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 18px;"><?php echo $book[1]['name']; ?></div><br/>
				<!--<div style="width:100%;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 15px;">售价￥：<?php echo $book[1]['price']; ?></div> -->
				<p style="width:100%;letter-spacing:2px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;"><?php echo $book[1]['message']; ?></p>
				<div style="height:20px;clear:both"></div>
				</div>	
				<div style="height:20px;clear:both"></div>
				<form method="post" action="http://www.babyinbook.com/babyinbook/interface.php/Index/insert"  style="margin:0 auto;text-align:center;" >
	
				<input type="hidden" name="bookid"  value="<?php echo $_GET['book2id']; ?>" />
					<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
				
				<input type="submit" value="开始定制" class="button" style="width:180px;"  />
				</form>
					<div style="height:20px;clear:both"></div>
				</div>
			
	</div>
				


		
			<nav class="bar bar-tab">
				<a href="/newindex/index.php" class="tab-item active">
					<span class="icon icon-home"></span>
					<span class="tab-label">首页</span>
				</a>
				<a href="/newindex/example/user.php" class="tab-item">
					<span class="icon icon-person"></span>
					<span class="tab-label">我的</span>
				</a>
				<a href="/newindex/example/cart.php" class="tab-item">
					<span class="icon fa fa-shopping-cart"></span>
					<span class="tab-label">购物车</span>
				</a>
			</nav>
			<script>
			function getByteLen(val) { 
					var len = 0; 
					for (var i = 0; i < val.length; i++) { 
					if (val[i].match(/[^\x00-\xff]/ig) != null) //全角 
					len += 2; 
					else 
					len += 1; 
					} 
					return len; 
					}
			
			
						function createCand(){
						 var namelen = getByteLen($("#name").val());

						  if (namelen > 12) {
							alert("署名过长！")
							return false;
						}
						if (namelen < 1) {
							alert("请输入署名！")
							return false;
						}
					}
			</script>
</body>
</html>
