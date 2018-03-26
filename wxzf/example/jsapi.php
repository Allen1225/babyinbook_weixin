<?php

header("Content-type: text/html; charset=utf-8");  


ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
session_start();
if(!empty($_SESSION['openId'])){
	$openId = $_SESSION['openId'];
}else{
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;
}
$orderid = date("YmdHis").rand(0,9999);
mysql_connect("localhost","bib","BibMysql2015");
mysql_select_db("babyinbook");
mysql_query("set names utf8");
$sql = "INSERT qm_customer_info(name,phone,nums,otheraddress,oname,ophone,oaddress,sex,age,job,wechat,mail,message,orderid,shen,shi,qu,pvid)
VALUES('{$_GET['name']}','{$_GET['phone']}','{$_GET['nums']}','{$_GET['otheraddress']}','{$_GET['oname']}','{$_GET['ophone']}','{$_GET['oaddress']}','{$_GET['sex']}','{$_GET['age']}','{$_GET['job']}','{$_GET['wechat']}','{$_GET['mail']}','{$_GET['message']}','{$orderid}','{$_GET['shen']}','{$_GET['shi']}','{$_GET['qu']}','{$_GET['pvid']}')";
mysql_query($sql);

$money = 6800 * $_GET['nums'];
$_GET['oaddress'] = $_GET['shen'].$_GET['shi'].$_GET['qu'].$_GET['oaddress'];
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("医学绘本");
$input->SetAttach($orderid);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://weixin.babyinbook.com/wxzf/example/return.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);
//print_r($jsApiParameters);
//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();
//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**

 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
if($_GET['sex'] == 'male'){
	$_GET['sex'] = "男";
}else if($_GET['sex'] == 'female'){
	$_GET['sex'] = "女";
}
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>信息核对</title>
        <style type="text/css">
    	body{

 position: relative;
 padding-left:10px;
 padding-top:20px; 
 font-size:20px;
    	}
    	
    </style>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
			 if(res.err_msg == 'get_brand_wcpay_request:ok'){
					
					alert("付款成功！");
				window.location.href="http://weixin.babyinbook.com/wxzf/index.php";
				}
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
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
    		<img src="../img/bg1.png" style="width:100%;height:200px;">
	<p>姓名 :<?php echo !empty($_GET['name'])?$_GET['name']:"";?></p>
	<p>电话 :<?php echo $_GET['phone']; ?></p>
	<p>数量 :<?php echo $_GET['nums'];?></p>
	<p>金额 :<?php echo $money/100;echo "元"; ?></p>
	<p>收货人 :<?php echo $_GET['oname']; ?></p>
	<p>联系电话 :<?php echo $_GET['ophone'];?></p>
	<p>收货地址:<?php if($_GET['otheraddress'] == 'otheraddress'){ echo $_GET['oaddress'];}else{ echo "上海儿童医学中心";} ?></p>
 <input onclick="window.history.go(-1);" type="button"  style="position :absolute;left:7.5%;width:40%; height:30px; border-radius: 15px;background-color:#f7931e; border:0px #FE6714 solid; cursor: pointer;  color:black;  font-size:20px;" value="上一步" />
		<button style="position:absolute;left:52.5%;width:40%; height:30px; border-radius: 15px;background-color:#f7931e; border:0px #FE6714 solid; cursor: pointer;  color:black;  font-size:20px;" type="button" onclick="callpay()" >立即支付</button>
	<br/><br/>
</body>

</html>
