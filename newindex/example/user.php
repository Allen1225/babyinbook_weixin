<?php 
$res1= json_decode(file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx6a77790bf7451603&secret=23fc1b81b9363d6a6c446132464dce63"),true);
$access_token = $res1['access_token'];


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

	$res2 = json_decode(file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openId&lang=zh_CN"),true);
	//var_dump($res2);
	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("babyinbook");
	$charset = mysql_query("set names utf8");
	$sql = "select * from Session where data like '%$openId%'";
		$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$member[] = $a;
	}
	
//var_dump($member);
	if($_POST['verification']){
	//$sql = "select * from Session where data like '%$openId%'";
	$sql = "select * from Session where data like '%{$_POST['verification']}%'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$member[] = $a;
	}
	$session = json_decode($member[0]['data'],true);
	//var_dump($session['verification']);
	//var_dump($_POST['verification']);
	if($session['verification'] == $_POST['verification']){
		//$sql = "update pb_member set m_account = {$_POST['phone']},m_wechat_name = '{$_POST['name']}' where m_id = {$session[user][id]}";
		$sql = "update pb_member set m_account = {$_POST['phone']},m_wechat_name = '{$_POST['name']}' where m_wechat_openid = '{$openId}'";
		var_dump($sql);
		mysql_query($sql);
		header('Location: http://weixin.babyinbook.com/newindex/example/user.php');	
	}
}

$sql = "SELECT
	*
FROM
	pb_member t1
left JOIN channel t2 on t1.m_id = t2.user_id
WHERE
	t1.m_wechat_openid = '$openId'";
$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr1[] = $a;
	}
$user = $arr1[0];
?>
<html>
	
	<head><meta charset="utf-8"><title>宝贝在书里 · 我的</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link rel="shortcut icon" href="/img/favicon.jpg"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script></head>
	<body>
		<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
		<div class="content">
			<ul style="margin-top:0;border-top:none;" class="table-view">
				<li class="table-view-cell profile-cell">
				<a href="changephone.php?name=<?php echo $user['m_wechat_name']; ?>&phone=<?php echo $user['m_account']; ?>" class="navigate-right">
					<img src="<?php echo $res2['headimgurl']; ?>" class="pull-left">
					<div style="padding-top:5px;">
						<p><?php echo $user['m_wechat_name']; ?></p><p><?php echo $user['m_account']; ?></p>
					</div>
				</a></li>
				<li class="table-view-cell media">
					<a href="order.php" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_orders.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">我的订单</div>
					</a>
				</li>
				<li class="table-view-cell media">
					<a href="addresses.php?openid=<?php echo $openId; ?>&userid=<?php echo $user['m_id']; ?>" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_address.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">收货地址</div>
					</a>
				</li>
				<li class="table-view-cell media">
					<a href="coupon.php" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_coupon.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">我的红包</div>
					</a>
				</li>
				<li class="table-view-cell media">
					<a href="bookshelves.php?userid=<?php echo $user['m_id'];?>" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_orders.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">我的书架</div>
					</a>
				</li>
				<?php if(!empty($user['id'])){ ?>
				<li class="table-view-cell media">
					<a href="sales.php" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_orders.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">分销统计</div>
					</a>
				</li>
				<li class="table-view-cell media">
					<a href="salescoupon.php" class="navigate-right">
						<img src="http://www.babyinbook.com/babyinbook/img/icon_orders.png" width="25" class="media-object pull-left">
						<div style="padding-top:3px;" class="media-body">分销红包</div>
					</a>
				</li>
				<?php } ?>
			</ul>
			</div>
			<nav class="bar" style='bottom: 50px;background-color:transparent;'> 
	<a href="/newindex/example/customer.php"><img style="height:30px;float:right" src="http://www.babyinbook.com/babyinbook/images/customer.png"></a>
	</nav>
			<nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>
</html>
