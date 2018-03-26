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
	$sql = "select * from babyinbook.pb_member t1 left join babyinbook.channel t2 on t1.m_id = t2.user_id  where t1.m_wechat_openid = '$openId'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$member[] = $a;
	}
	$userid = $member[0]['m_id'];
	$channelid = $member[0]['id'];
	
	$time = $_GET['time'];
	$sql = "SELECT
	sum(commission_fee) as sum,count(commission_fee) as count,substr(payment_date,1,7) as date,level
FROM
	babyinbook.commission
WHERE
	channel_id = '$channelid'
	and substr(payment_date,1,7) = '$time'
GROUP BY substr(payment_date,1,7),level
order by substr(payment_date,1,7) desc,level asc";

$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$mission[] = $a;
	}
	foreach ($mission as $key => $value) {
		if($value['level'] == 1){
			$sales = $value;
		}else if($value['level'] == 2){
			$sales2 = $value;
		}
	}

?>
<html>
<head><meta charset="utf-8"><title>宝贝在书里 · 分销详细</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><link rel="shortcut icon" href="/img/favicon.jpg"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="/js/sweetalert/theme.css" rel="stylesheet"><script src="/js/sweetalert/sweetalert.min.js">              </script><script type="text/javascript">var xhttp = new XMLHttpRequest();
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
<div class="content">


<div style="width:100%;height:150px;background-color:rgb(166,227,142);position:relative;">
<div style="color:white;font-size:18px;width:260px;height:80px;position:absolute;left:20px;top:45px;">
<?php echo $_GET['time']; ?><br/>
订单数: <?php echo $sales['count'] + $sales2['count']; ?>，提成：<?php echo $sales['sum'] + $sales2['sum']; ?>
</div>

</div>
<div style="width:100%;height:55px;border-bottom:1px solid rgb(198,198,198);position:relative;">
<div style="font-size:15px;width:260px;height:40px;position:absolute;left:20px;top:5px;">
<font style="font-weight:bold;">一级</font><br/>
订单数: <?php echo $sales['count']; ?>，提成：<?php echo $sales['sum']; ?>
</div>

</div>
<div style="width:100%;height:55px;border-bottom:1px solid rgb(198,198,198);position:relative;">
<div style="font-size:15px;width:260px;height:40px;position:absolute;left:20px;top:5px;">
<font style="font-weight:bold;">二级</font><br/>
订单数: <?php echo $sales2['count']; ?>，提成：<?php echo $sales2['sum']; ?>
</div>
</div>
</div>
	<nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav>
	
</body>	
	
	
	
	
</html>
