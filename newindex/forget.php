<?php
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
$openId = $_GET['openId'];
$c_code = isset($_GET['c_code'])?$_GET['c_code']:'0';
$rolenum = isset($_GET['rolenum'])?$_GET['rolenum']:'0';
$bookid = isset($_GET['bookid'])?$_GET['bookid']:'0';
$oid = isset($_GET['oid'])?$_GET['oid']:'0';
$cid = isset($_GET['cid'])?$_GET['cid']:'0';
?>
<html>
<head>
    <meta charset="utf-8">
    <title>宝贝在书里 · 忘记密码</title>
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
            <div class="pure-u-5-24" style="font-size: 12px;">验证码：</div>
            <div style="text-align: left;width:120px" class="pure-u-15-24" >
                <input type="password"  id="validate" name="password" placeholder="输入验证码"  >
            </div>
			<div>
				<img height="30px" src="http://www.babyinbook.com/lib/check_code/securimage_show.php" onclick="javascript:this.src='http://www.babyinbook.com/lib/check_code/securimage_show.php?sid='+Math.random()">
			</div>
        </div>
		<div>
			<input id="submit" type="button" value="发送新密码">
		</div>
    </form>
   <script>
		$("#submit").click(function(e){

                e.preventDefault() ;

                var code = $("#validate").val() ;
                var phone = $("input[name='account']").val() ;

                if (code.length <= 0)
                {
                    alert("请输入验证码") ;
                    return;
                }

                if (phone.length <= 0|| phone.match(/\d/g).length <= 7)
                {
                    alert("电话栏位不正确") ;
                    return;
                }
                $.ajax(
                        {
                            type: 'POST',
                            url: 'http://www.babyinbook.com/babyinbook/index.php/Ping/forgetPassword',
                            dataType: 'json',
                            async: false,
                            data:
                            {
                                check_code: code,
                                phone: phone
                            },
                            success: function(data)
                            {
                                alert(data.reason)

                                ChangeImg();

                                window.location.href = 'http://www.babyinbook.com/newindex/login.php';
                            }
                        })
            })
   </script>
</div>
</body>
</html>