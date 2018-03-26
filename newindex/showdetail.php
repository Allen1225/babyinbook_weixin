<?php
	header("Content-Type:text/html; charset=utf-8");

 ?>
<html>
<head>
	<meta charset="utf-8">
	<title>选择定制台历封面</title>
	<!-- Sets initial viewport load and disables zooming-->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
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
		<div style="height:10px;"></div>
		<div style="width:330px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/1.png" style="width:330px;" />
		</div>
		<div style="height:10px;"></div>
		<div style="width:330px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/2.gif" style="width:330px;" />
		</div>
		<div style="height:10px;"></div>
		<div style="width:330px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/3.gif" style="width:330px;" />
		</div>
		<div style="height:10px;"></div>
		<div style="width:330px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/4.gif" style="width:330px;" />
		</div>
		<div style="height:10px;"></div>
		<div style="width:330px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/5.png" style="width:330px;" />
		</div>
		
		
		
		
		
		
		
		
		
	</div>
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