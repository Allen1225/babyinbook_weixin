<?php 
header("Content-Type:text/html; charset=utf-8");
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

$id = $_GET['id'];


$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getFpage/id/$id");

$fpage = json_decode($json,true);

if($openId == $fpage['fpage']['openid'] || $openId == $fpage['openid']){
	$share = 'false';
}else{
	$share = 'true';
}
$u = $fpage['fpage']['url']."/repreview/$id";
	
$json = file_get_contents($u);
$pru = json_decode($json,true);

session_start();

if(empty($fpage['fpage'])){
	//echo $fpage['url'];
	//$url = substr($fpage['url'],0,strlen($fpage['url'])-1);
	$url = rtrim($fpage['url'],'/');
	$url = $url."/fpage/{$id}";
	$matches = "/\/id\/([\s\S]*)\/role\//";
	preg_match_all($matches, $url,$bookid);
	$bookid = $bookid[1][0];
	$matches = "/\/name1\/([\s\S]*)\/name2\//";
	preg_match_all($matches, $url,$name1);
	$name1 = $name1[1][0];
	$matches = "/\/name2\/([\s\S]*)\/top\//";
	preg_match_all($matches, $url,$name2);
	$name2 = $name2[1][0];
	$json = file_get_contents($url);
	//var_dump($url);
	$res = json_decode($json,true);
	//var_dump($res);
}else{
	$url = $fpage['fpage']['url']."/fpage/{$id}";
	
}
//书本宽高
$sql = "select size from bib_v1_bookinfo where  id = {$_SESSION['bookid']}";
include "mysql.php";
$arr1 = query($sql);
$size = explode("*", $arr1[0]['size']);
//var_dump($size);

require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";

$tools = new JsApiPay();
session_start();
if(!empty($_SESSION['openId'])){
	$openId = $_SESSION['openId'];
}else{
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;
}
$orderid = $fpage['orderid'];

if(empty($fpage['fpage'])){
	$money=2*100;
}else{
	$money=file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getprice/bookid/{$fpage['fpage']['bookid']}")*100;
}

//$money = $money*100;
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("绘本");
$input->SetAttach($orderid);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://weixin.babyinbook.com/wxzf/example/orderreturn.php");
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

$url=$_SESSION['url'];
$name=$_SESSION['name'];
$bookid=$_SESSION['bookid'];
$tmp=explode("/",$url);
foreach($tmp as $k=>$v){
	if($v=='role'){
		$role=$tmp[$k+1];
	}
	if($v=='role1'){
		$role1=$tmp[$k+1];
	}
	if($v=='role2'){
		$role2=$tmp[$k+1];
	}
	if($v=='event'){
		$event=$tmp[$k+1];
	}
	if($v=='name1'){
		$name1=$tmp[$k+1];
	}
	if($v=='name2'){
		$name2=$tmp[$k+1];
	}
	if($v=='top'){
		$top=$tmp[$k+1];
	}
	if($v=='mid'){
		$mid=$tmp[$k+1];
	}
	if($v=='bottom'){
		$bottom=$tmp[$k+1];
	}
	if($v=='englishname'){
		$englishname=$tmp[$k+1];
	}
}
//定制后预览
$data="http://www.babyinbook.com/babyinbook/interface.php/Index/MymakePreview/openid/$openId/id/$bookid/role/$role/role1/$role1/role2/$role2/name1/$name1/name2/$name2/top/$top/mid/$mid/bottom/$bottom/event/$event/englishname/$englishname/";
//echo $data;
//var_dump($data);die;
$dir=file_get_contents($data);
$imgarr=json_decode($dir,true);
if($bookid==61){
	$imgarr[4]=$res[0];
}else if($bookid == 64){
	if(!empty($_REQUEST['title_page'])){
	$imgarr[4] = $_REQUEST['title_page'];		
	}else{
	$imgarr[4]=$res[0];
	}
}else if($bookid == 66 || $bookid==65){
	$imgarr[4] = $_REQUEST['title_page'];
}else{
	$imgarr[2]=$res[0];
}

$imgarr=json_encode($imgarr);
?>
<html>
<head>
	<meta charset="utf-8">
	<?php if(empty($fpage['fpage'])){ ?>
		<title>宝贝在书里 · 扉页预览</title>
	<?php }else{ ?>
		<title>宝贝在书里 · 台历预览</title>
	<?php } ?>
	<!-- Sets initial viewport load and disables zooming-->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<link href="/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://www.babyinbook.com/babyinbook/css/basic.css?v=<?php echo rand(1,999)?>"/>
	<link href="http://www.babyinbook.com/babyinbook/css/magazine.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/turn/jquery.min.1.7.js"></script>
	<script type="text/javascript" src="http://www.babyinbook.com/babyinbook/js/modernizr.2.5.3.min.js?v=<?php echo rand(1,999)?>"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/turn/turn.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/turn/zoom.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/newmagazine.js"></script>
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
				window.location.href="http://weixin.babyinbook.com/newindex/example/bookshelves.php";
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
    border-radius: 10px;
    border: 1px solid #BCBCBC;
    background: #949494;
    float: left;
    text-align: center;
    line-height: 38px;
    font-family: 'Arial Negreta', 'Arial Normal', 'Arial';
    font-weight: 700;
    font-style: normal;
    font-size: 16px;
    /*color: #FFFFFF;*/
}
body{
	background:#f8f5f5;
	letter-spacing:0 !important;
}

	</style>
</head>
<body >
	
	<div class="content content-home">
	<?php if(empty($fpage['fpage'])){ ?>
		<?php foreach($res as $key=>$value){ ?>
		<div style="width:100%">
		<?php if(!empty($_REQUEST['title_page'])){?>
                <img src="<?php echo $_REQUEST['title_page']; ?>" style="width:100%">
            <?php }else{?>
                <img src="<?php echo $value; ?>" style="width:100%">
            <?php } ?>	
		</div>
		<?php if($share == 'false'){ ?>
		<div style="margin-left:45px; margin-top:10px; margin-right:11px;">
			<a href="http://weixin.babyinbook.com/newindex/example/fpage.php">
				<input type="button" value="修改寄语/照片" class="button" style="color:white;border-radius:10px;width:140px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" />
			</a>

			<div class="pure-u-1-24"></div>

			<a href="javascript:void(0);" onclick="preview()">
				<input type="button" value="预览全书" style="color:white;border-radius:10px;width:140px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/u14.png');background-size:100%;">
			</a>

			<!---->

			<div id="preview" class="content preview" style="display:none">
				<header class="bar bar-nav">
					<a href="javascript:;" onclick="showdetail()" class="icon icon-close pull-right"></a>
					<span class="preview-title">点击边缘翻页 · 双击放大缩小</span></header>
				<div class="magazine-viewport" style="position: relative; overflow: hidden; width: 375px; height: 627px;">
					<div class="container">
						<div class="magazine">
						</div>
					</div>
				</div>
			</div>

			<div id="detail" style="display:none;position: fixed;top:0px;left:0px;z-index: 9999" class="content content-home" >
				<div class="customize-card">
					<div style="margin-bottom:20px;" class="thumbnail-preview">
						<a href="javascript:;" onclick="showpreview()">
							<img src="<?php echo str_replace("/show/show", "", $res[0]); ?>" class="img-responsive">
							<span><i class="fa fa-search"></i> 点击预览</span>
						</a>
					</div>
				</div>
				<div class="pure-u-14-24" style ="margin-left:20%;">
				<span onclick="window.location.reload()" class="btn btn-block btn-round btn-primary">退出预览</span>
					</div>
			</div>
			<!---->

			<form class="pure-u-8-24"  action="http://www.babyinbook.com/babyinbook/interface.php/Index/DoAddCart/" method="post">
				<input type="hidden" name="bookid"  value="<?php echo $bookid; ?>" />
				<input type="hidden" name="name1" value="<?php echo $name1; ?>" />
				<input type="hidden" name="name2" value="<?php echo $name2; ?>" />
				<input type="hidden" name="url"  value="<?php echo $fpage['url']; ?>" />
				<input type="hidden" name="fpage"  value="<?php echo $id; ?>" />
				<input type="hidden" name="phone"  value="<?php echo $fpage['phone']; ?>" />
				<input type="hidden" name="openid"  value="<?php echo $fpage['openid']; ?>" />
				<button   style="margin-top:12px;font-size:14px;line-height:18px;color:white;border-radius:10px;width:290px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/redb.png');background-size:100%;" >
				￥：<?php echo file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getprice/bookid/{$bookid}"); ?><br/>加入购物车
				</button>
			</form>
			<!-- <div class="pure-u-6-24">
				<input type="button" value="加入书架" onclick="callpay()" class="button" style="color:white;border-radius:10px;width:105px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/redb.png');background-size:100%;"/>
			</div> -->
			<div class="pure-u-1-24"></div>
		</div>
		<?php }else{ ?>
			<div style="width:100%;text-align:center;margin-top:75px">
			<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=<?php echo $bookid; ?>">
				<input type="button" value="前去定制"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" />
			</a>
			</div>
	<?php	}}} ?>
		<?php if(!empty($fpage['fpage'])){ ?>
				<!--样式-->

			<div class="flipbook-viewport" style="display:none;">

				<div class="container" style="width:230px;margin:0 auto">
					<div class="flipbook" style="margin:0 30px;">
					</div>
				</div>
			</div>

			<div style="width:100%;height:55px;position:relative">
			<div class="previousPage"></div>
			<div class="nextPage"></div>
			<div class="return"></div>
				<span class="msg" style=" width:100%;display: block;margin: 0 auto;text-align: center">点击右下角翻页</span>
			<img class="btnImg" src="http://www.babyinbook.com/babyinbook/images/btn.gif" style="display: none"/>
				</div>
				<!--样式-->
			<div style="width:100%;padding:8px;background:#f8f5f5;display: none" class="img" >
		<?php foreach($pru as $key=>$value){ ?>

			<img  src="<?php echo $value; ?>" style="width:100%">

		<?php } ?>
			</div>
			<?php if($share == 'false'){ ?>
			<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<div class="pure-u-3-24"></div>
<!--				<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=--><?php //echo $fpage['fpage']['bookid']; ?><!--"><input type="button" value="重新定制"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" /></a>-->
				<a href="javascript:;" onclick="window.history.go(-1);"><input type="button" value="修改日期/照片"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" /></a>
<!--				<a href="javascript:;" ><input type="button" value="预览全书" style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/u14.png');background-size:100%;"></a>-->
	<div class="pure-u-1-24"></div>
				<form style="width:130px"  action="http://www.babyinbook.com/babyinbook/interface.php/Index/DoAddCart/" method="post">
				
				<input type="hidden" name="bookid"  value="<?php echo $fpage['fpage']['bookid']; ?>" />
				<input type="hidden" name="name1" value="<?php echo $fpage['fpage']['title']; ?>" />
				<input type="hidden" name="url"  value="<?php echo $fpage['fpage']['url']; ?>" />
				<input type="hidden" name="fpage"  value="<?php echo $id; ?>" />
				<input type="hidden" name="phone"  value="<?php echo $fpage['fpage']['phone']; ?>" />
				<input type="hidden" name="openid"  value="<?php echo $fpage['fpage']['openid']; ?>" />
			
				<button   style="font-size:14px;line-height:18px;color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/redb.png');background-size:100%;" >
				￥：<?php echo file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getprice/bookid/{$fpage['fpage']['bookid']}"); ?><br/>加入购物车
				</button>
				</form>
			
				 <div class="pure-u-4-24"></div>
			
	</div>
		
		<?php }else{ ?>
			<div style="width:100%;text-align:center;margin-top:10px">
			<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=<?php echo $fpage['fpage']['bookid']; ?>">
				<input type="button" value="前去定制"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" />
			</a>
			</div>
	<?php	}} ?>	
			
	
	</div></div>

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
				window.onload = function () {
					//alert($(window).height());
					var u = navigator.userAgent;
					if (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1) {//安卓手机
					} else if (u.indexOf('iPhone') > -1) {//苹果手机
						//屏蔽ios下上下弹性
						$(window).on('scroll.elasticity', function (e) {
							e.preventDefault();
						}).on('touchmove.elasticity', function (e) {
							e.preventDefault();
						});
					} else if (u.indexOf('Windows Phone') > -1) {//winphone手机
					}
					//预加载
					loading();
				}

				var date_start;
				var date_end;
				date_start = getNowFormatDate();
				//声明图片路径
				var loading_img_url = new Array();
				var imglength=$(".img").children("img").length;
				var src;
				for(var j=0;j<imglength;j++){
					src=$(".img").children("img").eq(j).attr("src");
					loading_img_url[j]=src;
				}
				//加载页面
				function loading() {
					var numbers = 0;
					var length = loading_img_url.length;

					for (var i = 0; i < length; i++) {
						var img = new Image();
						img.src = loading_img_url[i];


						img.onerror = function () {
							numbers += (1 / length) * 100;
						}
						img.onload = function () {
							numbers += (1 / length) * 100;
							$('.number').html(parseInt(numbers) + "%");
							if (Math.round(numbers) == 100) {
								//$('.number').hide();
								date_end = getNowFormatDate();
								var loading_time = date_end - date_start;
								//预加载图片
								$(function progressbar() {
									//拼接图片
									$('.shade').hide();
									var tagHtml = "";
									for (var i = 1; i <= length; i++) {
										if (i == 1) {
											tagHtml += ' <div id="first" style="background:url('+img.src+') center top no-repeat;background-size:100%"></div>';
										} else if (i == length) {
											tagHtml += ' <div id="end" style="background:url() center top no-repeat;background-size:100%"></div>';
										} else {
											tagHtml += ' <div style="background:url('+loading_img_url[i-1]+') center top no-repeat;background-size:100%"></div>';
										}
									}
									$(".flipbook").append(tagHtml);
									var w = $(".graph").width();
									$(".flipbook-viewport").show();
								});
								//配置turn.js
								function loadApp() {
									//var w = $(window).width();
									var w=230;
									//var h = $(window).height();
									var h=350;
									$('.flipboox').width(w).height(h);
									$(window).resize(function () {
										//w = $(window).width();
										var w=230;
										//h = $(window).height();
										var h=350;
										$('.flipboox').width(w).height(h);
									});
									$('.flipbook').turn({
										// Width
										width: w,
										// Height
										height: h,
										// Elevation
										elevation: 50,
										display: 'single',
										// Enable gradients
										gradients: true,
										// Auto center this flipbook
										autoCenter: true,
										when: {
											turning: function (e, page, view) {
												if (page == 1) {
													$(".btnImg").css("display", "none");
													$(".mark").css("display", "block");
													$(".msg").css("display","block");
												} else {
													$(".btnImg").css("display", "block");
													$(".msg").css("display","none");
													$(".mark").css("display", "none");
												}
												if (page == length) {
													$(".nextPage").css("display", "none");
												} else {
													$(".nextPage").css("display", "block");
												}
											},
											turned: function (e, page, view) {
												var total = $(".flipbook").turn("pages");//总页数
												if (page == 1) {
													$(".return").css("display", "none");
													$(".btnImg").css("display", "none");
													$(".msg").css("display","block");
												} else {
													$(".return").css("display", "block");
													$(".btnImg").css("display", "block");
													$(".msg").css("display","none");
												}
												if (page == 2) {
													$(".catalog").css("display", "block");
												} else {
													$(".catalog").css("display", "none");
												}
											}
										}
									})
								}
								yepnope({
									test: Modernizr.csstransforms,
									yep: ['http://www.babyinbook.com/babyinbook/js/turn.js'],
									complete: loadApp
								});
							}
							;
						}
					}
				}

				function getNowFormatDate() {
					var date = new Date();
					var seperator1 = "";
					var seperator2 = "";
					var month = date.getMonth() + 1;
					var strDate = date.getDate();
					if (month >= 1 && month <= 9) {
						month = "0" + month;
					}
					if (strDate >= 0 && strDate <= 9) {
						strDate = "0" + strDate;
					}
					var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
							+ "" + date.getHours() + seperator2 + date.getMinutes()
							+ seperator2 + date.getSeconds();
					return currentdate;
				}



				///////////////////////////
				//自定义仿iphone弹出层
				(function ($) {
					//ios confirm box
					jQuery.fn.confirm = function (title, option, okCall, cancelCall) {
						var defaults = {
							title: null, //what text
							cancelText: '取消', //the cancel btn text
							okText: '确定' //the ok btn text
						};

						if (undefined === option) {
							option = {};
						}
						if ('function' != typeof okCall) {
							okCall = $.noop;
						}
						if ('function' != typeof cancelCall) {
							cancelCall = $.noop;
						}

						var o = $.extend(defaults, option, {title: title, okCall: okCall, cancelCall: cancelCall});

						var $dom = $(this);

						var dom = $('<div class="g-plugin-confirm">');
						var dom1 = $('<div>').appendTo(dom);
						var dom_content = $('<div>').html(o.title).appendTo(dom1);
						var dom_btn = $('<div>').appendTo(dom1);
						var btn_cancel = $('<a href="#"></a>').html(o.cancelText).appendTo(dom_btn);
						var btn_ok = $('<a href="#"></a>').html(o.okText).appendTo(dom_btn);
						btn_cancel.on('click', function (e) {
							o.cancelCall();
							dom.remove();
							e.preventDefault();
						});
						btn_ok.on('click', function (e) {
							o.okCall();
							dom.remove();
							e.preventDefault();
						});

						dom.appendTo($('body'));
						return $dom;
					};
				})(jQuery);

				//上一页
				$(".previousPage").bind("touchend", function () {
					var pageCount = $(".flipbook").turn("pages");//总页数
					var currentPage = $(".flipbook").turn("page");//当前页
					if (currentPage >= 2) {
						$(".flipbook").turn('page', currentPage - 1);
					} else {
					}
				});
				// 下一页
				$(".nextPage").bind("touchend", function () {
					var pageCount = $(".flipbook").turn("pages");//总页数
					var currentPage = $(".flipbook").turn("page");//当前页
					if (currentPage <= pageCount) {
						$(".flipbook").turn('page', currentPage + 1);
					} else {
					}
				});
				//返回到目录页
				$(".return").bind("touchend", function () {
					$(document).confirm('您确定要返回首页吗?', {}, function () {
						$(".flipbook").turn('page', 1); //跳转页数
					}, function () {
					});
				});

				//全书预览
				function preview() {
					var flipbook = $('.magazine');
					bookPath = '/data/fd9c24c867b412f9/preview/';
					var x = '<?php echo $imgarr; ?>';
					x = JSON.parse( x );
					// Create the flipbook

					flipbook.turn({

						// Magazine width

						width: <?php echo 2*$size[0]; ?>,

						// Magazine height

						height: <?php echo $size[1]; ?>,

						// Duration in millisecond

						duration: 500,

						// Hardware acceleration

						acceleration: !isChrome(),

						// Enables gradients

						gradients: true,

						// Auto center this flipbook

						autoCenter: true,

						// Elevation from the edge of the flipbook when turning a page

						elevation: 50,

						// The number of pages

						pages: x.length,

						// Events

						when: {
							turning: function (event, page, view) {

								var book = $(this),
										currentPage = book.turn('page'),
										pages = book.turn('pages');

							},

							turned: function (event, page, view) {

								$(this).turn('center');

								if (page == 1) {
									$(this).turn('peel', 'br');
								}

							},

							missing: function (event, pages) {

								// Add pages that aren't in the magazine
								var a = pages[0] - 1;

								for (var i = 0; i < pages.length; i++){

									var cp = a + i

									addPage(pages[i], $(this), pages ,x[cp]);
								}
							}
						}

					});

					// Zoom.js

					$('.magazine-viewport').zoom({
						flipbook: $('.magazine'),

						max: function () {

							return largeMagazineWidth() / $('.magazine').width();

						},

						when: {

							swipeLeft: function () {

								$(this).zoom('flipbook').turn('next');

							},

							swipeRight: function () {

								$(this).zoom('flipbook').turn('previous');

							},

							zoomIn: function () {

								$('.magazine').removeClass('animated').addClass('zoom-in');

								if (!window.escTip && !$.isTouch) {
									escTip = true;

									$('<div />', {'class': 'exit-message'}).html('<div>双击退出放大模式</div>').appendTo($('body')).delay(2000).animate({opacity: 0}, 500, function () {
										$(this).remove();
									});
								}
							},

							zoomOut: function () {

								$('.exit-message').hide();

								setTimeout(function () {
									$('.magazine').addClass('animated').removeClass('zoom-in');
									resizeViewport();
								}, 0);

							}
						}
					});

					// Zoom event

					if ($.isTouch)
						$('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
					else
						$('.magazine-viewport').bind('zoom.tap', zoomTo);

					$(window).resize(function () {
						resizeViewport();
					}).bind('orientationchange', function () {
						resizeViewport();
					});

					resizeViewport();

					$('.magazine').addClass('animated');

					showpreview();

				}

				function showdetail(){
					document.getElementById("detail").style.display = "";
					document.getElementById("preview").style.display = "none";
					document.getElementsByClassName("bar-tab")[0].style.display="block";
				}
				window.addEventListener("popstate", function(e) {
					alert(123);
				}, false);
				function showpreview(){
					document.getElementById("detail").style.display = "none";
					document.getElementById("preview").style.display = "";
					document.getElementsByClassName("bar-tab")[0].style.display="none";
				}
			</script>
</body>
</html>
