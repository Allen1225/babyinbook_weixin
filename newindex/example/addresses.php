<?php 
$openid =  $_GET['openid'];
$userid = $_GET['userid'];
$link = mysql_connect("localhost","bib","BibMysql2015");
$db = mysql_select_db("babyinbook");
$charset = mysql_query("set names utf8");
$sql = "SELECT
	t0.*,t1.district_name,t2.city_name,t3.province_name
FROM
	user_address t0
left join bc_dict_district t1 on t0.district_id = t1.id
LEFT JOIN bc_dict_city t2 ON t1.city_id = t2.id
LEFT JOIN bc_dict_province t3 ON t1.province_id = t3.id
WHERE
	t0.user_id = '$userid'";
$res = mysql_query($sql);
while($a = mysql_fetch_assoc($res)){
		$address[] = $a;
}

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>宝贝在书里 · 选择收货地址</title><!-- Sets initial viewport load and disables zooming-->
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="shortcut icon" href="/img/favicon.jpg">
		<link href="/css/pure-min.css" rel="stylesheet">
		<!-- Include the compiled Ratchet CSS-->
		<link href="/css/ratchet.min.css" rel="stylesheet">
		<!-- Include the Awesome Font CSS-->
		<link href="/css/font-awesome.min.css" rel="stylesheet">
		<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
		<!-- Include the compiled Ratchet JS-->
		<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
		<script type="text/javascript">
	function selectAddress(addrObj) {
    var addressInput = document.getElementById('addressId');
    addressInput.value = addrObj.id;
    var cartForm = document.getElementById('cartForm');
    cartForm.submit();
	}
</script>
</head>
<body>
	<div class="content">
		<form id="cartForm" action="settle.php" method="POST" class="hide">
		<input id="checklist" type="hidden" name="checklist" value="<?php echo $_GET['checklist']; ?>">
		<input id="openid" type="hidden" name="openid" value="<?php echo $_GET['openid']; ?>">
		<input id="addressId" type="hidden" name="addressid" value="">
		</form>
		<ul class="table-view table-card-view">
			<?php foreach($address as $key=>$value){ ?>
			<li class="table-view-cell default-cell">
			<a id="<?php echo $value['id']; ?>" href="updateaddress.php?id=<?php echo $value['id']; ?>&openid=<?php echo $_GET['openid']; ?>&userid=<?php echo $_GET['userid']; ?>" class="navigate-right">
				<div class="cell-title">
					<span>收货人: &nbsp;</span>
					<span><?php echo $value['receiver']; ?></span>
					<span class="pull-right muted"><?php echo $value['phone']; ?></span></div><p>收货地址：<?php echo $value['province_name'].$value['city_name'].$value['district_name'].$value['address'];  ?></p></a>
			</li>
			<?php } ?>
		</ul>
		<div style="margin-top:30px;" class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a href="javascript:;" onclick="window.location.href='/user/addresses/newaddresses.php?openid=<?php echo $openid; ?>&userid=<?php echo $userid; ?>'" class="btn btn-block btn-round btn-primary orange-linear">新增地址</a></div><div class="pure-u-5-24"></div></div></div><nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item active"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>
</html>
