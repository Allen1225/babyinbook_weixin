<?php

$c_code = isset($_GET['c_code'])?$_GET['c_code']:'0';
$rolenum = isset($_GET['rolenum'])?$_GET['rolenum']:'0';
$bookid = isset($_GET['bookid'])?$_GET['bookid']:'0';
$oid = isset($_GET['oid'])?$_GET['oid']:'0';
$cid = isset($_GET['cid'])?$_GET['cid']:'0';
	header("Content-Type:text/html; charset=utf-8");

	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$id = $_GET['id'];
	$charset = mysql_query("set names utf8");
	$sql = "select * from bib_v1_bookinfo where id = $id";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$book[] = $a;
	}
	$bookinfo = $book[0];
	$sql = "select * from bib_v1_itempic where bookid = $id";
	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$item[] = $a;
	}

 ?>
<html>
<head>
	<meta charset="utf-8">
	<title>宝贝在书里 · 注册账户</title>
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
	  <form id="signin" action="/babyinbook/index.php/Web/ConnectLogin" method="post"> 
      <input type="hidden" name="waccount" value="" />
      <input type="hidden" name="wpassword" value="" />
      <input type="hidden" name="wopenid" value="<?php echo $_SESSION['openid']; ?>" />
	  <input type="hidden" name="wunionid" value="<?php echo $_SESSION['unionid']; ?>" />
      </form>
      <form id="rlogin" action="/babyinbook/index.php/Web/RLogin" method="post"> 
      <input type="hidden" name="raccount" value="" />
      <input type="hidden" name="rpassword" value="" />
	<?php if(!empty($oid)){?>
            <input type="hidden" name="oid" value="<?php echo $oid;?>" />
        <?php } ?>
        <?php if(!empty($cid)){?>
            <input type="hidden" name="cid" value="<?php echo $cid;?>" />
        <?php   }?>
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
		<input type="text" placeholder="请输入手机号码" name="account" />
	</div>
	<div class="pure-u-2-24"></div>
</div>
 <div style="margin-top: 10px;line-height:35px;" class="pure-g">
	<div class="pure-u-2-24"></div>
	<div class="pure-u-5-24" style="font-size: 12px;">验证码：</div>
	<div style="text-align: left" class="pure-u-10-24" >
		        <input type="text" class="input2" id="validate" name="check" placeholder="输入验证码"  style="width:80%">
	</div>
	<div class="pure-u-5-24">
		<a href="javascript:void(null)" onclick="javascript:ChangeImg()" id="captcha_btn2">
      <img title="" alt="" border="0" id="CheckImg" src="http://www.babyinbook.com/lib/check_code/securimage_show.php" style="width:100px;height:38px;float:right" />
     </a></div>
	<div class="pure-u-2-24"></div>
	</div>

<div  class="pure-g" style="border-bottom:1px solid #222;padding-bottom: 10px;">
	<div class="pure-u-8-24"></div>
	<div class="pure-u-8-24">
	 <a href="" id="captcha_btn" class="btn   btn-signup green-linear" style="padding:10px;font-size: 15px;border-radius: 5px;">发送手机认证码</a> 
	</div>
	<div class="pure-u-8-24"></div></div></form>

<div style="margin-top: 10px;line-height:35px;" class="pure-g">
	<div class="pure-u-2-24"></div>
	<div class="pure-u-5-24" style="font-size: 12px;">手机验证码：</div>
	<div style="text-align: center" class="pure-u-15-24" >
		<input type="text" placeholder="请输入认证码" id="captcha" name="captcha">
	</div>
	<div class="pure-u-2-24"></div>
</div>

<div style="margin-top: 10px;line-height:35px;" class="pure-g">
	<div class="pure-u-2-24"></div>
	<div class="pure-u-5-24" style="font-size: 12px;">密码：</div>
	<div style="text-align: center" class="pure-u-15-24" >
		 <input type="password" name="password" placeholder="6~20个大小写字母、数字或符号">
	</div>
	<div class="pure-u-2-24"></div>
</div>

<div style="margin-top: 10px;line-height:35px;" class="pure-g">
	<div class="pure-u-2-24"></div>
	<div class="pure-u-5-24" style="font-size: 12px;">确认密码：</div>
	<div style="text-align: center" class="pure-u-15-24" >
		<input type="password"  name="cpassword"  placeholder="请再输入一次密码">
	</div>
	<div class="pure-u-2-24"></div>
</div>



    	
      
      
	  
     
	 
	  
     
      
    
     
  

<div style="margin-top: 30px;" class="pure-g"><div class="pure-u-3-24"></div><div class="pure-u-18-24"><a  href="#" id="submit" class="btn btn-block btn-round btn-signup orange-linear">登录</a></div><div class="pure-u-5-24"></div></div></form>
</div>
  </form>
<script>
function ChangeImg()
{
    $('#CheckImg')
       .attr('src', DOMAIN+'lib/check_code/securimage_show.php?sid='+Math.random()) ;
}

$(function(){

    $(document)
    .on('click', "#submit", function(e){

        e.preventDefault() ;
        var account = $("input[name='account']").val()
        var password = $("input[name='password']").val()
        var cpassword = $("input[name='cpassword']").val()
        var agree = $("input[name='agree']:checkbox:checked").length > 0
        
        if (agree == false) { return alert("尚未同意注册条款") }
        if (account.length == 0) { return alert("请输入电话") }
        if (password.length == 0) { return alert("请输入密碼") }
        if (password != cpassword) { return alert("确认密码不符") }
       
        $.ajax(
        {
            url: DOMAIN + 'main/smsregister.json',
            type: 'POST',
            data: $("#form").serialize(),
            dataType: 'json'
        })
        .always(function(data)
        {
            
            alert(data.reason);

            if (data.code == 200)
            {
            	if('<?php echo $_GET['type']; ?>' == 'wx'){
            		$("input[name='waccount']").val($("input[name='account']").val());
            		$("input[name='wpassword']").val($("input[name='password']").val());
            		document.getElementById("signin").submit();
            	}else{
               $("input[name='raccount']").val($("input[name='account']").val());
            		$("input[name='rpassword']").val($("input[name='password']").val());
            		document.getElementById("rlogin").submit();
        		}
        }})
    })
    $("#captcha_btn").click(function(e){
        
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
            url: DOMAIN+'sms.json',
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
            }
        })
    })
    

    $('input[name=m_pwd], input[name=m_acc], input[name=check]')
            .keypress(function(event)
            {
                if (event.which == 13)
                {
                    document.loginForm.submit() ;
                }
            }) ;
    
    showGetPwd = function()
    {
        $('#fpwd').css('display', 'none') ;
    }
    showSmGetPwd = function()
    {
        $('#fpwd').css('display', 'block') ;
    }
    
    chkForgetPwd = function()
    {
        var m_acc = document.forgetpwd.account.value ;
        var email = document.forgetpwd.email.value ;
        if (email)
        {
            $.ajax(
            {
                type: 'POST',
                url: DOMAIN+'admin/forget.json',
                dataType: 'json',
                async: false,
                data:
                {
                    account: m_acc,
                    email: email
                },
                success: function(data)
                {
                    if (data != null && data.code != undefined)
                    {
                        showGetPwd() ;
                        alert(data.data) ;
                    }
                    else
                    {
                        if (data != null)
                        {
                            alert(data) ;
                        }
                    }
                }
            }) ;
        }
        else
        {
            alert('是不是缺少了什麼?!')
        }

        return false ;
    }
    $('#notice').click(function (e) {
//        $('#nicescrollinner').css( 'display', 'block' )
        $('#nicescrollinner').toggle();
    });

    $('input').keypress(function (e) {
      if (e.which == 13) {
        $('#submit').click();
        return false;    //<---- Add this line
      }
    });
}) ;
</script>


</body>
</html>
