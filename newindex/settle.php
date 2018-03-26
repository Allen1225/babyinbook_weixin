<?php
date_default_timezone_set('PRC');
header("Content-Type:text/html; charset=utf-8");
if (empty($_POST['openid']) || empty($_POST['checklist'])) {
	header('Location: http://weixin.babyinbook.com/newindex/index.php');
}

if(!empty($_POST['dlgDiscountCode']) && !empty($_POST['userid'])){
	$url =  "http://www.babyinbook.com/babyinbook/interface.php/Index/GetCoupon/userid/{$_POST['userid']}/couponid/{$_POST['dlgDiscountCode']}";
	$return = file_get_contents($url,true);
	if($return == 1){
		sleep(1);
	
	}
}

$openid = $_POST['openid'];
$checklist = $_POST['checklist'];
$link = mysql_connect("localhost", "bib", "BibMysql2015");
$db = mysql_select_db("bibtest");
$charset = mysql_query("set names utf8");
if (!empty($_POST['addressid'])) {
	$sql = "SELECT
	*
FROM
	babyinbook.pb_member t1
LEFT JOIN babyinbook.user_address t2 ON t1.m_id = t2.user_id
AND t2.id = '{$_POST['addressid']}'
WHERE
	t1.m_wechat_openid = '$openid'";
} else {
	$sql = "SELECT
	*
FROM
	babyinbook.pb_member t1
LEFT JOIN babyinbook.user_address t2 ON t1.m_id = t2.user_id
AND t2.is_default = 1
WHERE
	t1.m_wechat_openid = '$openid'";
}

$res = mysql_query($sql);
while ($a = mysql_fetch_assoc($res)) {
	$userinfo[] = $a;
}


if (!empty($userinfo[0]['district_id'])) {
	$districtid = $userinfo[0]['district_id'];

	$sql = "SELECT
	t1.district_name,t2.city_name,t3.province_name
FROM
	babyinbook.bc_dict_district t1
LEFT JOIN babyinbook.bc_dict_city t2 ON t1.city_id = t2.id
LEFT JOIN babyinbook.bc_dict_province t3 ON t1.province_id = t3.id
where t1.id = {$districtid}";
	$res = mysql_query($sql);
	while ($a = mysql_fetch_assoc($res)) {
		$default[] = $a;
	}

	$userinfo[0]['province_name'] = $default[0]['province_name'];
	$userinfo[0]['city_name'] = $default[0]['city_name'];
	$userinfo[0]['district_name'] = $default[0]['district_name'];

}
if (!empty($_POST['receiver'])) {
	
	$userinfo[0]['receiver'] = $_POST['receiver'];
	$userinfo[0]['phone'] = $_POST['phone'];
	$userinfo[0]['address'] = $_POST['address'];
	$userinfo[0]['province_name'] = $_POST['province'];
	$userinfo[0]['city_name'] = $_POST['city'];
	$userinfo[0]['district_name'] = $_POST['district'];
}
$sql = "select t2.rolenum,t2.name,t2.pic,t2.price,t1.*,t3.index_page,t2.kind from bib_v1_cart t1 left join bib_v1_bookinfo t2 on t1.productid = t2.id left join bib_v1_fpage t3 on t1.fpage = t3.id where t1.openid = '{$openid}' and t1.id in ($checklist)";

$res = mysql_query($sql);
while ($a = mysql_fetch_assoc($res)) {
	$cart[] = $a;
}

foreach($cart as $key=>$value){
	if($key== 0){
		$c_type = $value['kind'];
	}else{
		$c_type .= ",{$value['kind']}";
	}
}

$allprice = 0;
foreach ($cart as $key => $value) {
	$allprice = $allprice + ($value['price'] * $value['num']);
}
$date = date("Y-m-d H:i:s");
$sql = "SELECT
	t1.valid_to,t1.id,t2.c_name,t2.c_disc_amount,t2.c_qty
FROM
	babyinbook.user_coupon t1
LEFT JOIN babyinbook.coupon t2 ON t1.coupon_id = t2.id
WHERE
	t1.user_id = '{$userinfo[0]['m_id']}'
and '$date' > t1.valid_from
and '$date' < t1.valid_to
and t1.date_used is null
and t2.c_type in ({$c_type})
ORDER BY t2.c_qty desc,t1.valid_to  asc";

$res = mysql_query($sql);
while ($a = mysql_fetch_assoc($res)) {
	$coupon[] = $a;
}
$select_key = 'none';

if(!empty($coupon)){


			$date = $coupon[0]['valid_to'];
			$select_key = 0;
			$select_id = $coupon[0]['id'];
			$select_price = $coupon[0]['c_disc_amount'];
		
}else{
	$select_price = 0;
}


?>

<html>
	<head><meta charset="utf-8"><title>宝贝在书里 · 订单确认</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script><script type="text/javascript">
	var openid = 'o-V21wCh_LByF351pAGBswwq5J-g';

	var createOrder = function(callback) {
		var xhttp = new XMLHttpRequest();

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var order = JSON.parse(xhttp.responseText);
				if (order.success) {
					if (order.needPay) {
						callback(order);
					} else {
						location.href = '/order/' + order.id + '?share=show';
					}
				} else {
					swal({
						title : '您访问的页面正在维护中...&lt;br/&gt;请稍后回來。',
						text : '创建订单失败，请重试',
						type : 'error'
					});
				}
			}
		};

		xhttp.open('POST', '/order', true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		var reqBody = 'payChannel=wechat&addressId=4733&subtotal=198&paymentFee=' + document.getElementsByName('paymentFee')[0].value + '&discountFee=' + document.getElementsByName('discountFee')[0].value + '&invoiceTitle=' + document.getElementsByName('invoiceTitle')[0].value;
		if (document.getElementsByName('couponId').length > 0) {
			reqBody += '&couponId=' + document.querySelector('input[name="couponId"]:checked').value;
		}
		xhttp.send(reqBody);
	};

	function placeOrder() {
		var invoiceTitle = document.getElementsByName('invoiceTitle')[0].value;
		if (invoiceTitle.length > 30) {
			swal({
				title : '输入错误',
				text : '发票抬头过长（不超过30个字）',
				type : 'warning'
			});
			return;
		}

		var addressId = document.getElementsByName('address')[0].value;
		if (!addressId) {
			swal({
				title : '输入错误',
				text : '收货地址为空',
				type : 'warning'
			});
			return;
		}

		var cartForm = document.getElementById('settleForm');
		cartForm.submit();
	}

	function selectCoupon(couponItem) {
		var couponAmount = couponItem.id == 'coupon_donotuse' ? 0 : couponItem.id.split('_')[1];
		var subtotal = document.getElementsByName('subtotal')[0].value;
		document.getElementById('discountFee').textContent = '¥' + couponAmount;
		document.getElementsByName('discountFee')[0].value = couponAmount;
		var paymentFee = (subtotal - couponAmount) > 0 ? (subtotal - couponAmount) : 0;
		document.getElementById('paymentFee').textContent = '¥' + paymentFee;
		document.getElementsByName('paymentFee')[0].value = paymentFee;
	}

	function baoDiscount(discount) {
		var subtotal = document.getElementsByName('subtotal')[0].value;
		var couponAmount = Math.ceil(subtotal * discount);
		document.getElementById('discountFee').textContent = '¥' + couponAmount;
		document.getElementsByName('discountFee')[0].value = couponAmount;
		var paymentFee = (subtotal - couponAmount) > 0 ? (subtotal - couponAmount) : 0;
		document.getElementById('paymentFee').textContent = '¥' + paymentFee;
		document.getElementsByName('paymentFee')[0].value = paymentFee;
	}

	function setInvoiceTitle() {
		var invoiceTitle = document.getElementsByName('invoiceTitle')[0];
		var dlgInvoiceTitle = document.getElementsByName('dlgInvoiceTitle')[0];
		invoiceTitle.value = dlgInvoiceTitle.value;
		document.getElementById('txtInvoiceTitle').textContent = dlgInvoiceTitle.value;
		document.getElementById('modalReceipt').classList.remove('active');
	}

	function clearInvoiceTitle() {
		var invoiceTitle = document.getElementsByName('invoiceTitle')[0];
		var dlgInvoiceTitle = document.getElementsByName('dlgInvoiceTitle')[0];
		invoiceTitle.value = '';
		dlgInvoiceTitle.value = '';
		document.getElementById('txtInvoiceTitle').textContent = '无';
		document.getElementById('modalReceipt').classList.remove('active');
	}

	function cupPay() {
		var settleForm = document.getElementById('settleForm');
		settleForm.action = '/order';
		settleForm.method = 'POST';
		settleForm.submit();
	}

	function clearDiscountCode() {
		var discountCode = document.getElementsByName('discountCode')[0];
		var dlgDiscountCode = document.getElementsByName('dlgDiscountCode')[0];
		discountCode.value = '';
		dlgDiscountCode.value = '';
		document.getElementById('modalCoupon').classList.remove('active');
	}
	
	function applyDiscount() {
		var xhttp = new XMLHttpRequest();
		var discountCode = document.getElementsByName('discountCode')[0];
		var dlgDiscountCode = document.getElementsByName('dlgDiscountCode')[0];
		discountCode.value = dlgDiscountCode.value;

		xhttp.onreadystatechange = function() {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				console.log(xhttp.responseText+"");
				// var check = JSON.parse(xhttp.responseText);
				
				var check = eval('(' +xhttp.responseText+ ')');
				console.log(check.result);
				if (check.result == 'valid') {
					var settleForm = document.getElementById('getCoupon');
					settleForm.submit();

				} else {
					swal({
						title : '输入错误',
						text : '输入的优惠码不存在或已使用，请重新输入',
						type : 'warning'
					});
				}
			}
		};

		xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/checkDiscode', false);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.send('discountCode=' + discountCode.value + '&user_id=' + <?php echo $userinfo[0]['m_id']; ?>);
	}
</script></head>
<body>
	<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content"><form id="settleForm" action="http://www.babyinbook.com/babyinbook/interface.php/Index/createOrder" method="post">
		<input type="hidden" name="payChannel" value="wechat">
		<input type="hidden" name="invoiceTitle" value="">
		<input type="hidden" name="receiver" value="<?php echo $userinfo[0]['receiver']; ?>">
		<input type="hidden" name="phone" value="<?php echo $userinfo[0]['phone']; ?>">
		<input type="hidden" name="address" value="<?php echo $userinfo[0]['address']; ?>">
		<input type="hidden" name="city_name" value="<?php echo $userinfo[0]['city_name']; ?>">
		<input type="hidden" name="district_name" value="<?php echo $userinfo[0]['district_name']; ?>">
		<input type="hidden" name="province_name" value="<?php echo $userinfo[0]['province_name']; ?>">
		<input type="hidden" name="subtotal" value="<?php echo $allprice; ?>">
		<input type="hidden" name="paymentFee" value="<?php echo $allprice - $select_price; ?>">
		<input type="hidden" name="discountFee" value="<?php echo $select_price; ?>">
		<input type="hidden" name="checklist" value="<?php echo $checklist; ?>">
		<input type="hidden" name="discountCode" value="<?php echo $select_id; ?>">
		<input type="hidden" name="userid" value="<?php echo $userinfo[0]['m_id']; ?>">
		<ul class="table-view table-card-view">
		<li style="padding-right:15px;" class="table-view-cell">
			<?php foreach($cart as $key=>$value){ ?>
			<div class="cell-title">
				<div class="thumbnail-list-item">
				<img src="<?php echo str_replace("/show/show", "",$value['index_page']); ?>">
				</div>
			<div>
				<strong><?php 
					$value['name1'] = str_replace(" ", "+", $value['name1']);
					$value['name1'] = str_replace(".", "/", $value['name1']);
					$value['name2'] = str_replace(" ", "+", $value['name2']);
					$value['name2'] = str_replace(".", "/", $value['name2']);
					
					
					if($value['rolenum'] > 0){
						$value['name1']=base64_decode($value['name1']);
						if($value['rolenum'] == 2){
							$value['name1'].= "与".base64_decode($value['name2']);
						}
					}
					$value['name']=str_replace("宝贝",$value['name1'],$value['name']);
					echo $value['name'];
					?>
				</strong>
				<p class="muted text-ss">
				<span class="price text-sm">¥<?php echo $value['price']; ?></span></p>
				<span class="muted text-sm">&nbsp;×&nbsp;<?php echo $value['num']; ?>本</span>
			</div>
			</div>
			<?php } ?>
			<p><span>合计：</span><span>¥<?php echo $allprice; ?></span> - <span id="discountFee">¥<?php echo $select_price; ?></span></p>
			<p><span>总价：</span><span id="paymentFee" class="price">¥<?php echo $allprice -$select_price; ?></span></p>
		</li>
		<li class="table-view-cell">
			<a href="address.php?openid=<?php echo $openid; ?>&checklist=<?php echo $checklist; ?>&userid=<?php echo $userinfo[0]['m_id']; ?>" class="navigate-right">
				<div class="cell-title">
					<span>收货人：</span>
					<span><?php echo $userinfo[0]['receiver']; ?> </span>
					<span class="pull-right muted"><?php echo $userinfo[0]['phone']; ?></span>
				</div>
				<p>收货地址：<?php echo $userinfo[0]['province_name'] . $userinfo[0]['city_name'] . $userinfo[0]['district_name'] . $userinfo[0]['address']; ?></p>
				</a>
		</li>
		<li style="padding-right:15px;" class="table-view-cell">
			<div class="cell-title">红包/折扣<a href="#modalCoupon" class="pull-right btn btn-info">优惠/兑换码</a></div>

			<?php foreach($coupon as $key=>$value){ ?>
			<p>
				<input <?php if($key == $select_key){ echo "checked='true'"; } ?> id="<?php echo $value['id']; ?>_<?php echo $value['c_disc_amount']; ?>" type="radio" name="couponId" value="<?php echo $value['id']; ?>"  onclick="selectCoupon(this);" />
				<label for="<?php echo $value['id']; ?>_<?php echo $value['c_disc_amount']; ?>"></label>
				<span style="position:relative;top:-5px;"> <?php echo $value['c_name']; ?></span>					
			</p>
			<p style="text-indent: 38px;">
				<span style="position:relative;top:-5px;">有效期至<?php echo $value['valid_to']; ?></span>
			</p>
			<?php } ?>

			<p>
				<input id="coupon_donotuse"  <?php if($select_key === 'none'){ echo "checked='true'"; } ?> type="radio" name="couponId" value="0" onclick="selectCoupon(this);">
				<label for="coupon_donotuse">不使用</label>
			</p></li>
		
		<!--<li class="table-view-cell">
			<a href="#modalReceipt" class="navigate-right">
				<div class="cell-title">发票</div>
				<p id="txtInvoiceTitle">无</p>
			</a>
		</li>-->
		</ul>
	</form>
	<div style="margin-top:10px;" class="pure-g">
		<div class="pure-u-5-24"></div>
		<div class="pure-u-14-24">
			<a onclick="placeOrder();" class="btn btn-block btn-round btn-primary btn orange-linear">创建订单</a>
			</div>
			<div class="pure-u-5-24"></div>
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
	</div><div id="modalCoupon" class="modal"><div class="content"><header class="bar bar-nav"><a href="#modalCoupon" class="icon icon-close pull-right"></a><h1 class="title">兑换折扣</h1></header><ul style="margin-top:59px;" class="table-view"><li class="table-view-cell input-group-cell">
		<form id="getCoupon" action=""  method="post" class="input-group">
			<div class="input-row">
				<label>优惠码</label>
				<input type="hidden" name="checklist" value="<?php echo $_POST['checklist']; ?>">
				<input type="hidden" name="openid" value="<?php echo $_POST['openid']; ?>">
				<input type="text" name="dlgDiscountCode" placeholder="优惠/兑换码">
				<input type="hidden" name="userid" value="<?php echo $userinfo[0]['m_id']; ?>" >
			</div>
		</form></li></ul>
		<div style="margin:30px 15px 0 15px;" class="pure-g">
			<div class="pure-u-11-24">
				<a href="javascript:;" onclick="clearDiscountCode();" class="btn btn-negative btn-block btn-round blue-linear">取消</a>
			</div><div class="pure-u-2-24"></div>
			<div class="pure-u-11-24">
				<a href="javascript:;" onclick="applyDiscount();" class="btn btn-primary btn-block btn-round orange-linear">兑换</a>
			</div></div></div></div><div id="modalReceipt" class="modal"><div class="content"><header class="bar bar-nav"><a href="#modalReceipt" class="icon icon-close pull-right"></a><h1 class="title">输入发票信息</h1></header><ul style="margin-top:59px;" class="table-view"><li class="table-view-cell input-group-cell"><form action="javascript:;" class="input-group"><div class="input-row"><label>抬头</label><input type="text" name="dlgInvoiceTitle" placeholder="抬头"></div></form></li></ul><div style="margin:30px 15px 0 15px;" class="pure-g"><div class="pure-u-11-24"><a href="javascript:;" onclick="clearInvoiceTitle();" class="btn btn-negative btn-block btn-round blue-linear">不要发票</a></div><div class="pure-u-2-24"></div><div class="pure-u-11-24"><a href="javascript:;" onclick="setInvoiceTitle();" class="btn btn-primary btn-block btn-round orange-linear">保存发票</a></div></div></div></div></body>
	
	
</html>