<?php

	header("Content-Type:text/html; charset=utf-8");

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$id1 = $_GET['bookid'];
	$id2 = $_GET['book2id'];
	$charset = mysql_query("set names utf8");
	$sql = "select * from bib_v1_bookinfo where id in ($id1,$id2)";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$book[] = $a;
	}
	print_r($book);

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
	<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
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
    margin-right: 30px;
    border-radius: 10px;

    background: rgb(252,128,99);
    float: left;
    text-align: center;
    line-height: 38px;
    font-family: 'Arial Negreta', 'Arial Normal', 'Arial';
    font-weight: 700;
    font-style: normal;
    font-size: 16px;
    color: #FFFFFF;
}
	</style>
</head>
<body >
	<div class="content content-home">
				<div style="width:100%"><img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $book[0]['pic']; ?>" style="width:100%;"></div>
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<div style="width:100%;margin-left:5px;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 18px;"><?php echo $book[0]['name']; ?></div><br/>
				<div style="width:100%;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 15px;">售价￥：<?php echo $book[0]['price']; ?></div>
				<p style="width:100%;letter-spacing:2px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;"><?php echo $book[0]['message']; ?></p>
				<div style="height:20px;clear:both"></div>
				</div>	
				<form action="make.php" method="get" style="width:80%;margin:0 auto;" >
				
				<input type="hidden" name="bookid"  value="<?php echo $id; ?>" />
				
				
				<input type="submit" value="开始定制" class="button"  />
				</form>
				<div style="height:20px;clear:both"></div>
				
				<div style="width:100%"><img src="http://www.babyinbook.com/babyinbook/Public/upload/1510753646.jpg" style="width:100%;"></div>
				<div style="margin-left:7px; margin-top:10px; margin-right:7px;" class="pure-g">
				<div style="width:100%;margin-left:5px;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 18px;">台历-《一年》无署名版</div><br/>
				<div style="width:100%;letter-spacing:2px;height:20px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 700;font-style: normal;font-size: 15px;">售价￥：98</div>
				<p style="width:100%;letter-spacing:2px;font-family: 'Arial Negreta', 'Arial Normal', 'Arial';font-weight: 400;font-style: normal;font-size: 15px;">2018年新品定制台历！</p>
				<div style="height:20px;clear:both"></div>
				</div>	
				<div style="height:20px;clear:both"></div>
				<form action="make1.php" method="get" style="width:80%;margin:0 auto;" >
				<input type="hidden" name="rolenum" id="rolenum" value="<?php echo $bookinfo['rolenum']; ?>" />
				<input type="hidden" name="bookid"  value="<?php echo $id; ?>" />
				
				
				<input type="submit" value="开始定制" class="button"  />
				</form>
			
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