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
	//$share = 'false';
	$share = 'true';
}else{
	//$share = 'true';
	$share = 'false';
}
$u = $fpage['fpage']['url']."/repreview/$id";
	
$json = file_get_contents($u);
$pru = json_decode($json,true);

session_start();

if(empty($fpage['fpage'])){
	$url = $fpage['url']."/fpage/{$id}";
	$matches = "/makePreview\/id\/([\s\S]*)\/role\//";
	preg_match_all($matches, $url,$bookid);
	$bookid = $bookid[1][0];
	$matches = "/\/name1\/([\s\S]*)\/name2\//";
	preg_match_all($matches, $url,$name1);
	$name1 = $name1[1][0];
	$matches = "/\/name2\/([\s\S]*)\/top\//";
	preg_match_all($matches, $url,$name2);
	$name2 = $name2[1][0];
	$json = file_get_contents($url);

	$res = json_decode($json,true);
}else{
	$url = $fpage['fpage']['url']."/fpage/{$id}";
	
}



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
$money = 1;
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
	<link rel="stylesheet" type="text/css" href="http://www.babyinbook.com/babyinbookhttp://www.babyinbook.com/babyinbook/css/basic.css?v=<?php echo rand(1.999)?>"/>
	<!-- Include the compiled Ratchet JS-->
	<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="http://www.babyinbook.com/babyinbook/js/modernizr.2.5.3.min.js?v=<?php echo rand(1.999)?>"></script>
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
}
	</style>
</head>
<body >
	
	<div class="content content-home">
	<?php if(empty($fpage['fpage'])){ ?>
		<?php foreach($res as $key=>$value){ ?>
		<div style="width:100%">
			<img src="<?php echo $value; ?>" style="width:100%">
			
		</div>
		<?php if($share == 'false'){ ?>
		<div style="margin-left:11px; margin-top:10px; margin-right:11px;" class="pure-g">
			<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=<?php echo $bookid; ?>">
				<input type="button" value="重新定制" class="button" style="color:white;border-radius:10px;width:115px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" />
			</a>
			<div class="pure-u-1-24"></div>
			<form class="pure-u-8-24"  action="http://www.babyinbook.com/babyinbook/interface.php/Index/DoAddCart/" method="post">
				<input type="hidden" name="bookid"  value="<?php echo $bookid; ?>" />
				<input type="hidden" name="name1" value="<?php echo $name1; ?>" />
				<input type="hidden" name="name2" value="<?php echo $name2; ?>" />
				<input type="hidden" name="url"  value="<?php echo $fpage['url']; ?>" />
				<input type="hidden" name="fpage"  value="<?php echo $id; ?>" />
				<input type="hidden" name="phone"  value="<?php echo $fpage['phone']; ?>" />
				<input type="hidden" name="openid"  value="<?php echo $fpage['openid']; ?>" />
				<button   style="font-size:14px;line-height:18px;color:white;border-radius:10px;width:100px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/redb.png');background-size:100%;" >
				￥：<?php echo file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getprice/bookid/{$bookid}"); ?><br/>加入购物车
				</button>
			</form>
			<!-- <div class="pure-u-6-24">
				<input type="button" value="加入书架" onclick="callpay()" class="button" style="color:white;border-radius:10px;width:105px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/redb.png');background-size:100%;"/>
			</div> -->
			<div class="pure-u-1-24"></div>
		</div>
		<?php }else{ ?>
			<div style="width:100%;text-align:center;">
			<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=<?php echo $bookid; ?>">
				<input type="button" value="前去定制"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" />
			</a>
			</div>
	<?php	}}} ?>
		<?php if(!empty($fpage['fpage'])){ ?>
				<!--样式-->
			<!--缓存有这么严重吗-->
			<div class="flipbook-viewport" style="display:none;">
<!--				<div class="previousPage"></div>-->
<!--				<div class="nextPage"></div>-->
<!--				<div class="return"></div>-->
				<img class="btnImg" src="http://www.babyinbook.com/babyinbook/images/btn.gif" style="display: none"/>
				<div class="container">
					<div class="flipbook">
					</div>
				</div>
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
				<a href="http://weixin.babyinbook.com/newindex/example/select.php?id=<?php echo $fpage['fpage']['bookid']; ?>"><input type="button" value="重新定制"  style="color:white;border-radius:10px;width:120px;height:40px;border:none;background:url('http://www.babyinbook.com/babyinbook/images/greb.png');background-size:100%;" /></a>
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
			<div style="width:100%;text-align:center;">
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
									var w=300;
									//var h = $(window).height();
									var h=600;
									$('.flipboox').width(w).height(h);
									$(window).resize(function () {
										//w = $(window).width();
										var w=300;
										//h = $(window).height();
										var h=600;
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
												} else {
													$(".btnImg").css("display", "block");
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
												} else {
													$(".return").css("display", "block");
													$(".btnImg").css("display", "block");
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
			</script>
</body>
</html>
