<?php
ini_set('date.timezone','Asia/Shanghai');
$mid = !empty($_SESSION['user']['m_id'])?$_SESSION['user']['m_id']:0;
	$openid = !empty($_SESSION['user']['m_wechat_openid'])?$_SESSION['user']['m_wechat_openid']:0;
	$num = file_get_contents("http://www.babyinbook.com/babyinbook/index.php/Web/CartNum/id/{$mid}/openid/{$openid}");

//error_reporting(E_ERROR);
$id = $_GET['id'];
$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getFpage/id/$id");
$fpage = json_decode($json,true);
$url = $fpage['url']."/fpage/{$id}";
$matches = "/makePreview\/id\/([\s\S]*)\/role\//";
preg_match_all($matches, $url,$bookid);
$bookid = $bookid[1][0];
$matches = "/\/name1\/([\s\S]*)\/name2\//";
preg_match_all($matches, $url,$name1);
$name1 = $name1[1][0];
$matches = "/\/name2\/([\s\S]*)\/top\//";
preg_match_all($matches, $url,$name2);
$name2 = $name2[1][0];
$json = file_get_contents($url);
$res = json_decode($json,true);
$orderid = $fpage['orderid'];
$money = 1;
require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$notify = new NativePay();
$url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$input = new WxPayUnifiedOrder();
$input->SetBody("绘本");
$input->SetAttach($orderid);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($money);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://weixin.babyinbook.com/wxzf/example/orderreturn.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id("123456789");
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>


<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="http://www.babyinbook.com/images/favicon.jpg">
  <script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
  <title>宝贝在书里</title>
  <link rel='stylesheet' type='text/css' href='http://www.babyinbook.com/modules/main/styles/main_index.css'/>
 <link rel="stylesheet" type="text/css" href="http://www.babyinbook.com/babyinbook/css/normalize.css" />
<link rel="stylesheet" type="http://www.babyinbook.com/babyinbook/text/css" href="css/demo.css">
<link rel="stylesheet" href="http://www.babyinbook.com/babyinbook/css/app.css">
<style>
	.nav3{
		width:1200px;
		margin:0 auto;

		background-color:rgb(242,242,242);
	}
	.ma:hover{
		cursor:pointer;
	}
	.formdiv{
		color:rgb(71,71,71);
		height:30px;
		margin-top:5px;
		margin-left:30px;
	}
	.formdiv input{
		width:200px;
		border:1px solid #ccc;
		border-radius: 5px;
		height:25px;
	}
	.formdiv select{
		width:200px;
		border:1px solid #ccc;
		border-radius: 5px;
		height:25px;
	}
	.titlediv{
		text-align:right;
		float:left;
		width:100px;
	}
	

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
    margin-left:120px;
}
.fo{
	font-size: 15px;
	color:rgb(169,209,99);
	font-family:'微软雅黑';
}
.content{
	width:550px;
	margin:0 auto;
}

/*遮罩层 begin 2016-6-14 13:22:20*/
.floatLayer{ width:100%; height:100%; position:fixed; background:#000;  z-index:9990; top:0px; left:0px;filter:alpha(Opacity=50);-moz-opacity:0.50;opacity: 0.50;}
.liadloging{ width:600px; height:400px; position:absolute; top:50%;margin-left:-300px;margin-top:-200px; left:50%; z-index:9995;  }

/*遮罩层 begin*/
</style>
</head>

<body>



<div id="pageWrapper"  style="position:relative;">
<header>
  <div id="header">
    <div id="logo"><img src="http://www.babyinbook.com/images/logo.jpg" alt="logo" /></div>
    <nav id="nav">
      <ul>
      	 <li class="s"><a href="http://www.babyinbook.com/babyinbook/index.php/Web/Index">首页</a></li>
      	
      	        <li class="s"><a href="http://www.babyinbook.com/babyinbook/index.php/Web/Signin">我的帐户</a></li>
        <li class="s">
          <a href="">
          <img src="http://www.babyinbook.com/images/cart.jpg"> 购物车 <?php echo $num; ?> 个商品</a>
         </li>
         <li class="s">
          <a href="http://www.babyinbook.com/babyinbook/index.php/Web/BookShelves">书架</a>
         </li>
          <li class="s">
          <a href="http://www.babyinbook.com/babyinbook/index.php/Web/loginout">退出登录</a>
         </li>
               </ul>
    </nav>
    <div id="nav2_icon"><a href="#@"><img src="http://www.babyinbook.com/images/nav_icon.png" alt="logo" /></a></div>
  </div>
  
  <div class="clear"></div>
</header>

	

<div style="width:1200px;margin:0 auto;background-color:rgb(242,242,242); ">
	<img src="http://www.babyinbook.com/babyinbook/images/banner1.png" style="width:100%"/>
	
	<div style="height:10px"></div>
	
			<?php foreach($res as $key=>$value){ ?>
		<div style="width:800px;margin:20px auto;">
			<img src="<?php echo $value; ?>" style="max-width:800px;">
			
		</div>
		<?php } ?>
	
		<div style="width:800px;height:200px;margin:0 auto;">
			<form  action="http://www.babyinbook.com/babyinbook/index.php/Web/fpage" method="post">
			<input type="hidden" name="url"  value="<?php echo $fpage['url']; ?>" />
			<input type="submit" value="重新定制" style="border-radius:10px;font-size:25px;color:white;text-align:center;line-height:80px;width:200px;height:80px;float:left;margin-left:50px;background-color:rgb(251,125,100)">
			</form>
			
			<form action="http://www.babyinbook.com/babyinbook/interface.php/Index/wapDoAddCart/" method="post">
			<input type="hidden" name="web"  value="1" />
			<input type="hidden" name="bookid"  value="<?php echo $bookid; ?>" />
			<input type="hidden" name="name1" value="<?php echo $name1; ?>" />
			<input type="hidden" name="name2" value="<?php echo $name2; ?>" />
			<input type="hidden" name="url"  value="<?php echo $fpage['url']; ?>" />
			<input type="hidden" name="fpage"  value="<?php echo $id; ?>" />
			<input type="hidden" name="phone"  value="<?php echo $fpage['phone']; ?>" />
			<input type="hidden" name="user_id"  value="<?php echo $fpage['user_id']; ?>" />
			<input type="submit" value="加入购物车" style="border-radius:10px;font-size:25px;color:white;text-align:center;line-height:80px;width:200px;height:80px;float:left;margin-left:50px;background-color:rgb(157,204,74)">
			</form>
			
			
		</div>
		<div id="liadloging" class="liadloging" style="display:none;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:600px;height:400px;background-color:white;">
	<div style="background-color:rgb(251,125,100);padding-left:20px;line-height:50px;height:50px;color:white;font-size:25px;font-weight: bolder;">温馨提示</div><br/>
	<div style="text-align:center;margin-top:30px;">打开微信客户端扫一扫继续支付</div>
	<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:200px;height:200px;margin-left:200px;"/>
	<a href="http://www.babyinbook.com/babyinbook/index.php/Web/CheckPayStatus/orderid/<?php echo $orderid; ?>" ><div style="margin-left:150px;margin-top:20px;width:120px;height:30px;line-height:30px;text-align:center;float:left;background-color:red;color:white;">已完成支付</div></a>
	<a href="javascript:;" onclick="cancelpay();" ><div style="margin-left:50px;margin-top:20px;width:120px;height:30px;line-height:30px;text-align:center;float:left;border:1px solid #ccc;color:black;">取消</div></a>
	</div>
    </div>
</div>

<!--灰色遮罩层 begin-->
<div id="floatLayer" class="floatLayer" style="display:none;"></div> 
<!--灰色遮罩层 end-->
	
    <footer>
  <div id="footer">
    <div class="box">
        <div class="title">关于我们</div>
        <div><a href="http://www.babyinbook.com/source.html"><img src="http://www.babyinbook.com/images/footericon01.png" alt="icon" /> 冒险故事的由来</a></div>
        <div><a href="charactor.html"><img src="http://www.babyinbook.com/images/footericon02.png" alt="icon" /> 冒险小伙伴们</a></div>
        <div><a href="about.html"><img src="http://www.babyinbook.com/images/footericon11.png" alt="icon" /> 我们的故事</a></div>
        <div><a href="http://www.babyinbook.com/job.html"><img src="http://www.babyinbook.com/images/footericon08.png" alt="icon" /> 加入我们</a></div>
    </div>
    <div class="box">
        <div class="title">客户服务</div>
        <div><a href="http://www.babyinbook.com/register.html"><img src="http://www.babyinbook.com/images/footericon06.png" alt="icon" /> 用户注册</a></div>
        <div><a href="http://www.babyinbook.com/faq.html"><img src="http://www.babyinbook.com/images/footericon09.png" alt="icon" /> 常见问题</a></div>
        <div><a href="http://www.babyinbook.com/contact.html"><img src="http://www.babyinbook.com/images/footericon07.png" alt="icon" /> 联系我们</a></div>
    </div>
    <div class="box last">
        <div class="title">关注我们</div>
        <div><a href="http://www.babyinbook.com/subscribemmall.html"><img src="http://www.babyinbook.com/images/footericon10.png" alt="icon" /> 微信商城</a></div>
        <div><a href="http://www.babyinbook.com/subscribewechat.html"><img src="http://www.babyinbook.com/images/footericon04.png" alt="icon" /> 微信</a></div>
        <div><a href="http://www.babyinbook.com/subscribeweibo.html"><img src="http://www.babyinbook.com/images/footericon05.png" alt="icon" /> 微博</a></div>
    </div>
        <div class="copyright">沪ICP备15051486号<span class="right">copyright &copy; babyinbook</span></div>
  </div>
</footer>
<a id="scrollup" href="#"></a>
</div>
<script>
function cancelpay(){
	document.getElementById("liadloging").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
}
function dopay(){
	document.getElementById("liadloging").style.display="block";
	document.getElementById("floatLayer").style.display="block";	
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
	function preImg(sourceId, targetId,file) { 
	var strs = new Array(); //定义一数组     
    //  var pic1 = $("#file").val(); //获取input框的值，文件路径
        var pic1 = $(file).val(); //获取input框的值，文件路径
        strs = pic1.split('.'); //分成数组存储
        var suffix = strs[strs.length - 1]; //获取文件后缀

        if (suffix != 'jpg' && suffix != 'png' & suffix != 'JPG' && suffix != 'PNG')
        {  
           alert("清上传PNG或者JPG格式的图片文件");//不是图片，做处理
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

function mkdefault(id){

	document.getElementById("type").value ="mkdefault";
    document.getElementById("addressid").value= id;
    document.getElementById("myform").submit();

}
function dosubmit(){
	var receiver = document.getElementById("receiver").value;
	if(receiver == ""){
		alert("昵称");
		return false;
	}
	
 	document.getElementById("myform").submit();
}
function aa(e){
	var url = "/babyinbook/index.php/Web/getcity/id/" + e.value;
	 $.ajax({  
                    type : "POST",  //提交方式  
                    url : url,//路径  
                
                    success : function(result) {//返回数据根据结果进行相应的处理  
                      document.getElementById("city").innerHTML = result;
                    }  
                });  
	//document.getElementById("city").innerHTML = "<option>123</option>";
}

function bb(e){
	var url = "/babyinbook/index.php/Web/getdistrict/id/" + e.value;
	 $.ajax({  
                    type : "POST",  //提交方式  
                    url : url,//路径  
                
                    success : function(result) {//返回数据根据结果进行相应的处理  
                      document.getElementById("district").innerHTML = result;
                    }  
                });  
	//document.getElementById("city").innerHTML = "<option>123</option>";
}
function mkdelete(id){

	document.getElementById("type").value ="delete";
    document.getElementById("addressid").value= id;
    if(confirm("是否确认删除？")){
    document.getElementById("myform").submit();
}
}
</script>
</body>
</html>