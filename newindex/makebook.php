<?php
	header("Content-Type:text/html; charset=utf-8");
	$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getBook");
	$book = json_decode($json,true);
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
	<link href="/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>

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

		<li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=65&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/index3.jpg" alt="" width="100%" ></a></li>

		<li><a href="http://weixin.babyinbook.com/newindex/example/select.php?id=66&a=1"><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/index4.jpg" alt="" width="100%" ></a></li>

        <li><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider4.jpg" alt="" width="100%" ></li>
        <!--<li><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider3.png" alt="" width="100%" ></li>-->

        <li><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider1.png" alt="" width="100%" ></li>

        <li><img class="sliderimg" src="http://www.babyinbook.com/babyinbook/images/slider2.png" alt="" width="100%" ></li>

       

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
		
		
		<div style="width:100%;">
			<img style="width:100%;" src="http://www.babyinbook.com/babyinbook/images/border2.png" />
		</div>
				<div style="padding-bottom:2px;margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				
				<?php foreach($book as $key => $value){ ?>
				<!-- <div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=<?php echo $value['id']; ?>" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="img-responsive"></a>
				</div>	-->
				<?php } ?>
					<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=65&a=1" >
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/index65-1.jpg?v=1" class="img-responsive">
						</a>
					</div>

					<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=66&a=1" >
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/index66-1.jpg?v=1" class="img-responsive">
						</a>
					</div>

				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
                                                <a href="./example/select.php?id=64" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/index64-1.jpg" class="img-responsive"></a>
                                        </div>

				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
					<a href="./example/select.php?id=11" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/index11-1.jpg" class="img-responsive"></a>
				</div>
				<!--<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
                                                <a href="./example/select.php?id=59" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/index59.png" class="img-responsive"></a>
                                        </div>-->

				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=18" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/index18-1.jpg" class="img-responsive"></a>
					</div>
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
						<a href="./example/select.php?id=61" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/index61-1.jpg" class="img-responsive"></a>
					</div>
					
				
	</div>
	
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
