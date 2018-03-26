<?php

	header("Content-Type:text/html; charset=utf-8");

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$id = $_GET['id'];
	$charset = mysql_query("set names utf8");
	$sql = "select * from bib_v1_bookinfo where id = $id";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$book[] = $a;
	}
	$bookinfo = $book[0];

	$sql = "select * from bib_v1_itempic where bookid = $id";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$item[] = $a;
	}
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
switch ($id) {
	case '50':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
			break;
		break;
	case '51':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '41':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '42':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '37':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '49':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '48':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '25':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '29':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '43':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '44':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '45':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '46':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '47':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
	case '39':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/name.png";	
		break;
	case '40':
		$pic = "http://www.babyinbook.com/babyinbook/images/cand/noname.png";	
		break;
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
	<link href="/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<style type="text/css">
		.selected{
			border:2px solid black;
		}
		.unselected{
			border:1px solid #ccc;
		}
		.button {
    width: 145px;
    height: 42px;
    margin-right: 30px;
    border-radius: 10px;

    background: rgb(252,128,99);
    float: left;
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
		<div style="width:100%">
			<a href="http://weixin.babyinbook.com/newindex/example/make.php?rolenum=<?php echo $bookinfo['rolenum']; ?>&bookid=<?php echo $id; ?>&openid=<?php echo $_SESSION['openId']?>"><img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $bookinfo['pic']; ?>" style="width:100%;"></a>
		</div>
				
				
				<div style="margin-left:7px; margin-top:<?php if($bookinfo['kind'] == 2) {echo "10px";}else{echo "-20px";} ?>; margin-right:7p7x;" class="pure-g">

			<?php if($bookinfo['kind'] == 2) {  ?>
				<div style="width:100%;margin-left:5px;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 18px;"><?php echo $bookinfo['name']; ?></div>
				<div style="height:10px;width:100%"></div>
				<!--<div style="width:100%;margin-left:5px;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 15px;">售价￥：<?php echo $bookinfo['price']; ?></div>-->
				<div style="height:10px;width:100%"></div>
				<p style="width:90%;margin-left:5%;text-indent:20px;letter-spacing:2px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;"><?php echo $bookinfo['message']; ?></p>
			<?php } ?>

				<div style="height:20px;clear:both"></div>
				<div style="width:100%;letter-spacing:2px;height:30px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;display:none;"><div style="float:left;">角色选择: </div>
				<div id="one" onclick="selected(1)" class="selected" style="margin-left:15px;float:left;height:25px;width:80px;text-align:center;">单人</div>
				<div id="two" onclick="selected(2)" class="unselected" style="margin-left:15px;float:left;height:25px;width:80px;text-align:center;">双人</div>
				
			
				</div>	
			
				 <div style="height:20px;clear:both"></div>
			
	</div>
	<?php if($bookinfo['kind'] == 2 && $bookinfo['rolenum'] == 0) {  ?>
			<form action="http://www.babyinbook.com/babyinbook/interface.php/Index/insert" method="post" style="width:80%;margin:0 auto;text-align: center;" >
				<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
				<input type="hidden" name="name"  value="null" />
				<input type="hidden" name="bookid"  value="<?php echo $id; ?>" />
				<input type="submit" value="" style="width:130px;height:40px;border:none;background: url('<?php echo $pic; ?>');background-size: contain;background-repeat: no-repeat;" />
			</form>
		<?php }else{ ?>
			<form action="make.php" method="get" style="width:80%;margin:0 auto;text-align: center;" >
				<input type="hidden" name="rolenum" id="rolenum" value="<?php echo $bookinfo['rolenum']; ?>" />
				<input type="hidden" name="bookid"  value="<?php echo $id; ?>" />
				<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
				<?php if($bookinfo['kind'] == 2){  ?>
					<input type="submit" value="" style="width:130px;height:40px;border:none;background: url('<?php echo $pic; ?>');background-size: contain;background-repeat: no-repeat;" />
				<?php }else{  ?>
					<!-- <input type="submit" value="" style="width:100px;height:30px;border:none;background: url('');background-size: contain;background-repeat: no-repeat;margin-top: -60px; 
					margin-left:180px"  /> -->
				<?php } ?>	
			</form>
	<?php } ?>

	<?php if($bookinfo['kind'] == 2) {  ?>
				<div style="height:20px;clear:both;">				
	</div>
	<div style="height:28px;width:100%;background: rgb(136,201,209)">&nbsp;&nbsp;&nbsp;&nbsp;<font face= '微软雅黑' color="white" style="line-height: 28px;">产品介绍</font></div>
	<?php } ?>
	<div style="width:80%;margin:0 auto;color:#979797;font-family: 微软雅黑;font-size:18px;line-height: 24px;text-indent:25px"><?php echo $bookinfo['text']; ?></div>
	<?php foreach($item as $key=>$value){ ?>
		<div style="width:<?php if($bookinfo['kind'] == 2) {echo "80%";}else{echo "100%";} ?>;margin:0 auto;">
	<a href="<?php echo $value['url']; ?>"><img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" style="width:100%;margin:0 auto" /></a>
		</div>
	<?php } ?>
	</div>
	<div id="modalShareVersion" style="z-index: 1080;" class="modal">
		<div style="background-image: url(/img/background.png);background-repeat: repeat;" class="content">
			<header style="background: #90CE27;" class="bar bar-nav">
				<a href="#modalShareVersion" style="color: #FFF" class="icon icon-close pull-right"></a>
				<h1 style="color: #FFF" class="title">Hello，我是平装分享版哦</h1>
			</header>
			<div class="pure-g">
				<div class="pure-u-5-24"></div>
				<div style="text-align: center;" class="pure-u-14-24">
					<a href="/book/2/customize" class="btn btn-block btn-round btn-primary">定制分享版</a>
				</div>
				<div class="pure-u-5-24"></div>
			</div></div></div>
			<nav class="bar" style='bottom: 50px;background-color:transparent;'> 
	<a href="/newindex/example/customer.php"><img style="height:30px;float:right" src="http://www.babyinbook.com/babyinbook/images/customer.png"></a>
	</nav>
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
			<script type="text/javascript">
			function selected(e){
				if(e == 1){
					 $("#one").addClass("selected");
					 $("#one").removeClass("unselected");
					 $("#two").addClass("unselected");
					 $("#two").removeClass("selected");
					 $("#rolenum").val("1");
				}else if(e == 2){
					 $("#two").addClass("selected");
					 $("#two").removeClass("unselected");
					 $("#one").addClass("unselected");
					 $("#one").removeClass("selected");
					 $("#rolenum").val("2");
				}
			}
			</script>
</body>
</html>