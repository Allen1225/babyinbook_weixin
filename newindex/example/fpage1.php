<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
$member = $_SESSION['member'];

if(empty($_POST['url'])){
	header('Location: http://weixin.babyinbook.com/newindex/index.php');
}
$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/GetBookInfo/id/{$_POST['bookid']}");
$res = json_decode($json,true);


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
   
    width: 100px;
  	height:100px;
    position: relative;
    /*top:31px;
    left:31px;*/
    cursor: pointer;
    color: #888;
    /*background-image: url("http://www.babyinbook.com/babyinbook/images/add.png");*/
	background-size:100%;

    overflow: hidden;
    display: inline-block;
    *display: inline;
    *zoom: 1;
    z-index:9900;
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
	<style>

#clipArea {
	margin: 20px;
	height: 300px;
}
#file,
#clipBtn {
	margin: 20px;
}
#view {
	margin: 0 auto;
	width: 400px;
	height: 400px;
}
/*遮罩层 begin 2016-6-14 13:22:20*/
.floatLayer{ width:100%; height:100%; position:fixed; background:white;  z-index:9990; top:0px; left:0px;}
.liadloging{ width:400px; height:400px; position:absolute; top:35%;margin-left:-200px;margin-top:-200px; left:50%; z-index:9995;  }

/*遮罩层 begin*/
</style>
</head>
<body bgcolor="rgb(242,242,242)">
	
	<div class="content content-home">
		



<!--		<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/wapDoUpdateRole1/" method="post">-->
		<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/DoUpdateRole1/" method="post">

		<div style="height:20px"></div>
		<div id="liadloging" class="liadloging" style="display:none;">
	    	<div class="ldl_Conten">
	      		 <div class="load" style="width:400px;height:400px;background-color:white;">
					<div id="clipArea"></div>
					<div style="width:100%;text-align: center;">
						双指捏住图片-放大或者缩小<br/> 两指顺/逆时针转动-旋转图片
					</div>
					
					<div style="width:100%;text-align: center;">
						<input type="button" style="width:100px" id="clipBtn" value="确定" />
						<input type="button" style="width:100px" onclick="cancelpay();" value="取消" />
					</div>
				</div>
			</div>
		</div>
		<div id="floatLayer" class="floatLayer" style="display:none;"></div> 
		<div class="up-img">
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input onchange="preImg(this.id,'imgPre',this);"   name="file[]" type="file" id="file">
			</a>
			<input type="hidden" name="baseimg" id="baseimg" value="" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo !empty($_SESSION['user_id'])?$_SESSION['user_id']:'0';?>" />
			 <div id="view" style="border-radius:50px;width:100px;height:100px;position:absolute;top:0px;left:0px;background:url('http://www.babyinbook.com/babyinbook/images/back2.png')" ></div>
			</div>
			<div style="padding-top:15px;height:100px;width:220px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在故事中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png</font>
			</div>
		</div>
		<div style="height:20px;clear:both"></div>
		
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />写一段话送给亲爱的宝贝吧：</div>
		
		<input class="form-input" id="title" type="text" name="title" style="margin-left:20px;width:300px;color:#ccc;" value="亲爱的<?php echo $_POST['name']; ?>"/>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />写给宝贝的话  （限90字内）</div>
		<textarea class="form-input" type="text" id="text" name="text" style="line-height:30px;margin-left:20px;width:300px;height:150px;color:#ccc;" /><?php echo $res[0]['defaultfpage']; ?></textarea>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />留言人</div>
		<input class="form-input" type="text" id="member" name="member" style="margin-left:20px;width:300px;color:#ccc;" value="爱你的爸爸妈妈"/>
		<div style="height:10px;"></div>
		<div class="fo" style="margin-left:20px;border-bottom: 1px solid #ccc;width:90%;"><img style="width:10px;margin-top:8px;" src="http://www.babyinbook.com/babyinbook/images/line.png" />日期</div>
		<input class="form-input" type="date" value="<?php echo date("Y-m-d"); ?>" name="date" style="margin-left:20px;width:300px;"/>
		<div style="height:10px;"></div>
		<input type="hidden" name="phone" value="<?php echo $member[0]['m_account']; ?>">
		<input type="hidden" name="openid" value="<?php echo $member[0]['m_wechat_openid']; ?>">
		<input type="hidden" name="url" value="<?php echo $url; ?>">
		<input type="hidden" name="user_id" value="<?php echo $member[0]['m_id']; ?>">
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
			function cancelpay(){
	document.getElementById("liadloging").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
	$("body").css({overflow:""});
}

	function checkform(){
		var title_len = document.getElementById("title").value;
		
		if(title_len.length > 10){
			alert("被寄语人名字长度不可超过10字！");
			return false;
		}
		var text_len = document.getElementById("text").value;
		if(text_len.length > 90){
			alert("寄语不可超过90字！");
			return false;
		}
		var member_len = document.getElementById("member").value;
		if(member_len.length > 10){
			alert("留言人名不可超过10字！");
			return false;
		}
		var png = document.getElementById("file").value;
		if(!png){
			var truthBeTold = confirm("照片未上传，默认为选择角色的头像"); 
			if (!truthBeTold) { 
				return false;
			}
		}
	
	}
	function preImg(sourceId, targetId,file) { 
	var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' & suffix != 'JPG' && suffix != 'PNG' && suffix != 'JPEG' && suffix != 'jpeg')
        {  
           alert("您选择的不是图片，请上传一个格式为JPG或者PNG的图片");//不是图片，做处理
          	$(file).val("");
           return false;
        }  	
		
	var fileSize = file.files[0].size;

 
		
		 
    
}  

  function getFilesize(file) { //如果上传文件，会触发

        /*（1）判断文件后缀类型*/
        var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' & suffix != 'JPG' && suffix != 'PNG' && suffix != 'JPEG' && suffix != 'jpeg')
        {  
           alert("您选择的不是图片，请上传一个图片");//不是图片，做处理
           return false;
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
			

<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/hammer.min.js"></script>
<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/iscroll-zoom-min.js"></script>
<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/lrz.all.bundle.js"></script>

<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/PhotoClip.js"></script>

<script>
	var pc = new PhotoClip('#clipArea', {
		size: 260,
		outputSize: 640,
		//adaptive: ['60%', '80%'],
		file: '#file',
		view: '#view',
		ok: '#clipBtn',
		//img: 'img/mm.jpg',
		loadStart: function() {
			console.log('开始读取照片');
		},
		loadComplete: function() {
	document.getElementById("liadloging").style.display="block";
	document.getElementById("floatLayer").style.display="block";	
	$("body").css({overflow:"hidden"});
		},
		done: function(dataURL) {
			document.getElementById("baseimg").value = dataURL;
			document.getElementById("liadloging").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
	$("body").css({overflow:""});
		},
		fail: function(msg) {
			alert(msg);
		}
	});



</script>
</body>
</html>
