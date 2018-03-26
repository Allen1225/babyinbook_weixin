<?php

header("Content-type: text/html; charset=utf-8");

$url = $_POST['url'];
$json = file_get_contents($url);

$res = json_decode($json,true);
//var_dump($res);
//array_pop($res);
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>宝贝在书里 · 定制</title>
		<!-- Sets initial viewport load and disables zooming-->
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
		<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link href="/css/pure-min.css" rel="stylesheet">
		<!-- Include the compiled Ratchet CSS-->
		<link href="/css/ratchet.min.css" rel="stylesheet">
		<!-- Include the Awesome Font CSS-->
		<link href="/css/font-awesome.min.css" rel="stylesheet">
		<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
		<link href="http://www.babyinbook.com/babyinbook/css/magazine.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="http://www.babyinbook.com/babyinbook/css/basic.css?v=<?php echo rand(1,999)?>"/>
		<!-- Include the compiled Ratchet JS-->
		<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
		<script src="http://www.babyinbook.com/babyinbook/js/turn/jquery.min.1.7.js"></script>
		<script src="http://www.babyinbook.com/babyinbook/js/turn/turn.min.js"></script>
		<script src="http://www.babyinbook.com/babyinbook/js/turn/zoom.min.js"></script>
		<script src="http://www.babyinbook.com/babyinbook/js/newmagazine.js"></script>
		<script type="text/javascript" src="http://www.babyinbook.com/babyinbook/js/modernizr.2.5.3.min.js?v=<?php echo rand(1,999)?>"></script>
	</head>
<body >

	<div class="content">

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


		<div style="width:100%;padding:8px;background:#f8f5f5;display: none" class="img" >
			<?php foreach($res as $key=>$value){ ?>
				<div style="width:100%">
					<img src="<?php echo $value;?>" style="width:100%">
				</div>
		<?php } ?>
			</div>
	</div>
	<nav class="bar bar-tab">
				<a href="/newindex/index.php" class="tab-item ">
					<span class="icon icon-home"></span>
					<span class="tab-label">首页</span>
				</a>
				<a href="/newindex/example/user.php" class="tab-item">
					<span class="icon icon-person"></span>
					<span class="tab-label">我的</span>
				</a>
				<a href="/newindex/example/cart.php" class="tab-item active">
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
		var imglength=$(".img").children("div").length;
		var src;
		for(var j=0;j<imglength;j++){
			src=$(".img").children("div").eq(j).children("img").attr("src");
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
	</script>
</body>

</html>
