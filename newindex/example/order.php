<?php 
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
include "mysql.php";
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
	if($_POST['id']){
		$sql = "update bib_v1_orders set paystatus = 5 where id = {$_POST['id']}";
		mysql_query($sql);
	}
	$sql = "select * from babyinbook.pb_member where  m_wechat_openid= '$openId'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr1[] = $a;
	}
	$member = $arr1[0];
	$sql = "select * from bib_v1_orders where userid = {$member['m_id']} group by orderid order by createtime desc";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$order[] = $a;
	}
	
	foreach($order as $key=>$value){
		$orderitem = array();
		$sql = "
			select t1.*,t2.index_page,t3.name,t3.rolenum from bib_v1_order_detail t1 left join bib_v1_fpage t2 on t1.fpage = t2.id left join bib_v1_bookinfo t3 on t1.bookid = t3.id where t1.orderid  = '{$value['orderid']} '  
		";
		$res = mysql_query($sql);
		while($a = mysql_fetch_assoc($res)){
			$orderitem[] = $a;
		}
		$order[$key]['item'] = $orderitem;
		$str = $value['index_page'];
        if(strpos($str,"/Public/preview/") !== false){
            $tmp_arr = explode('/',$str);
            $a = explode('_',$tmp_arr[6]);

            foreach ($a as $k=>&$v){
                if($k == 2 && !is_base64($a[2])){
                    $name = base64_encode($a[2]);
                    $name = str_replace("+",'-',$name);
                    $name = str_replace("/",'-',$name);
                    $name = str_replace(".",'-',$name);
                    $name = str_replace("=",'-',$name);
                    $v = $name;
                }
            }
            $new = implode('_',$a);
            foreach ($tmp_arr as $key=>&$val){
                if($key == 6){
                    $val = $new;
                }
            }
            $new_str = implode('/',$tmp_arr);
            $value['index_page'] = $new_str;
        }
	}



?>
<html>
<head><meta charset="utf-8"><title>宝贝在书里 · 我的订单</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><link rel="shortcut icon" href="/img/favicon.jpg"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js">              </script><script type="text/javascript">var xhttp = new XMLHttpRequest();
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
	<ul class="table-view table-card-view">
		<?php foreach($order as $key=>$value){ ?>
	<li style="padding-right:15px;" class="table-view-cell">
		<form id="cancelOrder_7420" action="/order/7420/cancel" method="POST" class="hide">
			
		</form>
		<div class="cell-title">
			<a href="">
				<span class="muted">订单号：</span>
				<span><?php echo $value['orderid']; ?></span>
				<span class="pull-right text-info">
				<?php
                        if(!empty($value['express']) && !empty($value['sendcode'])){
                            echo "已发货";
                        }else{
                            switch($value['paystatus']){
                                case 0 : echo "待支付"; break;
                                case 1 : echo "已支付"; break;
                                case 5 : echo "已取消"; break;
                            }
			}
			?>
				</span>
			</a>
		</div>
		<?php foreach($value['item'] as $key1=>&$value1){
			$str = $value1['index_page'];
        if(strpos($str,"/Public/preview/") !== false){
            $tmp_arr = explode('/',$str);
            $a = explode('_',$tmp_arr[6]);

            foreach ($a as $k=>&$v){
                if($k == 2 && !is_base64($a[2])){
                    $name = base64_encode($a[2]);
                    $name = str_replace("+",'-',$name);
                    $name = str_replace("/",'-',$name);
                    $name = str_replace(".",'-',$name);
                    $name = str_replace("=",'-',$name);
                    $v = $name;
                }
            }
            $new = implode('_',$a);
            foreach ($tmp_arr as $key=>&$val){
                if($key == 6){
                    $val = $new;
                }
            }
            $new_str = implode('/',$tmp_arr);
            $value1['index_page'] = $new_str;
        }
		 ?>
			<div class="cell-title">
				<div class="thumbnail-list-item">
				<img src="<?php echo str_replace("/show/show", "",$value1['index_page']); ?>">
				</div>
			<div>
				<strong><?php
							$value1['name1'] = str_replace(" ", "+", $value1['name1']);
							$value1['name1'] = str_replace(".", "/", $value1['name1']);
							$value1['name2'] = str_replace(" ", "+", $value1['name2']);
							$value1['name2'] = str_replace(".", "/", $value1['name2']);

							if($value1['rolenum'] > 0){
								$value1['name1']=base64_decode($value1['name1']);
							if($value1['rolenum'] == 2){
								$value1['name1'].= "与".base64_decode($value1['name2']);
							}
							}
							$value1['name']=str_replace("宝贝",$value1['name1'],$value1['name']);
                            $value1['name']=str_replace("不怕打针",$value1['name1']."不怕打针",$value1['name']);
                            $value1['name']=str_replace("不怕看病",$value1['name1']."不怕看病",$value1['name']);
							echo $value1['name'];
						?></strong>
				<p class="muted text-ss">
				<span class="price text-sm">¥<?php echo $value1['price']; ?></span></p>
				<span class="muted text-sm">&nbsp;×&nbsp;<?php echo $value1['num']; ?>本</span>
				
				<div style="clear:both"></div>
			</div>
			</div>
			<?php } ?>
		<div class="pure-g">
			<div class="pure-u-12-24"><p><span>合计：</span>
				<span>¥<?php echo $value['subtotal']; ?>-¥<?php echo $value['discountFee']; ?></span></p><p>
					<span>总价：</span><span class="price">¥<?php echo $value['paymentFee']; ?></span>
					</p>
			</div><div class="pure-u-12-24"><div class="pull-right">
				<?php if($value['paystatus'] == 0){ ?>
					<form action="" method="post">
						<input  type="submit" class="btn btn-info btn-round-ss btn green-linear" value="取消订单">
						<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
                    </form>
                        <button onclick="window.location.href='/wxzf/example/createorder.php?orderid=<?php echo $value['orderid']; ?>'" class="btn btn-info btn-round-ss btn green-linear">前去支付</button>
                <?php }else if($value['paystatus'] == 1 || $value['paystatus'] == 2){ ?>
				        <button onclick="window.location.href='createorder.php?orderid=<?php echo $value['orderid']; ?>'" class="btn btn-info btn-round-ss btn green-linear">点击查看</button>
				<?php } ?>
					</div></div></div>
		</li>
		
		<?php } ?>
		
		</ul></div><nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav><div id="modalTypeSelect" class="modal"><div class="content"><header class="bar bar-nav"><a href="#modalTypeSelect" class="icon icon-close pull-right"></a><h1 class="title">选择支付方式</h1></header><ul style="margin-top:59px;" class="table-view"><li class="table-view-cell"><div class="cell-title">支付方式</div><p><input id="pay_type_bao" type="radio" name="paymentType" value="bao" checked="" onclick="showVerify(true)"><label for="pay_type_bao">兜礼积分</label></p><p><input id="pay_type_wechat" type="radio" name="paymentType" value="wechat" onclick="showVerify(false)"><label for="pay_type_wechat">微信支付</label></p></li><li id="verifyCode" class="table-view-cell input-group-cell"><form id="mainForm" class="input-group"><div class="input-row"><label>验证码</label><button type="button" onclick="sendBaoSMS()" class="btn pull-right btn-sms">点击获取</button><input id="verificationCode" name="verification" type="tel" placeholder="验证码" style="width:50%;"></div></form></li></ul><div style="margin-top:10px;" class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a href="javascript:;" onclick="baoPayment();" class="btn btn-primary btn-block">支付</a></div></div></div></div></body>	
	
	
	
	
</html>
