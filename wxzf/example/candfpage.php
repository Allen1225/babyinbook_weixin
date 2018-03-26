<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
$member = $_SESSION['member'];

$url = $_POST['url'];

$bookid=$_POST['bookid'];

 ?>
<html>
<head>
	<meta charset="utf-8">
	<title>宝贝在书里 · 定制扉页</title>
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
    border: 1px solid #BCBCBC;
    background: rgb(154,204,74);
    float: left;
    text-align: center;
    line-height: 38px;
    font-family: 'Arial Negreta', 'Arial Normal', 'Arial';
    font-weight: 700;
    font-style: normal;
    font-size: 16px;
    color: #FFFFFF;
}
	.up-img{
		height:120px;
	}
.a-upload {
   
    width: 28px;
  	height:28px;
    position: relative;
    top:36px;
    left:36px;

    cursor: pointer;
    color: #888;
    background-image: url("http://www.babyinbook.com/babyinbook/images/add.png");


    overflow: hidden;
    display: inline-block;
    *display: inline;
    *zoom: 1;
    z-index:9999;
}

.a-upload  input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
    filter: alpha(opacity=0);
    cursor: pointer
}
.form-input {
    border: 1px solid #ccc;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    height: 20px;
    box-shadow: 1px 1px 8px #dddddd inset;
    margin-top:10px;
    margin-left:20px;
}
.fo{
	font-size: 15px;
	color:rgb(169,209,99);
	font-family:'微软雅黑';
}
.dateselect{
	width:80%;
	margin-left:10%;
	height:30px;
	border-radius:5px;
	border:1px solid #ccc;
	padding-left:10px;
	line-height:30px;
	
}

	</style>
</head>
<body bgcolor="rgb(242,242,242)">
	<div class="content content-home">
		<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/calendar" method="post"><!-- kaishi -->
		<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
<!-- kaishi -->
<!-- 一月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">一月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne" onchange="preImg(this.id,'imgPre',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv1" id="datediv1" >
			<select name="Jan[]" class="dateselect1 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect1','datediv1','Jan[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 2月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">二月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne2" onchange="preImg(this.id,'imgPre2',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre2" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv2" id="datediv2" >
			<select name="Feb[]" class="dateselect2 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=28;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect2','datediv2','Feb[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 3月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">三月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne3" onchange="preImg(this.id,'imgPre3',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre3" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv3" id="datediv3" >
			<select name="Mar[]" class="dateselect3 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect3','datediv3','Mar[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 4月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">四月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne4" onchange="preImg(this.id,'imgPre4',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre4" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv4" id="datediv4" >
			<select name="Apr[]" class="dateselect4 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=30;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect4','datediv4','Apr[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 5月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">五月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne5" onchange="preImg(this.id,'imgPre5',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre5" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv5" id="datediv5" >
			<select name="May[]" class="dateselect5 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect5','datediv5','May[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 6月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">六月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne6" onchange="preImg(this.id,'imgPre6',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre6" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv6" id="datediv6" >
			<select name="Jun[]" class="dateselect6 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=30;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect6','datediv6','Jun[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 7月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">七月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne7" onchange="preImg(this.id,'imgPre7',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre7" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv7" id="datediv7" >
			<select name="Jul[]" class="dateselect7 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect7','datediv7','Jul[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 8月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">八月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne8" onchange="preImg(this.id,'imgPre8',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre8" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv8" id="datediv8" >
			<select name="Aug[]" class="dateselect8 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect8','datediv8','Aug[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 9月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">九月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne9" onchange="preImg(this.id,'imgPre9',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre9" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv9" id="datediv9" >
			<select name="Seb[]" class="dateselect9 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=30;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect9','datediv9','Seb[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 10月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">十月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne10" onchange="preImg(this.id,'imgPre10',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre10" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv10" id="datediv10" >
			<select name="Oct[]" class="dateselect10 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect10','datediv10','Oct[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!-- 11月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">十一月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne11" onchange="preImg(this.id,'imgPre11',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre11" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv11" id="datediv11" >
			<select name="Nov[]" class="dateselect11 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=30;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect11','datediv11','Nov[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

		<!--12月 -->
		<div style="height:20px"></div>
		<div style="height:30px;width:80%;margin-left:10%;">十二月份</div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne12" onchange="preImg(this.id,'imgPre12',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre12" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:5px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:rgb(215,215,215)" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<div style="width:100%" class="datediv12" id="datediv12" >
			<select name="Dec[]" class="dateselect12 dateselect">
			<option>不选择</option>
				<?php for($i=1;$i<=31;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
			
		</div>
		<div onclick="adddiv('dateselect12','datediv12','Dec[]')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>
<!-- jieshu -->		
		
		<input type="hidden" name="phone" value="<?php echo $member[0]['m_account']; ?>">
		<input type="hidden" name="openid" value="<?php echo $member[0]['m_wechat_openid']; ?>">
		<input type="hidden" name="url" value="<?php echo $url; ?>">
		<input type="hidden" name="bookid" value="<?php echo $bookid; ?>">
		<div style="position: relative">
		<input style="position:absolute;left:50%;width:100px;margin-left:-50px;" type="submit" value="生成" class="button" />
		</div>
		<div style="height:30px;"></div>
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
			<script type="text/javascript">
	function checkform(){
		var title_len = document.getElementById("title").value;
		
		if(title_len.length > 10){
			alert("被寄语人名字长度不可超过10字！");
			return false;
		}
		var text_len = document.getElementById("text").value;
		if(title_len.length > 200){
			alert("寄语不可超过200字！");
			return false;
		}
		var member_len = document.getElementById("member").value;
		if(member_len.length > 10){
			alert("留言人名不可超过10字！");
			return false;
		}
	
	}
	function adddiv(x,y,z){
		  var a = document.getElementsByClassName(x); 
		  var b = document.getElementById(y);
		if(a.length <=3){
			var option = "";
				<?php for($i=1;$i<=31;$i++){ ?>
				option = option + "<option value='<?php echo $i; ?>'><?php echo $i . '号'; ?></option>"
				<?php } ?>
			b.innerHTML = b.innerHTML + "<select name='"+z+"' class='"+x+" dateselect'><option>不选择</option>"+option+"</select>";
		}
		  
	}
	function preImg(sourceId, targetId,file) { 
	var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' & suffix != 'JPG' && suffix != 'PNG')
        {  
           alert(suffix);//不是图片，做处理
          	$(file).val("");
           return false;
        }  	
		
	var fileSize = file.files[0].size;

    if (fileSize > 2097152) {
        alert("文件大小不能超过2M，请重新选择文件"); // 提示消息
        $(file).val(""); // 清空已选择的文件
        return false;

    }	
		
		 
    if (typeof FileReader === 'undefined') {  
        alert('Your browser does not support FileReader...');  
        return;  
    }  
    var reader = new FileReader();  
  
    reader.onload = function(e) {  
        var img = document.getElementById(targetId);  
        img.src = this.result;  
    }  
    reader.readAsDataURL(document.getElementById(sourceId).files[0]);  
}  

  function getFilesize(file) { //如果上传文件，会触发

        /*（1）判断文件后缀类型*/
        var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png')
        {  
           alert("您选择的不是图片，请上传一个图片");//不是图片，做处理
           return false;
        }  

        /*(2)获取文件大小，以Kb为单位*/
        fileSize = file.files[0].size / 1024;
        if (fileSize > 2048) {
            alert("您选择的图片太大，请选择小于2M的图片");       
        }  

    }
    
    
    function getOrientation(file, callback) {
  var reader = new FileReader();
  reader.onload = function(e) {

    var view = new DataView(e.target.result);
    if (view.getUint16(0, false) != 0xFFD8) return callback(-2);
    var length = view.byteLength, offset = 2;
    while (offset < length) {
      var marker = view.getUint16(offset, false);
      offset += 2;
      if (marker == 0xFFE1) {
        if (view.getUint32(offset += 2, false) != 0x45786966) return callback(-1);
        var little = view.getUint16(offset += 6, false) == 0x4949;
        offset += view.getUint32(offset + 4, little);
        var tags = view.getUint16(offset, little);
        offset += 2;
        for (var i = 0; i < tags; i++)
          if (view.getUint16(offset + (i * 12), little) == 0x0112)
            return callback(view.getUint16(offset + (i * 12) + 8, little));
      }
      else if ((marker & 0xFF00) != 0xFF00) break;
      else offset += view.getUint16(offset, false);
    }
    return callback(-1);
  };
  reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
}


			</script>
</body>
</html>
