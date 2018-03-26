<?php
	header("Content-Type:text/html; charset=utf-8");
	$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getBook");
	$book = json_decode($json,true);
	// var_dump($_SESSION['c_code']);die;
 ?>
<html>
<head>

	<meta charset="utf-8">
	<title>宝贝在书里 · 首页</title>
	<!-- Sets initial viewport load and disables zooming-->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!--<link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet">-->
	<link href="/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<!--<link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet">-->
	<link href="/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script src="http://www.babyinbook.com/babyinbook/js/unslider.min.js"></script>
<style>

html, body { font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;}

ul, ol { padding: 0;}



.banner { position: relative; overflow: auto; text-align: center;}

.banner li { list-style: none; }

.banner ul li { float: left; }

</style>	
</head>
<body>
<style>

#b06 { width: 640px;}

#b06 .dots { position: absolute; left: 0; right: 0; bottom: 0;}

#b06 .dots li 

{ 

	display: inline-block; 

	width: 10px; 

	height: 10px; 

	margin: 0 4px; 

	text-indent: -999em; 

	border: 2px solid #fff; 

	border-radius: 6px; 

	cursor: pointer; 

	opacity: .4; 

	-webkit-transition: background .5s, opacity .5s; 

	-moz-transition: background .5s, opacity .5s; 

	transition: background .5s, opacity .5s;

}

#b06 .dots li.active 

{

	background: #fff;

	opacity: 1;

}

#b06 .arrow { position: absolute; top: 50%;margin-top:-18px;}

#b06 #al { left: 15px;}

#b06 #ar { right: 15px;}

</style>





	
	<div class="content content-home">
		<div class="banner" id="b06">

    <ul style="margin:0px;	">
		<li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=65&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/index3-1.jpg" alt="" width="100%" ></a></li>

		<li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=66&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/index4-1.jpg" alt="" width="100%" ></a></li>
        

        <li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=64&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider4.jpg" alt="" width="100%" ></a></li>
        <!--<li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=61&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider3.png" alt="" width="100%" ></a></li>-->

        <li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=18&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider2.jpg" alt="" width="100%" ></a></li>

        <li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=11&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider1.jpg" alt="" width="100%" ></a></li>

       

    </ul>

    <a href="javascript:void(0);" class="unslider-arrow06 prev"><img class="arrow" id="al" src="http://www.babyinbook.com/babyinbook/images/arrowl.png" alt="prev" width="20" height="35"></a>

    <a href="javascript:void(0);" class="unslider-arrow06 next"><img class="arrow" id="ar" src="http://www.babyinbook.com/babyinbook/images/arrowr.png" alt="next" width="20" height="37"></a>

</div>
<script>

function imgReload()

{

	var imgHeight = 0;

	var wtmp = $("body").width();

	$("#b06 ul li").each(function(){

        $(this).css({width:wtmp + "px"});

    });

	$(".sliderimg").each(function(){

		$(this).css({width:wtmp + "px"});


		imgHeight = $(this).height();

	});

}



$(window).resize(function(){imgReload();});



$(document).ready(function(e) {

	imgReload();

    var unslider06 = $('#b06').unslider({

		dots: true,

		fluid: true

	}),

	data06 = unslider06.data('unslider');

	

	$('.unslider-arrow06').click(function() {

        var fn = this.className.split(' ')[1];

        data06[fn]();

    });

});

</script>
<div style="height:20px"></div>
		<div class="topnav pure-g">
			<div class="pure-u-2-24" style="margin-left:2.5%;"></div>
			<div class="pure-u-5-24">
				<div><a href="makebook.php"><img src="http://www.babyinbook.com/babyinbook/images/mkbook.png" style="width:100%" /></a></div>
				<div style="font-size:15px;line-height:30px;width:100%;height:20px;font-family: 微软雅黑;text-align: center">定制绘本</div>
			</div>
			<div class="pure-u-2-24"></div>
			<div class="pure-u-5-24">
				<div><a href="cand.php"><img src="http://www.babyinbook.com/babyinbook/images/mkcand.png" style="width:100%" /></a></div>
				<div style="font-size:15px;line-height:30px;width:100%;height:30px;font-family: 微软雅黑;text-align: center">定制台历</div>
			</div>
			<div class="pure-u-2-24"></div>
			<div class="pure-u-5-24">
				<div><a href="https://weidian.com/?userid=1222434488&wfr=wx_wxh5&ifr=shopdetail&share_relation=533cdf8e4d83d095_435454623_2&from=singlemessage&isappinstalled=0"><img src="http://www.babyinbook.com/babyinbook/images/wxshop.png" style="width:100%" /></a></div>
				<div style="font-size:15px;line-height:30px;width:100%;height:30px;font-family: 微软雅黑;text-align: center">微信小店</div>
			</div>
			<div class="pure-u-2-24"></div>
		</div>


		
		<!-- <div style="width:100%;">
			<img style="width:100%;margin-top:10px;" src="http://www.babyinbook.com/babyinbook/images/border1.png" />
		</div>
		<a href="./example/chose_make.php">
			<div style="width:100%;padding-top:2px;padding-bottom: 2px;">
				<img style="width:90%;margin-left:5%;" src="http://www.babyinbook.com/babyinbook/img/index_0.png" />
			</div>
		</a> -->



		<div style="width:100%;">
			<img style="width:100%;margin-top:10px;" src="http://www.babyinbook.com/babyinbook/images/border2.png" />
		</div>
				<div style="padding-bottom:2px;margin-left:7px; margin-right:7px;" class="pure-g">
					<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=65&a=1" >
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/index65-1.jpg?v=1" class="img-responsive">
						</a>
					</div>

					<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=66&a=1" >
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/index66-1.jpg?v=1" class="img-responsive">
						</a>
					</div>


					<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=64&a=1" >
					<img src="http://www.babyinbook.com/babyinbook/Public/upload/index64-1.jpg?v=1" class="img-responsive">
				</a>
				</div>	
				<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=11&a=1" >
					<img src="http://www.babyinbook.com/babyinbook/Public/upload/index11-1.jpg" class="img-responsive">
				</a>
				</div>	
<!--				<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">-->
<!--				<a href="./example/select.php?id=59&a=1" >-->
<!--					<img src="http://www.babyinbook.com/babyinbook/Public/upload/index59.png" class="img-responsive">-->
<!--				</a>-->
<!--				</div>	-->
				<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=18&a=1" >
					<img src="http://www.babyinbook.com/babyinbook/Public/upload/index18-1.jpg" class="img-responsive">
				</a>
				</div>	
				<div style="margin-left:7px; margin-top:5px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=61&a=1" >
					<img src="http://www.babyinbook.com/babyinbook/Public/upload/index61-1.jpg" class="img-responsive">
				</a>
				</div>
				
				
	</div>
	<div style="width:100%;">
			<img style="width:100%;margin-top:10px;" src="http://www.babyinbook.com/babyinbook/images/border4.png" />
		</div>
		<div style="width:100%;padding-top:2px;padding-bottom: 2px;">
			<a href="https://weidian.com/?userid=1222434488&wfr=wx_wxh5&ifr=shopdetail&share_relation=533cdf8e4d83d095_435454623_2&from=singlemessage&isappinstalled=0"><img style="width:90%;margin-left:5%;" src="http://www.babyinbook.com/babyinbook/images/other.png" />
		</a></div>
	</div>
	<div id="modalShareVersion" style="z-index: 1080;" class="modal">
		<div style="background-image: url(http://www.babyinbook.com/babyinbook/img/background.png);background-repeat: repeat;" class="content">
			<header style="background: #90CE27;" class="bar bar-nav">
				
				<h1 style="color: #FFF" class="title">Hello，我是平装分享版哦</h1>
			</header>
			<img src="http://www.babyinbook.com/babyinbook/img/share_version.png" style="margin-top:44px;margin-bottom:20px;" class="img-responsive">
			<div class="pure-g">
				<div class="pure-u-5-24"></div>
				
				<div class="pure-u-5-24"></div>
			</div></div></div>
			<nav class="bar" style='bottom: 50px;background-color:transparent;'> 
	<a href="/newindex/example/customer.php"><img style="height:30px;float:right" src="http://www.babyinbook.com/babyinbook/images/customer.png"></a>
	</nav>
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
</body>
</html>
