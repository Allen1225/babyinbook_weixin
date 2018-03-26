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
	
	$sql = "select * from babyinbook.pb_member where  m_wechat_openid= '$openId'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr1[] = $a;
	}
	$member = $arr1[0];

	$sql = "SELECT
	*
FROM
	babyinbook.coupon t1
LEFT JOIN babyinbook.channel t2 ON t1.channel_id = t2.id
where t2.user_id = {$member['m_id']} and t1.c_qty != 1 and t1.user_id is null";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$coupon[] = $a;
	}
	foreach($coupon as $key=>$value){
		$strtime = strtotime($value['date_created']) + 86400*$value['c_disc_duration'];
		$coupon[$key]['outtime'] = date("Y-m-d H:i:s",$strtime);
	}
	



?>
<html>
<head><meta charset="utf-8"><title>宝贝在书里 · 我的红包</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><link rel="shortcut icon" href="/img/favicon.jpg"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="/js/sweetalert/theme.css" rel="stylesheet"><script src="/js/sweetalert/sweetalert.min.js">              </script><script type="text/javascript">var xhttp = new XMLHttpRequest();
var openid = 'o-V21wCh_LByF351pAGBswwq5J-g';
var orderId = 0;

var wechatPay = function () {
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var payargs = JSON.parse(xhttp.responseText);
            WeixinJSBridge.invoke('getBrandWCPayRequest', payargs, function (res) {
                if (res.err_msg == "get_brand_wcpay_request:ok") {
                    swal({
                        title: '成功',
                        text: '微信支付成功',
                        type: 'success'
                    });
                    location.href = '/order/' + orderId + '?share=show';
                } else {
                    swal({
                        title: '您访问的页面正在维护中...&lt;br/&gt;请稍后回來。',
                        text: '微信支付失败，请重试',
                        type: 'error'
                    });
                }
            });
        }
    };

    xhttp.open('POST', '/api/wechatPay', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('orderId=' + orderId + '&openid=' + openid);
};

var baoPay = function () {
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var result = JSON.parse(xhttp.responseText);
            if (result.success) {
                swal({
                    title: '成功',
                    text: '积分支付成功',
                    type: 'success'
                });
                location.href = '/order/' + orderId + '?share=show';
            } else {
                swal({
                    title: '您访问的页面正在维护中...&lt;br/&gt;请稍后回來。',
                    text: '积分支付失败，请重试',
                    type: 'error'
                });
            }
        }
    };

    xhttp.open('POST', '/api/baoPay', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('orderId=' + orderId + '&verificationCode=' + document.getElementById('verificationCode').value);
};

var placeOrder = function (id, platform) {
    orderId = id;
    if (platform == 100) {
        document.getElementById('modalTypeSelect').classList.add('active');
    } else {
        wechatPay();
    }
};

function cancelOrder(orderId) {
    swal({
        title:'请确认',
        text:'您确定要取消这个订单么？',
        type:'warning',
        showCancelButton:true
    }, function() {
        document.getElementById('cancelOrder_' + orderId).submit();
    });                
}

function showVerify(show) {
    if (show) {
        document.getElementById('verifyCode').style.display = '';
    } else {
        document.getElementsByName('verification')[0].value = '';
        document.getElementById('verifyCode').style.display = 'none';
    }
}

function sendBaoSMS() {
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var result = JSON.parse(xhttp.responseText);
            if (result.success) {
                swal({
                    title: '成功',
                    text: '短信验证码发送成功',
                    type: 'success'
                });
            } else {
                swal({
                    title: '您访问的页面正在维护中...&lt;br/&gt;请稍后回來。',
                    text: '短信验证码发送失败，请重试',
                    type: 'error'
                });
            }
        }
    };

    xhttp.open('POST', '/api/sendBaoSMS', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('orderId=' + orderId);
}

function baoPayment() {
    var paymentType = document.querySelector('input[name="paymentType"]:checked').value;
    if (paymentType == 'bao') {
        baoPay();
    } else {
        wechatPay();
    }
}</script></head>
<body>
	<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content">
		
		<?php foreach($coupon as $key=>$value){  ?>
		<div style="width:100%;border:1px solid rgb(198,198,198);height:125px;margin-top:15px;">
			<div style="line-height:20px;font-size:15px;width:90%;margin-left:5%;border-bottom:1px solid rgb(198,198,198);height:20px;">
			折扣：<font color="red">¥<?php echo $value['c_disc_amount']; ?></font>
			<span style="float:right;">数量:<?php echo ($value['c_qty'] == 0)?'无限':$value['c_qty']; ?></span>
			</div>
			<div style="width:90%;margin-left:5%;;height:105px;">
				
				<div style="width:35%;height:90%;float:left;">
				<img style="width:100%;height:100%" src="http://www.babyinbook.com/babyinbook/phpqrcode/mkqrcode.php?c_code=<?php echo $value['c_code']; ?>" >
				</div>
				<div style="width:60%;height:90%;float:left;">
				<p style="color:black;margin-top:5px;"><?php echo $value['c_desc']; ?></p>
				<p style="font-size:10px;">有效至：<?php echo $value['outtime']; ?></p>
				<p>优惠码：<?php echo $value['c_code']; ?></p>
				</div>
			</div>
		</div>
		<?php } ?>
		<nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>	
	
	
	
	
</html>