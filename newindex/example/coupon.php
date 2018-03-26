<?php 
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');

session_start();
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
    
    $sql = "select * from babyinbook.pb_member where  m_wechat_openid= '$openId'";
    $res = mysql_query($sql);
    while($a = mysql_fetch_assoc($res)){
        $arr1[] = $a;
    }
    $member = $arr1[0];
    $sql = "select *,t1.id as mycouid from babyinbook.user_coupon t1
        left join babyinbook.coupon t2 on t1.coupon_id = t2.id
         where t1.user_id = '{$member['m_id']}' order by date_used asc,valid_to desc";
    $res = mysql_query($sql);
    while($a = mysql_fetch_assoc($res)){
        $coupon[] = $a;
    }
    foreach($coupon as $key=>$value){
            if(!empty($value['date_used'])){
                $coupon[$key]['status'] = 'used';
                $coupon[$key]['col'] = 'grey';
            }else if($value['valid_to'] < date("Y-m-d")){
                $coupon[$key]['status'] = 'outime';
                $coupon[$key]['col'] = 'grey';
            }else{
                $coupon[$key]['status'] = 'can';
                $coupon[$key]['col'] = 'red';
            }
        }


?>
<html>
<head><meta charset="utf-8"><title>宝贝在书里 · 我的红包</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><link rel="shortcut icon" href="/img/favicon.jpg"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="http://www.babyinbook.com/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/js/sweetalert/sweetalert.min.js"></script></head>
<body>
<script type="text/javascript">
function hert(){
    window.location.href="/newindex/index.php";
}
</script>>
    <!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
    <div class="content" style="background:white">

        <?php foreach($coupon as $key=>$value){ ?>
        <div style="width:100%;height:105px;margin-top:15px;position: relative;" onclick="hert()">
            <img style="max-width:100%;max-height:100%; position:absolute;" src="http://www.babyinbook.com/babyinbook/images/newcoupon<?php echo $value['status']; ?>_3.png" />
            <div style=" position:absolute;<?php if($value['status'] == 'can'){echo "color:red;";}else{echo "color: #838384;";} ?>font-size:25px;float:left;font-weight: bold;margin-top: 30px;margin-left: 29px"><?php echo $value['c_disc_amount']; ?></div>

            <?php if($value['c_threshold']!=2){?>
                <div style="position: absolute;<?php if($value['status'] == 'can'){echo "color:red;";}else{echo "color: #838384;";} ?>;float: left;margin-top: 59px;margin-left: 14px;font-size:10px">无门槛红包</div>
            <?php }else{?>
                <div style="position: absolute;<?php if($value['status'] == 'can'){echo "color:red;";}else{echo "color: #838384;";} ?>;float: left;margin-top: 59px;margin-left: 14px;font-size:10px">满<?php echo $value['c_disc_threshold']; ?>减<?php echo $value['c_disc_amount']; ?></div>
            <?php }?>

        <div style=" position:absolute;font-size:13px;float:left;font-weight: bold;margin-top: 10px;margin-left: 120px"><?php echo $value['c_name']; ?></div>

        <div style=" position:absolute;font-size:11px;color: #838384;float:left;margin-top: 40px;margin-left: 120px"><?php echo substr($value['valid_to'],2,14) . "  过期"; ?></div>

        <div style=" display: <?php if(ceil((strtotime($value['valid_to']) - time())/3600)>48 || $value['status'] != 'can'){echo "none";}?>;position:absolute;font-size:11px;color: red;font-weight: bold;float:left;margin-top: 40px;margin-left: 215px"><?php echo "（仅剩" . ceil((strtotime($value['valid_to']) - time())/3600) . "小时）"; ?></div>
            <?php if($value['c_threshold']!=2){?>
                <div style="position: absolute;color:#838384;float: left;margin-left:119px;font-size: 11px;font-weight: bold;margin-top:67px; ">只能一次抵扣,订单不足券款余额不退</div>
            <?php }else{?>
                <div style="position: absolute;color:#838384;float: left;margin-left:119px;font-size: 11px;font-weight: bold;margin-top:67px; ">需要订单金额满<?php echo $value['c_disc_threshold']?>元减<?php echo $value['c_disc_amount']; ?></div>
            <?php }?>
        </div>
        <?php } ?>
        
        </div><nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>  

</html>
