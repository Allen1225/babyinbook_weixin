<?php

	header("Content-Type:text/html; charset=utf-8");

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$id = $_GET['id'];
	$charset = mysql_query("set names utf8");
	$sql = "select *,t1.price as ordercost from bib_v1_order_detail t1 left join bib_v1_fpage t2 on t1.fpage = t2.id left join bib_v1_bookinfo t3 on t1.bookid = t3.id where t1.id = $id";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$book[] = $a;
	}
	print_r($book);

 ?>
<html>
<head>
	<meta charset="utf-8">
	<title>宝贝在书里 · 售后</title>
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
   
    width: 28px;
  	height:28px;
    position: relative;
    top:36px;
    left:13px;

    cursor: pointer;
    color: #888;
    background-image: url("http://www.babyinbook.com/babyinbook/images/add.png");


    overflow: hidden;
    display: inline-block;
    *display: inline;
    *zoom: 1;
    z-index:8999;
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
/*遮罩层 begin 2016-6-14 13:22:20*/
.floatLayer{ width:100%; height:100%; position:fixed; background:#000;  z-index:9990; top:0px; left:0px;filter:alpha(Opacity=50);-moz-opacity:0.50;opacity: 0.50;}
.liadloging{ width:100%; height:400px; position:absolute; top:50%;margin-top:-200px;  z-index:9995;  }
.liadloging1{ width:100%; height:400px; position:absolute; top:50%;margin-top:-200px;  z-index:9995;  }

/*遮罩层 begin*/
	</style>
</head>
<body >
<form onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/AfterSales/" method="post">
	<input type="hidden" name="id" value="<?php echo $id; ?>" />	
	<input type="hidden" name="orderid" value="<?php echo $_GET['orderid']; ?>" />	
			<div id="liadloging" class="liadloging" style="display:none;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:100%;height:200px;background-color:white;">
	<div style="background-color:rgb(251,125,100);padding-left:20px;line-height:50px;height:50px;color:white;font-size:25px;font-weight: bolder;">选择货物状态</div><br/>
	<div style="width:200px;margin:0 auto;height:50px;">
		<input onclick="changesendstatus('yes');" value="已收到货" type="radio" name="sendstatus" />已收到货
		<input onclick="changesendstatus('no');" value="未收到货" type="radio" name="sendstatus" />未收到货
	</div>
	<div onclick="cancelpay();" style="margin-left:35%;margin-top:20px;width:120px;height:30px;line-height:30px;text-align:center;float:left;background-color:red;color:white;">确定</div>
	</div>
    </div>
</div>


<div id="liadloging1" class="liadloging1" style="display:none;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:100%;height:300px;background-color:white;">
	<div style="background-color:rgb(251,125,100);padding-left:20px;line-height:50px;height:50px;color:white;font-size:25px;font-weight: bolder;">退款原因</div><br/>
	<div style="width:200px;margin:0 auto;height:150px;">
		<input onclick="changereason(1);" value="商品有瑕疵" type="radio" name="res" />商品有瑕疵<br/>
		<input onclick="changereason(2);" value="商品有质量问题" type="radio" name="res" />商品有质量问题<br/>
		<input onclick="changereason(3);" value="少发漏发" type="radio" name="res" />少发漏发<br/>
		<input onclick="changereason(4);" value="卖家发错货" type="radio" name="res" />卖家发错货<br/>
	</div>
	<div onclick="cancel();" style="margin-left:35%;margin-top:20px;width:120px;height:30px;line-height:30px;text-align:center;float:left;background-color:red;color:white;">确定</div>
	</div>
    </div>
</div>


<!--灰色遮罩层 begin-->
<div id="floatLayer" class="floatLayer" style="display:none;"></div> 
	
	
	<div class="content content-home">
		<div style="height:120px;width:100%;background:rgb(247,249,249);border-bottom:1px solid #ccc;">
		<div style="height:120px;width:50%;float:left;">
		<img style="height:100px;margin-top:10px;margin-left:10px;" src="<?php echo $book[0]['index_page']; ?>" />
	
		</div><div style="height:120px;width:50%;float:left;">
			<h5 style="margin-top:20px;">
				《
				<?php
				if($book[0]['rolenum'] == 1){
					echo base64_decode($book[0]['name1']);
				}else{
					echo base64_decode($book[0]['name1']);
					echo "与";
					echo base64_decode($book[0]['name2']);
				}
				echo $book[0]['name'];
				 ?>
				》
			</h5>
			
			<p style="color:green">¥<?php echo $book[0]['ordercost']; ?></p>
		</div>
		</div>
		<div onclick="dopay();" style="border-bottom:1px solid #ccc;height:50px;line-height:50px;text-indent: 25px;">
			货物状态：<span id="sendstatus"></span><div id="sends"  style="font-size:15px;text-align:right;height:50px;width:200px;float:right">请选择 ></div>
		</div>
		<div onclick="dos();" style="background:rgb(247,249,249);border-bottom:1px solid #ccc;height:50px;line-height:50px;text-indent: 25px;">
			退款原因：<span id="reasonstatus"></span><div id="reasons" style="font-size:15px;text-align:right;height:50px;width:200px;float:right">请选择 ></div>
		</div>
		<div style="border-bottom:1px solid #ccc;height:50px;line-height:50px;text-indent: 25px;">
			退款金额：<input id="price" placeholder="1-<?php echo $book[0]['ordercost']; ?>" style="width:150px;" type="text" name="price" />
		</div>
		<div style="background:rgb(247,249,249);border-bottom:1px solid #ccc;height:50px;line-height:50px;text-indent: 25px;">
			退款说明：<input placeholder="描述详细情况" style="width:200px;" type="text" name="message" />
		</div>
		
		<div style="border-bottom:1px solid #ccc;height:180px;line-height:50px;text-indent: 25px;">
			上传凭证：(最多可上传3张)<br/>
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne1" onchange="preImg(this.id,'imgPre1',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre1" src="http://www.babyinbook.com/babyinbook/Public/upload/3.png" style="border:1px solid #ccc;width:100px;height:100px;position:absolute;top:0px;left:0px;" />    
			</div>
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne2" onchange="preImg(this.id,'imgPre2',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre2" src="http://www.babyinbook.com/babyinbook/Public/upload/3.png" style="border:1px solid #ccc;width:100px;height:100px;position:absolute;top:0px;left:0px;" />    
			</div>
			<div style="width:100px;height:100px;border-radius:50px;margin-left:20px;position: relative;float:left">
			<a href="javascript:;" class="a-upload">
    					<input id="imgOne3" onchange="preImg(this.id,'imgPre3',this);" name="file[]" style="border:1px solid #ccc" type="file" />
			</a>
			 <img id="imgPre3" src="http://www.babyinbook.com/babyinbook/Public/upload/3.png" style="border:1px solid #ccc;width:100px;height:100px;position:absolute;top:0px;left:0px;" />    
			</div>
		</div><br/>
		<input style="position:absolute;left:50%;width:100px;margin-left:-50px;" type="submit" value="提交" class="button" />
		</div>
	</form>		
			<script type="text/javascript">
			function cancelpay(){
	document.getElementById("liadloging").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
}
			function cancel(){
	document.getElementById("liadloging1").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
}
function dopay(){
	document.getElementById("liadloging").style.display="block";
	document.getElementById("floatLayer").style.display="block";	
}
function dos(){
	document.getElementById("liadloging1").style.display="block";
	document.getElementById("floatLayer").style.display="block";	
}
function changesendstatus(status){
	if(status == 'yes'){
		$("#sendstatus").html("已收到货");
	}else{
		$("#sendstatus").html("未收到货");
	}
document.getElementById("sends").style.display="none";
}
function changereason(num){
	if(num == 1){	
		$("#reasonstatus").html("商品有瑕疵");
	}else if(num == 2){	
		$("#reasonstatus").html("商品有质量问题");
	}else if(num == 3){	
		$("#reasonstatus").html("少发漏发");
	}else if(num == 4){	
		$("#reasonstatus").html("卖家发错货");
	}
	document.getElementById("reasons").style.display="none";
}
			
			function checkform(){
		var price = document.getElementById("price").value;
		
		
		if($("#sendstatus").html() == ""){
			alert("清选择货物状态！");
			return false;
		}
		if($("#reasonstatus").html() == ""){
			alert("清选择退货理由！");
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