

<?php 
header("Content-Type:text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();

require_once "jssdk.php";
$appid = 'wx6a77790bf7451603';
$APPSECRET = '23fc1b81b9363d6a6c446132464dce63';
$jssdk = new JSSDK($appid, $APPSECRET); 
$signPackage = $jssdk->GetSignPackage();

if(!empty($_SESSION['openId'])){
	$openId = $_SESSION['openId'];
}else{
	require_once "../lib/WxPay.Api.php";
	require_once "WxPay.JsApiPay.php";
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;
}

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$charset = mysql_query("set names utf8");
	$sql = "select * from babyinbook.pb_member where m_wechat_openid = '{$openId}'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$info[] = $a;
	}

    $orderid = $_GET['oid'];
    $couponid = $_GET['cid'];
	if(empty($info)){
		header("Location: http://www.babyinbook.com/newindex/login.php?openId=$openId&oid=$orderid&cid=$couponid");
//		header("Location: http://weixin.babyinbook.com/signup.php?openId=$openId");
	}

	$userid = $info[0]['m_id'];
	$ismy = "select * from bibtest.bib_v1_orders where orderid = '{$orderid}' and userid = '{$userid}'";
	$ismy = mysql_query($ismy);
	while($ccc = mysql_fetch_assoc($ismy)){
		$ismyc[] = $ccc;
	}

	

	$sql = "select * from babyinbook.user_coupon where user_id = $userid and coupon_id = $couponid and date_used is null and UNIX_TIMESTAMP(valid_to)>UNIX_TIMESTAMP()";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$aa[] = $a;
	}
	$sql = "select * from babyinbook.coupon where order_id = $orderid and id = $couponid";
		$res = mysql_query($sql);
		while($a = mysql_fetch_assoc($res)){
		$coupon[] = $a;
		}

		$isok = 0;
//获取昵称
	$order = "select * from bibtest.bib_v1_orders where orderid = '{$orderid}'";
	$orderuser = mysql_query($order);
	while($dd = mysql_fetch_assoc($orderuser)){
		$orderuser1[] = $dd;
	}
	$userob = $orderuser1[0]['userid'];
	$sql = "select * from babyinbook.pb_member where m_id = '{$userob}'";
	$member = mysql_query($sql);
	while($ddd = mysql_fetch_assoc($member)){
		$openidob[] = $ddd;
	}
	$opid = $openidob[0]['m_wechat_openid'];
	$actoken = $jssdk->getAccessToken();
	$url1 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$actoken}&openid={$opid}&lang=zh_CN"; 
    $resn = json_decode($jssdk->httpGet($url1)); 
    $nickname = $resn->nickname; 
    
//-----
	if(!empty($aa)){
		$isok = 1;
		$aa = 1;
		$result = "您已获得{$nickname}的{$coupon[0]['c_disc_amount']}元订单分享红包！";
	}else{
		
		if(empty($coupon)){
			$result = "红包信息错误！";
		}else{
			
			
			
			$result = "您获得了{$nickname}的{$coupon[0]['c_disc_amount']}元订单分享红包！";
		}
	}
	if(!empty($ismyc)){
		$isok=3;
		$pic = "mycoupon2.png";
			$result = "";
	}else{
		$pic = "coupon1.png";
	}
?>	
	<html>
	<head>
<meta charset="utf-8"/>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<title>宝贝在书里 · 获取红包</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script>
</head>
<body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	    <style type="text/css">
    /*遮罩层 begin 2016-6-14 13:22:20*/
/*.floatLayer{ width:100%; height:100%; position:fixed; background:#000;  z-index:9990; top:0px; left:0px;filter:alpha(Opacity=50);-moz-opacity:0.50;opacity: 0.50;}*/
.liadloging{ width:100%; position:absolute; top:12%; left:10%; z-index:9995;  }
/*遮罩层 begin*/
    </style><script type="text/javascript">
    function share(){
    	var button = document.getElementById('button');
    	var img01 = document.getElementById('img01');
    	<?php 
    	$date = date("Y-m-d H:i:s");
		$valid_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) + 86400 * $coupon[0]['c_share_duration']);
    	?>
    	
    	var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var retJson = xhttp.responseText;
            if (retJson) {
            	$isok=1;
            	button.style.display='none';
            	img01.style.display='block';
            	console.log(xhttp.responseText+"");
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/newGetCoupon', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('date=' + '<?php echo $date; ?>' + '&valid_to=' + '<?php echo $valid_to; ?>'+ '&userid=' + <?php echo $userid;?>+ '&couponid=' + <?php echo $couponid;?>);
    	
    }
    </script>

    <script> 

        wx.config({ 
            debug: false, 
            appId: '<?php echo $appid; ?>', 
            timestamp: <?php echo time(); ?>, 
            nonceStr: '<?php echo $signPackage["nonceStr"]; ?>', 
            signature: '<?php echo $signPackage["signature"]; ?>', 
            jsApiList: [ 
               'onMenuShareTimeline',
               'onMenuShareAppMessage'
            ] 
        }); 
        wx.ready(function() { 
            wx.onMenuShareAppMessage({ 
            	<?php 
            	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            	$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  
            	?>
                title: '宝贝在书里 · 获取红包', // 分享标题 
                desc:'<?php echo $coupon['c_desc']; ?>',
                link: '<?php echo $url; ?>', // 分享链接 
                imgUrl: 'http://www.babyinbook.com/babyinbook/images/mycoupon.png', // 分享图标 
                success: function() { 
                    // 用户确认分享后执行的回调函数 
                }, 
                cancel: function() { 
                    // 用户取消分享后执行的回调函数 
                } 
            }); 
        });
    </script> 
    <img src="http://www.babyinbook.com/babyinbook/images/coupon2.png" style=" display: <?php if($isok!=3){echo "none";} ?>;margin-top: 10px;width: 70px;height: 70px;margin-left:280px;" />
    <div id="liadloging" class="liadloging" style="display:;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:80%;">
	<img style="width:100%;"  src="http://www.babyinbook.com/babyinbook/images/<?php echo $pic; ?>" id="bigpic" />
	<div style="width:200px;height:100px;color:white;position:absolute;top:66%;left:50%;text-align: center;margin-left:-130px;">
	<span style="font-size: 21px;color: #000000;"><?php echo $result; ?></span>
	</div>
	</div>
    </div>
    
</div>
<div style="margin-left: 60px;position:absolute;top:58%;display: <?php if($isok==3){echo "none";} ?>" class="pure-g">
        <div class="pure-u-18-24" style="width: 240px;"><a  href="http://weixin.babyinbook.com/newindex/index.php" class="btn btn-block btn-round btn-signup orange-linear">点击定制</a></div>
    </div>
<div style="margin-left: 60px;position:absolute;top:58%;display: <?php if($isok==1 || $isok==3){echo "none";} ?>" class="pure-g">
        <div id="button" class="pure-u-18-24" style="width: 240px;"><button  onclick="share();" class="btn btn-block btn-round btn-signup orange-linear">点击领取</button> </div>
    </div>
    
 <?php if(1){ ?> 
<div id="img01" style="display: <?php if($isok==0 || $isok == 3) {echo "none";}?>">
	<img  src="http://www.babyinbook.com/babyinbook/images/coupon4.png" style="position:relative;z-index:9999;width: 90px;height: 90px;margin-left: 30px ;position:absolute;top:72%;">
</div>
<?php }?> 
<!--灰色遮罩层 begin-->
<div  id="floatLayer" class="floatLayer" style="display:;"></div>   
<nav class="bar bar-tab" style="z-index: 9998;height: <?php if (0) {echo "70px";} ?>">
				<a href="/newindex/index.php" class="tab-item ">
				<?php if (0) { ?>
					<img src="http://www.babyinbook.com/babyinbook/images/home_yellow.png" style="width: 24px;height: 24px;"></img></br>
					<span class="tab-label" style="color: #FCB803;font-size: 22px;font-weight: bold;text-shadow:0 0 0.2em #ffc90f,-0 -0 0.2em #ffc90f;">首页</span>
				<?php }else{ ?>
					<span class="icon icon-home"></span>
					<span class="tab-label">首页</span>
				<?php } ?>
				</a>
				<a href="/newindex/example/user.php" class="tab-item active">
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
