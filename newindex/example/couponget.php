<?php 
header("Content-Type:text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();

$openId = !empty($_REQUEST['openId'])?$_REQUEST['openId']:'';

if(!empty($_GET['c_code']))
{
	$_SESSION['c_code'] = $_GET['c_code'];
}


if(empty($_SESSION['c_code']))
{
	$_SESSION['c_code'] = $_GET['c_code'];
	$c_code = $_SESSION['c_code'];
}else{
	$c_code = $_SESSION['c_code'];
}

require_once "jssdk.php";
$appid = 'wx6a77790bf7451603';
$APPSECRET = '23fc1b81b9363d6a6c446132464dce63';
$jssdk = new JSSDK($appid, $APPSECRET); 
$signPackage = $jssdk->GetSignPackage();



if(!empty($openId)){
	 $_SESSION['openId'] = $openId;
}elseif(!empty($_SESSION['openId']) && false){
	$openId = $_SESSION['openId'];
}else{

	require_once "../lib/WxPay.Api.php";
	require_once "WxPay.JsApiPay.php";
	$tools = new JsApiPay();
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;

}
if ($openId==null) {

	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  
    require_once "../lib/WxPay.Api.php";
	require_once "WxPay.JsApiPay.php";
	$tools = new JsApiPay();
	$openId = $tools->wechatLogin($url);
}

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$charset = mysql_query("set names utf8");
	$sql = "select * from babyinbook.pb_member where m_wechat_openid = '{$openId}'";
	$res = mysql_query($sql);

	while($a = mysql_fetch_assoc($res)){
		$info[] = $a;
	}
	//$c_code = $_GET['c_code'];
	// var_dump($c_code);
	if(empty($info)){
		// var_dump($c_code);die;
		// header("Location: http://www.babyinbook.com/newindex/login.php?openId=$openId&c_code=$c_code");//新用户调到
		// exit;
		// $_SESSION['c_code'] = $c_code;
		header("Location: http://www.babyinbook.com/babyinbook/signup.php?openId={$openId}&c_code={$c_code}");
	}

	// var_dump($c_code);die;
	$sql = "select * from babyinbook.coupon where c_code = '$c_code'";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$c[] = $a;
	}
	$coupon = $c[0];
	$isok=0;

	if(!empty($coupon))
	{
		if(isset($_SESSION['duration']))
		{
			if($duration <= $coupon['c_disc_duration'])
			{
					$cosql = "select count(*) as count from babyinbook.user_coupon where coupon_id = '{$coupon['id']}'";
					$counum = mysql_query($cosql);
				while($aa = mysql_fetch_assoc($counum))
				{
					$coures[] = $aa;
				}
					$couresnum = $coures[0]['count'];
				if($couresnum < $coupon['c_qty'] || $coupon['c_qty'] == 0)
				{	
					$date = date("Y-m-d H:i:s");
					$couponid = $coupon['id'];
					$userid = $info[0]['m_id'];
					
					$usedsql = "select * from babyinbook.user_coupon where user_id = $userid and coupon_id = $couponid and date_used is null and UNIX_TIMESTAMP(valid_to)>UNIX_TIMESTAMP()";
					$usedsorce = mysql_query($usedsql);
					while($usedpa = mysql_fetch_assoc($usedsorce))
					{
						$usedarr[] = $usedpa;
					}
					if(empty($usedarr))
					{
						$valid_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) + 86400 * $coupon['c_share_duration']);
						$result = "获得{$coupon['c_desc']}！";
					}else{
						$isok=1;
						$result = "你已经领取过该红包！";
					}
				}else{
					$isok=1;
					$result = "该红包已被领完！";
				}
			}else{
				$isok=1;
				$result = "该红包已过期！";
			}
		}else{
			$duration = (strtotime(date("Y-m-d H:i:s")) -  strtotime($coupon['date_created']))/86400;
			$_SESSION['duration'] = $duration;

			if($duration <= $coupon['c_disc_duration'])
			{
					$cosql = "select count(*) as count from babyinbook.user_coupon where coupon_id = '{$coupon['id']}'";
					$counum = mysql_query($cosql);
				while($aa = mysql_fetch_assoc($counum))
				{
					$coures[] = $aa;
				}
					$couresnum = $coures[0]['count'];
				if($couresnum < $coupon['c_qty'] || $coupon['c_qty'] == 0)
				{	
					$date = date("Y-m-d H:i:s");
					$couponid = $coupon['id'];
					$userid = $info[0]['m_id'];
					
					$usedsql = "select * from babyinbook.user_coupon where user_id = $userid and coupon_id = $couponid and date_used is null and UNIX_TIMESTAMP(valid_to)>UNIX_TIMESTAMP()";
					$usedsorce = mysql_query($usedsql);
					while($usedpa = mysql_fetch_assoc($usedsorce))
					{
						$usedarr[] = $usedpa;
					}
					if(empty($usedarr))
					{
						$valid_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) + 86400 * $coupon['c_share_duration']);
						$result = "获得{$coupon['c_desc']}！";
					}else{
						$isok=1;
						$result = "你已经领取过该红包！";
					}
				}else{
					$isok=1;
					$result = "该红包已被领完！";
				}
			}else{
				$isok=1;
				$result = "该红包已过期！";
			}
		}
	}else{
		$result = "红包信息错误！";
	}
	

?>	
	<html>
	<head><meta charset="utf-8">
	<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script><title>宝贝在书里 · 获取红包</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script>
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
		<script type="text/javascript">
function share(){
    	var button = document.getElementById('button');
    	var img01 = document.getElementById('img01');
    	<?php 
    	$date = date("Y-m-d H:i:s");
		$valid_to = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")) + 86400 * $coupon['c_share_duration']);

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
</script></head>
<body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	    <style type="text/css">
    /*遮罩层 begin 2016-6-14 13:22:20*/
/*.floatLayer{ width:100%; height:100%; position:fixed; background:#000;  z-index:9990; top:0px; left:0px;filter:alpha(Opacity=50);-moz-opacity:0.50;opacity: 0.50;}*/
.liadloging{ width:100%; position:absolute; top:12%; left:10%; z-index:9995;  }
/*遮罩层 begin*/
    </style>
    
    <img src="http://www.babyinbook.com/babyinbook/images/coupon2.png" style=" margin-top: 5px;width: 70px;height: 70px;margin-left:270px;display:" />
    <div id="liadloging" class="liadloging" style="display:;">
    <div class="ldl_Conten">
      
       <div class="load" style="width:80%;">
	<img style="width:100%;"  src="http://www.babyinbook.com/babyinbook/images/coupon1.png" id="bigpic" />
	<div style="width:200px;height:100px;color:white;position:absolute;top:66%;left:50%;text-align: center;margin-left:-130px;">
	<span style="font-size: 21px;color: #000000"><?php echo $result; ?></span>
	</div>
	</div>
    </div>
    
</div>
<div style="margin-left: 60px;position:absolute;top:58%;display: <?php if($isok==3){echo "none";} ?>" class="pure-g">
        <div class="pure-u-18-24" style="width: 240px;"><a  href="http://weixin.babyinbook.com/newindex/index.php" class="btn btn-block btn-round btn-signup orange-linear">点击定制</a> </div>
    </div>
<div style="margin-left: 60px;position:absolute;top:58%;display: <?php if($isok==1 || $isok==3){echo "none";} ?>" class="pure-g">
        <div id="button" class="pure-u-18-24" style="width: 240px;"><button  onclick="share();" class="btn btn-block btn-round btn-signup orange-linear">点击领取</button> </div>
    </div>

<!--灰色遮罩层 begin-->


<div id="img01" style="display: <?php if($isok==0) {echo "none";}?>">
	<img src="http://www.babyinbook.com/babyinbook/images/coupon4.png" style="position:relative;z-index:9999;width: 90px;height: 90px;margin-left: 40px ;position:absolute;top:72%;">
</div>

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
