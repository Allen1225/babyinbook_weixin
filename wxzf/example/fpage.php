<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
$member = $_SESSION['member'];
if(empty($member[0]['m_wechat_openid'])){
		header('Location: http://weixin.babyinbook.com/signup');
}
if(empty($_POST['url'])){
	header('Location: http://weixin.babyinbook.com/newindex/index.php');
}


$url = $_POST['url'];

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

	</style>
</head>
<body bgcolor="rgb(242,242,242)">
	<div class="content content-home">
		<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/DoUpdateRole/" method="post">
		<div style="height:20px"></div>
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne" onchange="preImg(this.id,'imgPre',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre" src="http://www.babyinbook.com/babyinbook/images/back.png" style="border-radius:50px;width:100px;height:100px;position:absolute;top:0px;left:0px;" />    
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在故事中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png，大小限制在2m以内</font>
			</div>
		</div>
		<div style="height:20px;clear:both"></div>
		
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />写一段话送给亲爱的宝贝吧：</div>
		
		<input class="form-input" id="title" type="text" name="title" style="margin-left:20px;width:300px;" value="亲爱的宝贝"/>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />写给宝贝的话  （限200字内）</div>
		<textarea class="form-input" type="text" id="text" name="text" style="margin-left:20px;width:300px;height:150px;" /></textarea>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />留言人</div>
		<input class="form-input" type="text" id="member" name="member" style="margin-left:20px;width:300px;" value="爱你的爸爸妈妈"/>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />日期</div>
		<input class="form-input" type="date" value="<?php echo date("Y-m-d"); ?>" name="date" style="margin-left:20px;width:300px;"/>
		<div style="height:10px;"></div>
		<input type="hidden" name="phone" value="<?php echo $member[0]['m_account']; ?>">
		<input type="hidden" name="openid" value="<?php echo $member[0]['m_wechat_openid']; ?>">
		<input type="hidden" name="url" value="<?php echo $url; ?>">
		<div style="position: relative">
		<input style="position:absolute;left:50%;width:100px;margin-left:-50px;" type="submit" value="生成扉页" class="button" />
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
