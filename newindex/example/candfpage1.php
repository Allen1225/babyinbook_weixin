<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
$member = $_SESSION['member'];
$id = $_GET['id'];
$url = $_GET['url'];
$page=isset($_GET['page'])?$_GET['page']:1;
switch ($page) {
	case '1':
		$title = "一月份";
		$moonth = "Jan[]";
		$img_name = "baseimg1";
		break;
	case '2':
		$title = "二月份";
		$moonth = "Feb[]";
		$img_name = "baseimg2";
		break;
	case '3':
		$title = "三月份";
		$moonth = "Mar[]";
		$img_name = "baseimg3";
		break;
	case '4':
		$title = "四月份";
		$moonth = "Apr[]";
		$img_name = "baseimg4";
		break;
	case '5':
		$title = "五月份";
		$moonth = "May[]";
		$img_name = "baseimg5";
		break;
	case '6':
		$title = "六月份";
		$moonth = "Jun[]";
		$img_name = "baseimg6";
		break;
	case '7':
		$title = "七月份";
		$moonth = "Jul[]";
		$img_name = "baseimg7";
		break;
	case '8':
		$title = "八月份";
		$moonth = "Aug[]";
		$img_name = "baseimg8";
		break;
	case '9':
		$title = "九月份";
		$moonth = "Seb[]";
		$img_name = "baseimg9";
		break;
	case '10':
		$title = "十月份";
		$moonth = "Oct[]";
		$img_name = "baseimg10";
		break;
	case '11':
		$title = "十一月份";
		$moonth = "Nov[]";
		$img_name = "baseimg11";
		break;
	case '12':
		$title = "十二月份";
		$moonth = "Dec[]";
		$img_name = "baseimg12";
		break;
}
$bookid=$_GET['bookid'];
$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getdata.html?id=$id&page=$page");

$fpage = json_decode($json,true);
$pic="null";
if($fpage['res']['insert_id']!==0){
	$pic=$fpage['res']['pic'];

$date = $fpage['res']['date'];
$date=explode(",", $date);
$insert_id=$fpage['res']['insert_id'];
}else{
	$insert_id=0;
}
$day = 31;
if ($page==4 ||$page==6 ||$page==9 ||$page==11) {
	$day = 30;
}else if($page == 2){ $day = 28;}
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
		    width: 118px;
		  	height:85px;
		    position: relative;
		    cursor: pointer;
		    color: #888;
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
	<?php for($i=1;$i<=1;$i++){ ?>
		#clipArea<?php echo $i; ?> {
			margin: 20px;
			height: 300px;
		}
		#file<?php echo $i; ?>,
		#clipBtn<?php echo $i; ?> {
			margin: 20px;
		}
		#view {
	margin: 0 auto;
	width: 200px;
	height: 200px;
}
	<?php } ?>

		
		/*遮罩层 begin 2016-6-14 13:22:20*/
		.floatLayer{ width:100%; height:100%; position:fixed; background:white;  z-index:9990; top:0px; left:0px;}
		.liadloging{ width:400px; height:400px; position:fixed; top:35%;margin-left:-200px;margin-top:-200px; left:50%; z-index:9995;  }		
		/*遮罩层 begin*/
	</style>
</head>
<body bgcolor="rgb(242,242,242)">
	<div class="content content-home">
		<form id="form" onsubmit="return checkform();" enctype="multipart/form-data" action="http://www.babyinbook.com/babyinbook/interface.php/Index/save" method="post"><!-- kaishi -->
		<input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
		<input type="hidden" name="upfile" value="" />
<!-- kaishi -->
<!-- 一月 -->
		<div style="height:20px"></div>
		<div id="moonth" style="height:30px;width:80%;margin-left:10%;"><?php echo $title; ?></div>
		<div id="liadloging1" class="liadloging" style="display:none;">
	    	<div class="ldl_Conten">
	      		 <div class="load" style="width:400px;height:400px;background-color:white;">
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
			<div style="margin-top:10px;width:118px;height:85px;border-radius:5px;margin-left:20px;position: relative;background-image:url('http://www.babyinbook.com/babyinbook/images/add2.png')">
			<a href="javascript:;" class="a-upload">
    					<input onchange="preImg(this.id,'imgPre',this);"   name="file[]" type="file" id="file1">
			</a>
			<input type="hidden" name="<?php echo $img_name; ?>" id="baseimg1" value="<?php if($pic!="null"){echo $pic;}?>" />
			 <div id="view1" style="width: 118px; height: 85px; position: absolute; top: 0px; left: 0px; background-image: url('<?php echo "http://www.babyinbook.com/babyinbook/Public/userupload/".$pic; ?>'); background-size: contain; background-position: 50% 50%; background-repeat: no-repeat;"></div>   
			</div>
			<div style="padding-top:15px;height:100px;width:200px;margin-left:20px;float:left">
				<font style="font-size: 15px;color:rgb(169,209,99);font-family:'微软雅黑'">点击按钮可以上传图片/照片</font><br/>

				<font style="font-size: 9px;font-family:'微软雅黑'">上传图片格式为jpg、png</font>
			</div>
		</div>
	
		<div style="clear:both;width:80%;margin-left:10%;height:40px;line-height:40px;">请选择特殊日期</div>
		<?php if ($date[0]=='2018-0'.$page.'-0' || $date[0]=='2018-0'.$page.'-0不选择' || $date[0]=='2018-'.$page.'-0' ||
		$date[0]=='2018-'.$page.'-0不选择' || $date==null) { ?>
			<select name="<?php echo $moonth; ?>" class="dateselect1 dateselect" id="asd0">
			<option value=0>不选择</option>
				<?php for($i=1;$i<=$day;$i++){ ?>
				<option value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
				<?php } ?>
			</select>
		<?php }else{ ?>

			<?php  for($j=0;$j<4;$j++){ ?>
			<?php if($date[$j]!='2018-0'.$page.'-0' && $date[$j]!='2018-0'.$page.'-0不选择' && $date[$j]!='2018-'.$page.'-0' &&
		$date[$j]!='2018-'.$page.'-0不选择'){ ?>
				<select name="<?php echo $moonth; ?>" class="dateselect1 dateselect" id="asd<?php echo $j; ?>">
				<option>不选择</option>
					<?php for($i=1;$i<=$day;$i++){ ?>
						<?php if($i<10){ ?>
							<option <?php if($date[$j]=='2018-0'.$page.'-0'.$i || $date[$j]=='2018-'.$page.'-0'.$i){echo 'selected=selected';}?> value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
						<?php }else{ ?>
							<option <?php if($date[$j]=='2018-0'.$page.'-'.$i || $date[$j]=='2018-'.$page.'-'.$i){echo 'selected=selected';}?> value="<?php echo $i; ?>"><?php echo $i . '号'; ?></option>
						<?php } ?>
					<?php } ?>
				</select>
				<?php } ?>
			<?php } ?>
		<?php } ?>

		<div style="width:100%" class="datediv1" id="datediv1" >

		</div>
		<div onclick="adddiv('dateselect1','datediv1','<?php echo $moonth; ?>')" style="width:80%;margin-left:10%;text-align: right;font-size: 15px;font-family: '微软雅黑';">
		增加一个日期<img src="http://www.babyinbook.com/babyinbook/images/add.png" style="width:15px;height:15px;position:relative;top:-2px;" />
		</div>
		<div style="height:20px;border-bottom:1px solid #ccc;width:100%;"></div>

<!-- jieshu -->		
		
		<input type="hidden" name="phone" value="<?php echo $member[0]['m_account']; ?>">
		<input type="hidden" name="openid" value="<?php echo $member[0]['m_wechat_openid']; ?>">
		<input type="hidden" name="url" value="<?php echo $url; ?>">
		<input type="hidden" name="bookid" value="<?php echo $bookid; ?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<input type="hidden" name="page" id='page' value="<?php echo $page; ?>">
		<input type="hidden" name="insert_id" value="<?php echo $insert_id; ?>">
		<div style="position: relative" >
		<input style="position:absolute;right:50%;width:100px;margin-left:50px;display: <?php if($page==1){echo 'none';}?>;" name="action" type="submit" value="上一步" class="button" id="sub"/>
		</div>
		<div style="position: relative">
		<input style="position:absolute;left:50%;width:100px;margin-left:30px;display: <?php if($page==12){echo 'none';}?>;" name="action" type="submit" value="下一步" class="button" id="sub" onclick="return date_repeat()"/>
		</div>
		<div style="position: relative">
		<input style="position:absolute;left:50%;width:100px;margin-left:30px;display: <?php if($page!=12){echo 'none';}?>;" type="button" value="完成" class="button" onclick="finish()" />
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

	function finish(){
		document.forms.form.action = "http://www.babyinbook.com/babyinbook/interface.php/Index/save";
       document.forms.form.submit();
	}

	function date_repeat(){
		var a = document.getElementById("asd0")?document.getElementById("asd0").value:32;
		var b = document.getElementById("asd1")?document.getElementById("asd1").value:33;
		var c = document.getElementById("asd2")?document.getElementById("asd2").value:34;
		var d = document.getElementById("asd3")?document.getElementById("asd3").value:35;
		
		if (a==b || a==c || a==d || b==c || b==d || c==d) {
			alert("日期不能相同");
			return false;
		}
}

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
				<?php for($i=1;$i<=$day;$i++){ ?>
				option = option + "<option value='<?php echo $i; ?>'><?php echo $i . '号'; ?></option>"
				<?php } ?>
			b.append("<select name='"+z+"' class='"+x+" dateselect' id='asd"+a.length+"' ><option>不选择</option>"+option+"</select>");
		}else{
			alert("每月为您提供不超过4个特殊日期标记");
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
function getElements()
  {
  var x=document.getElementsByTagName("div");
  for(var i=0;i<x.length; i++){
      alert(x[i].innerHTML);
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

	<?php for($i=1;$i<=1;$i++){ ?>
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
