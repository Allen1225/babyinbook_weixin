<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
$member = $_SESSION['member'];
$id = $_GET['id'];
$url = $_GET['url'];

$bookid=$_GET['bookid'];
$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getdata.html?id=1111&page=1");

$fpage = json_decode($json,true);
var_dump($fpage);
var_dump($fpage->res->id);

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
	<link href="/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
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
		    width: 38px;
		  	height:38px;
		    position: relative;
		    top:24px;
		    left:40px;
		    cursor: pointer;
		    color: #888;
		    background-image: url("http://www.babyinbook.com/babyinbook/images/add.png");
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
	<style>
	<?php for($i=1;$i<=12;$i++){ ?>
		#clipArea<?php echo $i; ?> {
			height: 300px;
		}
		#file<?php echo $i; ?>,
		#clipBtn<?php echo $i; ?> {
			margin: 20px;
		}
	<?php } ?>

		
		/*遮罩层 begin 2016-6-14 13:22:20*/
		.floatLayer{ width:100%; height:100%; position:fixed; background:white;  z-index:9990; top:0px; left:0px;}
		.liadloging{ width:600px; height:400px; position:fixed; top:50%;margin-left:-300px;margin-top:-200px; left:50%; z-index:9995;  }		
		/*遮罩层 begin*/
	</style>
</head>
<body bgcolor="rgb(242,242,242)">
	<div class="content content-home">
		<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/save" method="post"><!-- kaishi -->
		<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
		<input type="hidden" name="upfile" value="" />
<!-- kaishi -->
<!-- 一月 -->
		<div style="height:20px"></div>
		<div id="moonth" style="height:30px;width:80%;margin-left:10%;">一月份</div>
		<div id="liadloging1" class="liadloging" style="display:none;">
	    	<div class="ldl_Conten">
	      		 <div class="load" style="width:600px;height:400px;background-color:white;">
					<div id="clipArea1"></div>
					<div style="width:100%;text-align: center;">
						双指捏住图片-放大或者缩小<br/> 两指顺/逆时针转动-旋转图片
					</div><div style="width:100%;text-align: center;">
						<input type="button" style="width:100px" id="clipBtn1" value="确定" />
						<input type="button" style="width:100px" onclick="cancelpay(1);" value="取消" />
					</div>
				</div>
			</div>
		</div>
		<div id="floatLayer1" class="floatLayer" style="display:none;"></div>
		<div class="up-img">
			<div style="margin-top:10px;width:118px;height:85px;border-radius:5px;margin-left:20px;position: relative;background: #ccc;float:left">
			<a href="javascript:;" class="a-upload">
    					<input onchange="preImg(this.id,'imgPre',this);"   name="file[]" type="file" id="file1">
			</a>
			<input type="hidden" name="baseimg1" id="baseimg1" value="" />
			 <div id="view1" style="<?php if(!empty($pic)){echo 'background-image: '.$pic;}?>；border-radius:5px;width:118px;height:85px;position:absolute;top:0px;left:0px;" ></div>    
			</div>
			<div style="padding-top:15px;height:100px;width:200px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传宝贝的照片，放在日历中哦！</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png</font>
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

<!-- jieshu -->		
		
		<input type="hidden" name="phone" value="<?php echo $member[0]['m_account']; ?>">
		<input type="hidden" name="openid" value="<?php echo $member[0]['m_wechat_openid']; ?>">
		<input type="hidden" name="url" value="<?php echo $url; ?>">
		<input type="hidden" name="bookid" value="<?php echo $bookid; ?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<div style="position: relative">
		<input style="position:absolute;left:50%;width:100px;margin-left:-50px;" type="submit" value="下一步" class="button"/>
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
		
		  var a = $("." + x); 
		  var b = $("#" + y);
		if(a.length <=3){
			var option = "";
				<?php for($i=1;$i<=31;$i++){ ?>
				option = option + "<option value='<?php echo $i; ?>'><?php echo $i . '号'; ?></option>"
				<?php } ?>
			b.append("<select name='"+z+"' class='"+x+" dateselect'><option>不选择</option>"+option+"</select>");
		}else{
			alert("特殊日期最多只能选4个！");
		}
		  
	}
	function preImg(sourceId, targetId,file) { 
	var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' & suffix != 'JPG' && suffix != 'PNG' && suffix != 'jpeg' && suffix != 'JPEG')
        {  
           alert(suffix);//不是图片，做处理
          	$(file).val("");
           return false;
        }  	
		


		

}  

  function getFilesize(file) { //如果上传文件，会触发

        /*（1）判断文件后缀类型*/
        var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' && suffix != 'JPG' && suffix != 'PNG' && suffix != 'jpeg' && suffix != 'JPEG')
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
			<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/hammer.min.js"></script>
<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/iscroll-zoom-min.js"></script>
<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/lrz.all.bundle.js"></script>

<script src="http://www.babyinbook.com/babyinbook/Photo/demo/js/PhotoClip.js"></script>

<script>

	<?php for($i=1;$i<=12;$i++){ ?>
	var pc<?php echo $i; ?> = new PhotoClip('#clipArea<?php echo $i; ?>', {
		size: [294, 213],
		outputSize: [1179, 852],
		//adaptive: ['60%', '80%'],
		file: '#file<?php echo $i; ?>',
		view: '#view<?php echo $i; ?>',
		ok: '#clipBtn<?php echo $i; ?>',
		//img: 'img/mm.jpg',
		loadStart: function() {
			console.log('开始读取照片');
		},
		loadComplete: function() {
			document.getElementById("liadloging<?php echo $i; ?>").style.display="block";
			document.getElementById("floatLayer<?php echo $i; ?>").style.display="block";	
			$("body").css({overflow:"hidden"});
		},
		done: function(dataURL) {
			document.getElementById("baseimg<?php echo $i; ?>").value = dataURL;
			document.getElementById("liadloging<?php echo $i; ?>").style.display="none";
			document.getElementById("floatLayer<?php echo $i; ?>").style.display="none";	
			$("body").css({overflow:""});
		},
		fail: function(msg) {
			alert(msg);
		}
	});
	<?php } ?>


			function cancelpay(x){
				var id = "liadloging" + x
	document.getElementById(id).style.display="none";
				id = "floatLayer" + x
	document.getElementById(id).style.display="none";	
	$("body").css({overflow:""});
}

</script>

</body>
</html>