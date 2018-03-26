<?php 
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
$orderid = $_GET['orderid'];
$couponid = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/MkCoupon/orderid/{$_GET['orderid']}");
//var_dump($couponid);

//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
$orderinfo = json_decode(file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getOrderInfo/orderid/{$_GET['orderid']}"),true);

if($orderinfo['status'] == 'false'){
	header('Location: http://weixin.babyinbook.com/newindex/index.php');
}
include "mysql.php";
foreach($orderinfo['detailinfo'] as $key=>&$value){
    $str = $value['index_page'];
    if(strpos($str,"/Public/preview/") !== false){
        $tmp_arr = explode('/',$str);
        $a = explode('_',$tmp_arr[6]);

        foreach ($a as $k=>&$v){
            if($k == 2){
                if(!is_base64($a[2])){
                    $name = base64_encode($a[2]);
                    $name = str_replace("+",'-',$name);
                    $name = str_replace("/",'-',$name);
                    $name = str_replace(".",'-',$name);
                    $name = str_replace("=",'-',$name);
                    $v = $name;
                }
            }
        }
        $new = implode('_',$a);
        foreach ($tmp_arr as $c=>&$b){
            if($c == 6){
                $b = $new;
            }
        }
        $new_str = implode('/',$tmp_arr);
        $value['index_page'] = $new_str;
    }
}
require_once "jssdk.php";
$jssdk = new JSSDK("wx6a77790bf7451603", "23fc1b81b9363d6a6c446132464dce63");
$signPackage = $jssdk->GetSignPackage();
?>

<html>
<head>
   <meta charset="utf-8"><title>宝贝在书里 · 订单确认</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="/js/sweetalert/theme.css" rel="stylesheet"><script src="/js/sweetalert/sweetalert.min.js"></script>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>  
<script type="text/javascript">  
    wx.config({  
        debug : false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。  
        appId: '<?php echo $signPackage["appId"];?>',
    	timestamp: <?php echo $signPackage["timestamp"];?>,
   	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    	signature: '<?php echo $signPackage["signature"];?>',
        jsApiList : [ 'onMenuShareTimeline', 'onMenuShareAppMessage',  
                'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone' ]  
    });  
    var obj = {  
        title : '宝贝在书里定制红包',  
        desc : '来定制一本属于自己的图书吧！',  
        link : 'weixin.babyinbook.com/newindex/example/getcoupon.php?oid=<?php echo $orderid; ?>&cid=<?php echo $couponid; ?>',  
        imgUrl : 'http://www.babyinbook.com/babyinbook/images/coupon.jpg',  
    };  
    wx.ready(function(){  
        wx.onMenuShareAppMessage(obj);  
      
        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口  
        wx.onMenuShareTimeline(obj);  
          
        // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口  
        wx.onMenuShareQQ(obj);  
          
        // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口  
        wx.onMenuShareWeibo(obj);  
    }); 
    
    function cancel(){
	document.getElementById("liadloging").style.display="none";
	document.getElementById("floatLayer").style.display="none";	
}
function dobig(){

	document.getElementById("liadloging").style.display="";
	document.getElementById("floatLayer").style.display="";	
	
}
    </script>
    <style type="text/css">
    /*遮罩层 begin 2016-6-14 13:22:20*/
.floatLayer{ width:100%; height:100%; position:fixed; background:#000;  z-index:9990; top:0px; left:0px;filter:alpha(Opacity=50);-moz-opacity:0.50;opacity: 0.50;}
.liadloging{ width:100%; position:absolute; top:10%; left:10%; z-index:9995;  }
/*遮罩层 begin*/
    </style>
</head>
<body>
	  		<div id="liadloging" class="liadloging" style="display:none;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:80%;">
	<img style="width:100%;" onclick="cancel();" src="http://www.babyinbook.com/babyinbook/images/couponbig.png" id="bigpic" />
	<div style="width:200px;height:200px;color:white;position:absolute;top:50%;left:50%;text-align: center;margin-left:-140px;">
	送你一个红包<br/><br/>
	快去分享给小伙伴吧
	</div>
	</div>
    </div>
</div>

<!--灰色遮罩层 begin-->
<div onclick="cancel();" id="floatLayer" class="floatLayer" style="display:none;"></div>   

	
	<div class="content">
   <ul class="table-view table-card-view">
		<li style="padding-right:15px;" class="table-view-cell">
			<?php foreach($orderinfo['detailinfo'] as $key=>$value){ ?>
			<div class="cell-title">
				<div class="thumbnail-list-item">
				<img src="<?php echo str_replace("/show/show", "",$value['index_page']); ?>">
				</div>
			<div>
				<strong><?php echo $value['name']; ?></strong>
				<p class="muted text-ss">
				<span class="price text-sm">¥<?php echo $value['price']; ?></span></p>
				<span class="muted text-sm">&nbsp;×&nbsp;<?php echo $value['num']; ?>本</span>
				<?php if($value['status'] != 1){ ?><a href="http://weixin.babyinbook.com/newindex/example/aftersale.php?id=<?php echo $value['id']; ?>&orderid=<?php echo $orderid; ?>"><span class="muted text-sm" style="float:right;border:1px solid #ccc;border-radius: 5px;display: block;padding:2px;">申请售后</span>
				<?php }else{ ?><span class="muted text-sm" style="float:right;border-radius: 5px;display: block;padding:2px;color:red;">退款中<br/>商家审核</span>
				<?php } ?>
				<div style="clear:both"></div>
			</div>
			</div>
			<?php } ?>
			<p><span>合计：</span><span>¥<?php echo $orderinfo['orderinfo'][0]['subtotal']; ?></span> - <span id="discountFee">¥<?php echo $orderinfo['orderinfo'][0]['discountFee']; ?></span></p>
			<p><span>总价：</span><span id="paymentFee" class="price">¥<?php echo $orderinfo['orderinfo'][0]['paymentFee']; ?></span></p>
		</li>
		<li class="table-view-cell">
			<a href="javascript:;" class="navigate-right">
				<div class="cell-title">
					<span>收货人：</span>
					<span><?php echo $orderinfo['orderinfo'][0]['receiver']; ?> </span>
					<span class="pull-right muted"><?php echo $orderinfo['orderinfo'][0]['phone']; ?></span>
				</div>
				<p>收货地址：<?php echo $orderinfo['orderinfo'][0]['province_name'] . $orderinfo['orderinfo'][0]['city_name'] . $orderinfo['orderinfo'][0]['district_name'] . $orderinfo['orderinfo'][0]['address']; ?></p>
				</a>
		</li>
		<li style="padding-right:15px;" class="table-view-cell">
			<div class="cell-title">红包/折扣</div>
			
			<p>
				<label><p><?php echo $orderinfo['orderinfo'][0]['c_name']; ?></p></label>
			</p>
		
			</li>
		
		 <?php
            if(!empty($orderinfo['orderinfo'][0]['sendcode']) && !empty($orderinfo['orderinfo'][0]['express'])){?>
                <li style="padding-right:15px;" class="table-view-cell">
                    <div class="cell-title">
                        <?php
                            switch ($orderinfo['orderinfo'][0]['express'])
                            {
                                case 1:echo "顺丰快递";break;
                                case 2:echo "圆通快递";break;
                                case 3:echo "申通快递";break;
                            }
//                        echo $orderinfo['orderinfo'][0]['express'] ;
                            ?>
                    </div>

                    <p>
                        <label><p>物流单号：<?php echo $orderinfo['orderinfo'][0]['sendcode']; ?></p></label>
                    </p>

                </li>
       <?php
            }
       ?>
	<!--	<li class="table-view-cell">
			<a href="javascript:;" class="navigate-right">
				<div class="cell-title">发票</div>
				<p id="txtInvoiceTitle"><?php //echo $orderinfo['orderinfo'][0]['invoiceTitle']; ?></p>
			</a>
		</li>-->
		</ul>
		<?php if($orderinfo['orderinfo'][0]['paystatus'] == 0){ ?>
		<div style="margin-top:10px;" class="pure-g">
		<div class="pure-u-5-24"></div>
		<div class="pure-u-14-24">
			<a onclick="callpay()" class="btn btn-block btn-round btn-primary btn orange-linear">立即支付</a>
			</div>
			<div class="pure-u-5-24"></div>
	</div>
	<?php } ?>
	</div>
				<nav class="bar" style='border:none;bottom: 90px;background-color:transparent;'> 
<a href="http://weixin.babyinbook.com/newindex/example/getcoupon.php?oid=<?php echo $orderid; ?>&cid=<?php echo $couponid; ?>" ><img style="height:70px;float:right" src="http://www.babyinbook.com/babyinbook/images/couponsmall.png"></a>
	</nav>
	
</body>

</html>
