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
		<div style="height:10px;"></div>
		<div style="width:330px;height:190px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/title.png" style="width:330px;height:190px;" />
			
		</div>
		
		
		<!-- 波谱A -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand1.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=50&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=51&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 波谱B -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand2.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=41&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=42&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 繁花 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand3.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=37&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=49&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 一年 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand4.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=48&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=25&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 糖果森林 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand5.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=29&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=43&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 彩虹独角兽 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand6.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=44&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=45&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 几何 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand7.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=46&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=47&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
		</div>
		
		<!-- 青花 -->
		<div style="height:10px;"></div>
		<div style="width:330px;height:125px;margin:0 auto;position: relative;">
			<img src="http://www.babyinbook.com/babyinbook/images/cand/cand8.png" style="width:330px;height:125px;" />
			<a href="example/select.php?id=39&"><img src="http://www.babyinbook.com/babyinbook/images/cand/name.png" style="width:90px;height:30px;position:absolute;bottom:70px;left:195px;" /></a>
			<a href="example/select.php?id=40&"><img src="http://www.babyinbook.com/babyinbook/images/cand/noname.png" style="width:90px;height:30px;position:absolute;bottom:25px;left:195px;" /></a>
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
