<?php

session_start();
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
$openId = $_GET['openId'];
// $c_code = isset($_GET['c_code'])?$_GET['c_code']:'0';//更换成下面代码
$rolenum = isset($_GET['rolenum'])?$_GET['rolenum']:'0';
$c_code = isset($_SESSION['c_code'])?$_SESSION['c_code']:'0';
$bookid = isset($_GET['bookid'])?$_GET['bookid']:'0';
$oid = isset($_GET['oid'])?$_GET['oid']:'0';
$cid = isset($_GET['cid'])?$_GET['cid']:'0';

// echo 'login';
// var_dump($_SESSION['c_code']);die;


//if(empty($openId)){
//    header('Location: http://weixin.babyinbook.com/newindex/index.php');
//}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>宝贝在书里 · 登录</title>
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

            background: rgb(252,128,99);
            float: left;
            text-align: center;
            line-height: 38px;
            font-family: 'Arial Negreta', 'Arial Normal', 'Arial';
            font-weight: 700;
            font-style: normal;
            font-size: 16px;
            color: #FFFFFF;
        }
    </style>
    <script src="http://www.babyinbook.com/javascripts/jquery-1.12.0.min.js"></script>
    <script src="http://www.babyinbook.com/javascripts/md5.js"></script>

    <script>
        var DOMAIN = "http://www.babyinbook.com/";
        var UPLOAD_URL = "http://www.babyinbook.com/uploads/";
    </script>

    <!-- Use Google CDN for jQuery and jQuery UI -->


</head>
<script>
    $(document).ready(function(){
        //nav2_icon
        $(window).resize(function() {
            $("#nav2").slideUp();
            $("#nav2").data('show',false);
        });

        $("#nav2_icon").click(function(){
            if(!$("#nav2").data('show')){
                $("#nav2").slideDown();
                $("#nav2").data('show',true);
            }
            else{
                $("#nav2").slideUp();
                $("#nav2").data('show',false);
            }
        });


        $("li a").click(function(){
            $('html, body').animate({
                scrollTop: $($(this).attr("href")).offset().top
            }, 1000);
        })

        //scroll to top
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) $("#scrollup").fadeIn();
            else $("#scrollup").fadeOut();
        });

        $('#scrollup').click(function(){
            $("html, body").animate({ scrollTop: 0 }, 1000);
        });

    })
</script>
</head>
<body >
<div class="content content-home">

    <form id="rlogin" action="/babyinbook/index.php/Web/RLogin" method="post">
        <input type="hidden" name="raccount" value="" />
        <input type="hidden" name="rcaptcha" value="" />
        <input type="hidden" name="rpassword" value="" />
        <input type="hidden" name="towx" value="1" />
        <input type="hidden" name="openid" value="<?php echo $openId; ?>" />
        <?php if(!empty($oid)){?>
            <input type="hidden" name="oid" value="<?php echo $oid;?>" />
        <?php } ?>
        <?php if(!empty($cid)){?>
            <input type="hidden" name="cid" value="<?php echo $cid;?>" />
        <?php	}?>
        <?php if(!empty($c_code)){?>
            <input type="hidden" name="c_code" value="<?php echo $c_code;?>" />
        <?php   }?>
        <?php if(!empty($rolenum)){?>
            <input type="hidden" name="rolenum" value="<?php echo $rolenum;?>" />
        <?php   }?>
        <?php if(!empty($bookid)){?>
            <input type="hidden" name="bookid" value="<?php echo $bookid;?>" />
        <?php   }?>
    </form>

    <form id="form">
        <div style="margin-top: 30px;" class="pure-g">
            <div class="pure-u-3-24"></div>
            <div style="text-align: center" class="pure-u-18-24" >
                <img src="http://www.babyinbook.com/images/logo.jpg" />
            </div>
            <div class="pure-u-5-24"></div>
        </div>
        <div style="margin-top: 30px;line-height:35px;" class="pure-g">
            <div class="pure-u-2-24"></div>
            <div class="pure-u-5-24" style="font-size: 12px;">手机号：</div>
            <div style="text-align: center" class="pure-u-15-24" >
                <input type="number" placeholder="请输入手机号码" name="account" id="phone"/>
            </div>
            <div class="pure-u-2-24"></div>
        </div>
        <div style="margin-top: 10px;line-height:35px;" class="pure-g">
            <div class="pure-u-2-24"></div>
            <div class="pure-u-5-24" style="font-size: 12px;">密码：</div>
            <div style="text-align: left" class="pure-u-15-24" >
                <input type="password"  id="validate" name="password" placeholder="输入密码"  >
            </div>
        </div>
    </form>

    <input name="agree" type="hidden" value="1"/>

    <div style="margin-top: 30px;" class="pure-g">
        <div class="pure-u-3-24"></div>
        <div class="pure-u-18-24" style="width: 130px;margin-left: -15px"><a  href="#" id="submit" class="btn btn-block btn-round btn-signup orange-linear">登陆</a></div>
        <div class="pure-u-18-24" style="width: 130px;margin-left: 30px"><a  href="http://www.babyinbook.com/babyinbook/signup.php?openId=<?php echo $openId;?>&oid=<?php echo $oid;?>&cid=<?php echo $cid; ?>&c_code=<?php echo $c_code; ?>&rolenum=<?php echo $rolenum; ?>&bookid=<?php echo $bookid; ?>" class="btn btn-block btn-round btn-signup orange-linear">注册</a></div>
        <div class="pure-u-5-24"></div>
    </div>
	<a href="forget.php" style="margin-left:35px">忘记密码</a>
</div>
<script>

$('#submit').click(function()
{
    var account = $("input[name='account']").val();
    var password = $("input[name='password']").val();
    var open_id = "<?php echo $openId;?>";
    if (account.length == 0) { return alert("请输入电话") }
    if (password.length == 0) { return alert("请输入密碼") }
    password = hex_md5(password);
    var bookid = '<?php echo $bookid; ?>';
    var rolenum = '<?php echo $rolenum; ?>';
    var c_code = '<?php echo $c_code; ?>';
    // alert(c_code);return;
    var oid = '<?php echo $oid; ?>';
    var cid = '<?php echo $cid; ?>';
    $.ajax
    ({
        type:'post',
        data:{phone:account,open_id:open_id,password:password},
        url:'http://www.babyinbook.com/babyinbook/interface.php/Web/checkPhone',
        sync:false,
        success:function (data) {
            if(data == 1){
                if (bookid!='0') {
                    if (rolenum!='0') 
                    {   //署名台历，定制图书页
                        //window.location.href="http://www.babyinbook.com/newindex/example/make.php?rolenum=" + rolenum + "&bookid=" + bookid + "&openid=" + open_id;
                        window.location.href="http://weixin.babyinbook.com/newindex/example/make.php?rolenum=" + rolenum + "&bookid=" + bookid + "&openid=" + open_id;
                    }
                    }else if (c_code!='0') {
                        //前面的路径来回跳，判断比较多，所以。。。这里只能再加一个判断
                         if(c_code!='0')
                         {
                            // alert(c_code );return;
                            window.location.href="http://weixin.babyinbook.com/newindex/example/couponget.php";//
                         }else{
                            //window.location.href="http://www.babyinbook.com/newindex/example/make.php?c_code=" + c_code + "&openid=" + open_id;
                            window.location.href="http://weixin.babyinbook.com/newindex/example/make.php?c_code=" + c_code + "&openid=" + open_id;//台历
                         }
                    }else if (oid!='0' && cid!='0') {
                        //window.location.href="http://www.babyinbook.com/newindex/example/make.php?oid=" + oid + "&cid=" + cid;
                        window.location.href="http://weixin.babyinbook.com/newindex/example/make.php?oid=" + oid + "&cid=" + cid;
                    }else{
    					// window.location.href="http://weixin.babyinbook.com/newindex/index.php";//之前的代码，下面是更新
                         window.location.href="http://weixin.babyinbook.com/newindex/example/couponget.php";
    				}
            }else if(data == 2){
                alert('密码错误');
            }else{
                alert('您还没有注册，点击注册按钮去注册');
            }
        }
    })
})

</script>


</body>
</html>

