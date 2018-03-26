<?php
header("Content-type: text/html; charset=utf-8");

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
//require_once "../lib/WxPay.Api.php";
//require_once "WxPay.JsApiPay.php";
$orderinfo = json_decode(file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getOrderInfo/orderid/{$_GET['orderid']}"),true);

if($orderinfo['status'] == 'false'){
	header('Location: http://www.babyinbook.com/babyinbook/wap/index.php');
}
//var_dump($orderinfo);die;
//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

$orderid = $orderinfo['orderinfo'][0]['orderid'];
$money =	$orderinfo['orderinfo'][0]['paymentFee']*100;
if(!empty($money)) {
include 'wechatH5Pay.php';
$data['oid'] = $orderid;
//$data 金额和订单号
function wxh5Request($data)
{
    $appid = 'wx6a77790bf7451603';
    $mch_id = '1287105701';//商户号
    $key = 'QJo8HBUBca98kpKW4Ga6NKJZFoaPZFe2';//商户key
    $notify_url = "http://weixin.babyinbook.com/wxzf/example/orderreturn.php";//回调地址
    $wechatAppPay = new wechatH5Pay($appid, $mch_id, $notify_url, $key);
    $params['body'] = '宝贝在书里绘本定制';                       //商品描述
    $params['out_trade_no'] = $data['oid'];    //自定义的订单号
    $params['total_fee'] = '1';                       //订单金额 只能为整数 单位为分
    $params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP
    $params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "https://www.babyinbook.com","wap_name": "宝贝在书里绘本定制"}}';
    $result = $wechatAppPay->unifiedOrder( $params );
    $url = $result['mweb_url'].'&redirect_url=http://weixin.babyinbook.com/wxzf/example/wapcreateorder.php';//redirect_url 是支付完成后返回的页面
    return $url;	
}
//$pay_res_url = wxh5Request($data);
//②、统一下单
//	$input = new WxPayUnifiedOrder();
//	$input->SetBody("绘本");
//	$input->SetAttach($orderid);
//	$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
//	$input->SetTotal_fee($money);
//	$input->SetTime_start(date("YmdHis"));
//	$input->SetTime_expire(date("YmdHis", time() + 600));
//	$input->SetGoods_tag("test");
//	$input->SetNotify_url("http://weixin.babyinbook.com/wxzf/example/orderreturn.php");
	//$input->SetTrade_type("MWEB");
//	$input->SetTrade_type("JSAPI");
//	var_dump($input);die;
//	$input->SetOpenid($openId);
//	$order = WxPayApi::unifiedOrder($input);
//	var_dump($order);die;
//	$jsApiParameters = $tools->GetJsApiParameters($order);
//var_dump($jsApiParameters);die;
//获取共享收货地址js函数参数
//	$editAddress = $tools->GetEditAddressParameters();
//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
}else{
//	echo $orderid;
//	$date=date("YmdHis",time());
//	$sql = "update bib_v1_orders set paystatus = 1 where orderid = $orderid";
//	mysql_query($sql);

//	$sql="INSERT qm_total_info(attach,cash_fee,openid,result_code,return_code,time_end,total_fee,trade_type) VALUES
//	('{$orderid}','{$money}','{$openid}','SUCCESS','SUCCESS','{$date}','{$money}','定制卡')";
//	mysql_query($sql);

//	$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/commission/orderid/{$orderid}";
//	file_get_contents($url);
//	header("Location:http://weixin.babyinbook.com/newindex/example/order.php");
}
?>

<html>
<head>
   <meta charset="utf-8"><title>宝贝在书里 · 订单确认</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
	//调用微信JS api 支付
	/*function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php //echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
			 if(res.err_msg == 'get_brand_wcpay_request:ok'){
					
					alert("付款成功！");
				window.location.href="http://weixin.babyinbook.com/newindex/example/order.php";
				}
			}
		);
	}*/

	function callpay()
	{
		/*if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}*/
		window.location.href = "<?php echo wxh5Request($data);?>";
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php //echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};

	  function useOtherAdd(){
                var a = document.getElementById("otheraddress");
                if(a.checked == false){
                        var x = document.getElementsByClassName("isdisabled");
                        var i;
                        for (i = 0; i < x.length; i++) {
                         x[i].disabled = 'true';
                        }
                        var y = document.getElementsByClassName("isgrey");
                        var j;
                        for (j = 0; j < y.length; j++) {
                         y[j].style.color = 'grey';
                        }
                }else{
                        var x = document.getElementsByClassName("isdisabled");
                        var i;
                        for (i = 0; i < x.length; i++) {
                         x[i].disabled = '';
			
                        }
                        var y = document.getElementsByClassName("isgrey");
                        var j;
                        for (j = 0; j < y.length; j++) {
                         y[j].style.color = 'black';
                        }
                }
        }
	
	</script>
</head>
<body>
	<div class="content">
   <ul class="table-view table-card-view">
		<li style="padding-right:15px;" class="table-view-cell">
			<?php foreach($orderinfo['detailinfo'] as $key=>$value){ ?>
			<div class="cell-title" style="height:75px">
				<div class="thumbnail-list-item">
				<img src="<?php echo str_replace("/show/show", "",$value['index_page']); ?>">
				</div>
			<div>
				<strong><?php echo $value['name']; ?></strong>
				<p class="muted text-ss">
				<span class="price text-sm">¥<?php echo $value['price']; ?></span></p>
				<span class="muted text-sm">&nbsp;×&nbsp;<?php echo $value['num']; ?>本</span>
			</div>
			</div>
			<?php } ?>
			<p><span>合计：</span><span>¥<?php echo $orderinfo['orderinfo'][0]['subtotal']; ?></span> - <span id="discountFee">¥<?php echo $orderinfo['orderinfo'][0]['discountFee']; ?></span></p>
			<p><span>总价：</span><span id="paymentFee" class="price">¥<?php echo $orderinfo['orderinfo'][0]['paymentFee']; ?></span></p>
		</li>
		<li class="table-view-cell">
			<a href="javascript:;" class="navigate-right">
				<div class="cell-title">
					<span>收货人：</span>
					<span><?php echo $orderinfo['orderinfo'][0]['receiver']; ?> </span>
					<span class="pull-right muted"><?php echo $orderinfo['orderinfo'][0]['phone']; ?></span>
				</div>
				<p>收货地址：<?php echo $orderinfo['orderinfo'][0]['province_name'] . $orderinfo['orderinfo'][0]['city_name'] . $orderinfo['orderinfo'][0]['district_name'] . $orderinfo['orderinfo'][0]['address']; ?></p>
				</a>
		</li>
		<li style="padding-right:15px;" class="table-view-cell">
			<div class="cell-title">红包/折扣</div>
			
			<p>
				<label><p><?php echo $orderinfo['orderinfo'][0]['c_name']; ?></p></label>
			</p>
		
			</li>
		
		<!--<li class="table-view-cell">
			<a href="javascript:;" class="navigate-right">
				<div class="cell-title">发票</div>
				<p id="txtInvoiceTitle"><?php //echo $orderinfo['orderinfo'][0]['invoiceTitle']; ?></p>
			</a>
		</li>-->
		</ul>
		<?php if($orderinfo['orderinfo'][0]['paystatus'] == 0){ ?>
		<div style="margin-top:10px;" class="pure-g">
		<div class="pure-u-5-24"></div>
		<div class="pure-u-14-24">
			<a onclick="callpay()" class="btn btn-block btn-round btn-primary btn orange-linear">立即支付</a>
			</div>
			<div class="pure-u-5-24"></div>
	</div>
	<?php } ?>
	</div>
		
</body>

</html>
