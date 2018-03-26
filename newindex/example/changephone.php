<?php
$name = $_GET['name'];
$phone = $_GET['phone']; 
?>
<html><head><meta charset="utf-8"><title>宝贝在书里 · 个人资料</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link rel="shortcut icon" href="/img/favicon.jpg"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="/js/sweetalert/theme.css" rel="stylesheet"><script src="/js/sweetalert/sweetalert.min.js">           </script><script type="text/javascript">var xhttp = new XMLHttpRequest();
var sendsms = function () {
    var phone = document.getElementsByName('phone')[0].value;
    if (!/^[0-9]{11}$/.test(phone)) {
        swal({title: '输入错误', text: '用户手机号有误', type:'warning'});
        return;
    } 
    
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var result = JSON.parse(xhttp.responseText);
            if (result.success) {
                swal({title: '成功', text: '短信验证码发送成功', type:'success'});    
            } else {
                swal({title: '您访问的页面正在维护中...&lt;br/&gt;请稍后回來。', text: '短信验证码发送失败，请重试', type:'error'}); 
            }  
        }
    };

    xhttp.open('POST', '/api/sendsms', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('mobile=' + document.getElementsByName('phone')[0].value);
};

function saveProfile() {
    var name = document.getElementsByName('name')[0].value;
    var phone = document.getElementsByName('phone')[0].value;
    if (!name || !phone) {
        swal({title: '输入错误', text: '用户信息不完整', type:'warning'});
        return;
    }
    if (name.length > 30) {
        swal({title: '输入错误', text: '用户名称过长（不超过30个字）', type:'warning'});
        return;
    }
    if (!/^[0-9]{11}$/.test(phone)) {
        swal({title: '输入错误', text: '用户手机号有误', type:'warning'});
        return;
    }                
    document.getElementById('mainForm').submit();
}</script></head><body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)--><div class="content"><ul class="table-view table-card-view"><li class="table-view-cell input-group-cell"><form id="mainForm" action="user.php" method="POST" class="input-group"><div class="input-row"><label>昵&nbsp;&nbsp;&nbsp;称</label><input name="name" type="text" placeholder="昵称" value="<?php echo $name; ?>"></div><div class="input-row"><label>手机号</label><input name="phone" type="tel" placeholder="手机号" value="<?php echo $phone; ?>"></div><div class="input-row"><label>验证码</label><button type="button" onclick="sendsms()" class="btn pull-right btn-sms">点击获取</button><input name="verification" type="tel" placeholder="验证码" style="width:50%;"></div></form></li></ul><div style="margin-top:30px;" class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a onclick="saveProfile();" class="btn btn-block btn-round btn-primary orange-linear">保存修改</a></div><div class="pure-u-5-24"></div></div></div><nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body></html>
