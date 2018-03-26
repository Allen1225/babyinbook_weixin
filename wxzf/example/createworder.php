<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
$orderinfo = json_decode(file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getOrderInfo/orderid/{$_GET['orderid']}"),true);

//var_dump($orderinfo);

if($orderinfo['status'] == 'false'){
	header('Location: http://www.babyinbook.com/babyinbook/index.php/Web/Index');
}
$orderid = $orderinfo['orderinfo'][0]['orderid'];
$money =   $orderinfo['orderinfo'][0]['paymentFee']*100;
//$money=1;
require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';

require_once 'mysql.php';

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
.liadloging{ width:600px; height:400px; position:fixed; top:50%;margin-left:-300px;margin-top:-200px; left:50%; z-index:9995;  }

/*遮罩层 begin*/
</style>
</head>

<body>



<div id="pageWrapper"  style="position:relative;">
<header>
  <div id="header">
    <div id="logo"><img src="http://www.babyinbook.com/images/logo.jpg" alt="logo" /></div>
    
    <div id="nav2_icon"><a href="#@"><img src="http://www.babyinbook.com/images/nav_icon.png" alt="logo" /></a></div>
  </div>
  
  <div class="clear"></div>
</header>

	

<div style="width:1200px;margin:0 auto;background-color:rgb(242,242,242); ">
	<img src="http://www.babyinbook.com/babyinbook/images/banner1.png" style="width:100%"/>
	
	<div style="height:10px"></div>
	<div style="width:inherit;margin:0 auto;border:1px solid #ccc;background: white;">
		<div style="background: rgb(206,226,170);line-height:50px;font-size: 15px;padding-left:30px;font-family: '微软雅黑';">我的订单</div>
	

		<div style="border-bottom:2px solid #ccc">
			<div style="line-height:50px;height:50px;width:90%;margin:0 auto; border-bottom:2px dashed rgb(206,226,170);">
				<div style="line-height:50px;height:50px;width:300px;float:left;">订单号：<?php echo $orderinfo['orderinfo'][0]['orderid']; ?></div>
				<div style="line-height:50px;height:50px;width:200px;float:right;"><?php echo $orderinfo['orderinfo'][0]['createtime']; ?> </div>
			</div>
			<div style="width:90%;margin:0 auto; border-bottom:2px dashed rgb(206,226,170);">
				<div style="height:25px;"></div>
				<?php foreach($orderinfo['detailinfo'] as $key1=>$value1){ ?>
				<div style="height:120px;">
					<div style="margin-left:10px;margin-top:8px;width:188px;height:105px;border:1px solid #222;float:left;">
						<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value1['pic']; ?>" style="width:100%;height:100%";>
					</div>
					<div style="margin-left:10px;margin-top:28px;width:188px;height:85px;float:left;">
					《<?php 
					echo base64_decode($value1['name1']);
					if($value1['role'] == 2){
						echo "与".base64_decode($value1['name2']);
					}
					echo $value1['name']; 
					?>》
					</div>
					<div style="margin-left:10px;margin-top:28px;width:188px;height:85px;float:left;text-align:right;"><font color="rgb(157,204,74)">¥<?php echo $value1['price']; ?></font></div>
					<div style="margin-left:10px;margin-top:28px;width:188px;height:85px;float:left;text-align:right;"><?php echo $value1['num']; ?>本</div>
				</div>
				<?php } ?>
			</div>
			<div style="border-bottom:2px dashed rgb(206,226,170);width:90%;margin:0 auto;height:80px;">
			<div style="width:150px;float:right;text-align: right;">
			<p>应付金额:¥<?php echo $orderinfo['orderinfo'][0]['subtotal']; ?></p>
			<p style="color:#ccc">减免金额:¥<?php echo $orderinfo['orderinfo'][0]['discountFee']; ?></p>
			<br/>
			<p style="font-size:18px;">订单金额:<font color="red">¥<?php echo $orderinfo['orderinfo'][0]['paymentFee']; ?></font></p>		
			</div>
			</div>
			<div style="height:120px;padding-top:20px;">
				<div style="width:15%;height:100px;float:left;text-align: center;font-size:15px;">收件信息</div>
				<div style="font-size:12px;color:grey;width:35%;height:100px;float:left;text-align: left">
					<p>收件人:<?php echo $orderinfo['orderinfo'][0]['receiver']; ?></p>
					<p>电话:<?php echo $orderinfo['orderinfo'][0]['phone']; ?></p>
					<p>地址:<?php echo $orderinfo['orderinfo'][0]['province_name']; ?>
							<?php echo $orderinfo['orderinfo'][0]['city_name']; ?>
							<?php echo $orderinfo['orderinfo'][0]['district_name']; ?>
							<?php echo $orderinfo['orderinfo'][0]['address']; ?></p>
				</div>
				<div style="width:15%;height:100px;float:left;text-align: center;font-size:15px;">物流信息</div>
				<div style="font-size:12px;color:grey;width:35%;height:100px;float:left;text-align: left">
					<?php if($orderinfo['orderinfo'][0]['sendstatus'] == 0){ echo "暂无物流信息"; } ?>
					<?php if($orderinfo['orderinfo'][0]['sendstatus'] == 1){ echo "<p>物流单号：{$orderinfo['orderinfo'][0]['sendcode']}</p>";echo "<p>快递类型：{$orderinfo['orderinfo'][0]['express']}</p>"; } ?>
				</div>
			</div>
		</div>
		

	<?php if($orderinfo['orderinfo'][0]['paystatus'] == 0){  ?>
        <?php if($orderinfo['orderinfo'][0]['paymentFee']==0){?>
            <?php
                $sql="insert into qm_total_info(attach,result_code,return_code,total_fee) VALUES ('{$orderid}','SUCCESS','SUCCESS','0')";
                $pay=execute($sql);
            ?>
            <div style="width:800px;height:200px;margin:0 auto;">

                <a target="_blank" href="http://www.babyinbook.com/babyinbook/index.php/Web/CheckPayStatus/orderid/<?php echo $orderid;?>"><div style="border-right:2px solid grey;border-bottom:2px solid grey;border-radius:10px;font-size:20px;color:white;text-align:center;line-height:20px;width:200px;height:80px;float:left;margin-left:300px;background-color:rgb(251,125,100)">
                        <br/>
                        ￥:<?php echo $orderinfo['orderinfo'][0]['paymentFee']; ?><br/>
                        立即支付
                    </div></a>
            </div>

        <?php }else{?>
            <div style="width:800px;height:200px;margin:0 auto;">

                <a href="javascript:;" onclick="dopay();"><div style="border-right:2px solid grey;border-bottom:2px solid grey;border-radius:10px;font-size:20px;color:white;text-align:center;line-height:20px;width:200px;height:80px;float:left;margin-left:300px;background-color:rgb(251,125,100)">
                <br/>
                ￥:<?php echo $orderinfo['orderinfo'][0]['paymentFee']; ?><br/>
                立即支付
                </div></a>
            </div>
        <?php }?>
	<?php } ?>	
	
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