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
	<link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet">
	<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
</head>
<body>
	<div class="content content-home">
		<div onclick="this.style.display='none';document.getElementsByTagName('video')[0].play()" class="poster">
			<img src="/img/poster.jpg" style="width:100%"></div><video controls="true" width="100%" preload="none">
				<source src="/video/intro.mp4" type="video/mp4">               您的浏览器不支持视频播放。</video>
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				
				<?php foreach($book as $key => $value){ ?>
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<a href="./example/select.php?id=<?php echo $value['id']; ?>" ><img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="img-responsive"></a>
				</div>	
				<?php } ?>	
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<a href="http://mp.weixin.qq.com/bizmall/mallshelf?id=&amp;t=mall/list&amp;biz=MzIzMzExMTU0NQ==&amp;shelf_id=1&amp;showwxpaytitle=1#wechat_redirect"><img src="/img/taotao_banner.png" class="img-responsive"></a>
				</div>
	</div></div>
	<div id="modalShareVersion" style="z-index: 1080;" class="modal">
		<div style="background-image: url(/img/background.png);background-repeat: repeat;" class="content">
			<header style="background: #90CE27;" class="bar bar-nav">
				
				<h1 style="color: #FFF" class="title">Hello，我是平装分享版哦</h1>
			</header>
			<img src="/img/share_version.png" style="margin-top:44px;margin-bottom:20px;" class="img-responsive">
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