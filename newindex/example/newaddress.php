<!DOCTYPE html>
<html>
    <head><meta charset="utf-8"><title>宝贝在书里 ·新建地址</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link rel="shortcut icon" href="http://www.babyinbook.com/img/favicon.jpg"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js">     </script>
        <script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript">
        function selectProvince() {
    var provinceSelect = document.getElementById('province');
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
    var provinceOption = provinceSelect.options[provinceSelect.selectedIndex];
    // console.log('selected province id: ' + provinceOption.value);
    if (!provinceOption.value) return;

    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var retJson = JSON.parse(xhttp.responseText);
            if (!retJson.err) {
                var cityList = retJson.cities;
                console.log(cityList);
                var html = '<option value="">市</option>';
                if (cityList.length > 0) {
                    for (var i = 0; i < cityList.length; i++) {
                        var data = cityList[i];
                        html += '<option value=' + data.id + '>' + data.city_name + '</option>';
                    }
                    citySelect.innerHTML = html;
                    var html1 = '<option value="">区</option>';
                    districtSelect.innerHTML = html1;
                }
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/getcity/id/' + provinceOption.value, true);
    xhttp.send();

}

function selectCity() {
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
    var cityOption = citySelect.options[citySelect.selectedIndex];
    // console.log('selected city id: ' + citySelect.value);
    if (!citySelect.value) return;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var retJson = JSON.parse(xhttp.responseText);
            if (!retJson.err) {
                var districtList = retJson.districts
                var html = '<option value="">区</option>';
                if (districtList.length > 0) {
                    for (var i = 0; i < districtList.length; i++) {
                        var data = districtList[i];
                        html += '<option value=' + data.id + '>' + data.district_name + '</option>';
                    }
                    districtSelect.innerHTML = html;
                }
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/getarea/cid/' + cityOption.value, true);
    xhttp.send();
}

function toggleDefault() {
    var defaultInput = document.getElementsByName('isDefault')[0];
    var defaultButton = document.getElementById('toggleDefault');

    if (defaultButton.className.indexOf('active') > -1) {
        defaultInput.value = '1';
    } else {
        defaultInput.value = '0';
    }
}

function saveAddress() {
    var provinceSelect = document.getElementById('province');
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');

    // validate inputs
    var provinceId = provinceSelect.options[provinceSelect.selectedIndex].value;
    var cityId = citySelect.options[citySelect.selectedIndex].value;
    var districtId = districtSelect.options[districtSelect.selectedIndex].value;
    var receiver = document.getElementsByName('receiver_dd')[0].value;
    var phone = document.getElementsByName('phone')[0].value;
    var address = document.getElementsByName('address')[0].value;
    var isDefault = document.getElementsByName('isDefault')[0].value;


    if (!provinceId || !cityId || !districtId || !receiver || !phone || !address) {
        swal({title: '输入错误', text: '收货地址信息不完整', type:'warning'});
        return;
    } 
    if (receiver.length > 15) {
        swal({title: '输入错误', text: '收件人名称过长（不超过15个字）', type:'warning'});
        return;
    }
    if (address.length > 50) {
        swal({title: '输入错误', text: '收件人详细地址过长（不超过50个字）', type:'warning'});
        return;
    }
    if (!/^[0-9\-]{1,15}$/.test(phone)) {
        swal({title: '输入错误', text: '收件人联系电话有误', type:'warning'});
        return;
    }
    
    var userid = '<?php echo $_GET['userid']; ?>';
    var checklist = '<?php echo $_GET['checklist']; ?>';
    <?php $datecreate = date("Y-m-d H:i:s");?>

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var resn = xhttp.responseText;
            if (resn) {
              var mainForm = document.getElementById('mainForm');
              var addressId = document.getElementById('addressId');
              addressId.value = resn;
              mainForm.submit();
                // window.location.href="/babyinbook/wap/example/settle.php";
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/saveAddress', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('districtId=' + districtId + '&receiver=' + receiver + '&phone=' + phone + '&userid=' + userid + '&address=' + address
        +'&isDefault=' + isDefault +'&date_created=' + '<?php echo $datecreate; ?>');
    // $.ajax({
                
    //             type: "POST",
    //             url:'/user/addresses',
    //             data:$('#mainForm').serialize(),// 你的formid
    //             async: false,
    //             error: function(request) {
    //                 alert("Connection error");
    //             },
    //             success: function(data) {
                    
    //                window.location.href="http://weixin.babyinbook.com/newindex/example/addresses.php?openid=" + openid +"&userid=" + userid 
    //             }
    //         });
}</script></head>
<body><div class="content"><ul class="table-view table-card-view"><li class="table-view-cell input-group-cell">
    <form id="mainForm" action="settle.php" method="POST" class="input-group">
    <input id="checklist" type="hidden" name="checklist" value="<?php echo $_GET['checklist']; ?>">
    <input id="openid" type="hidden" name="openid" value="<?php echo $_GET['openid']; ?>">
    <input id="userid" type="hidden" name="userid" value="<?php echo $_GET['userid']; ?>">
    <input id="addressId" type="hidden" name="addressid" value="">
        <input type="hidden" name="from" value="undefined"><div class="input-row">
            <label>收货人</label>
        <input type="text" name="receiver_dd" placeholder="收件人">
        </div>
        <div class="input-row"><label>所在省</label><select id="province" name="province" onchange="selectProvince();"><option value="" selected="">省</option><option value="1">北京市</option><option value="2">天津市</option><option value="3">河北省</option><option value="4">山西省</option><option value="5">内蒙古自治区</option><option value="6">辽宁省</option><option value="7">吉林省</option><option value="8">黑龙江省</option><option value="9">上海市</option><option value="10">江苏省</option><option value="11">浙江省</option><option value="12">安徽省</option><option value="13">福建省</option><option value="14">江西省</option><option value="15">山东省</option><option value="16">河南省</option><option value="17">湖北省</option><option value="18">湖南省</option><option value="19">广东省</option><option value="20">广西壮族自治区</option><option value="21">海南省</option><option value="22">重庆市</option><option value="23">四川省</option><option value="24">贵州省</option><option value="25">云南省</option><option value="26">西藏自治区</option><option value="27">陕西省</option><option value="28">甘肃省</option><option value="29">青海省</option><option value="30">宁夏回族自治区</option><option value="31">新疆维吾尔自治区</option></select></div><div class="input-row"><label>所在市</label><select id="city" name="city" onchange="selectCity();"><option value="">市</option><option value="16">太原市</option><option value="17">大同市</option><option value="18">阳泉市</option><option value="19">长治市</option><option value="20">晋城市</option><option value="21">朔州市</option><option value="22">晋中市</option><option value="23">运城市</option><option value="24">忻州市</option><option value="25">临汾市</option><option value="26">吕梁市</option></select></div><div class="input-row"><label>所在区</label><select id="district" name="district"><option value="">区</option><option value="245">长治市</option><option value="246">城区</option><option value="247">郊区</option><option value="248">长治县</option><option value="249">襄垣县</option><option value="250">屯留县</option><option value="251">平顺县</option><option value="252">黎城县</option><option value="253">壶关县</option><option value="254">长子县</option><option value="255">武乡县</option><option value="256">沁县</option><option value="257">沁源县</option><option value="258">潞城市</option></select></div><div class="input-row"><label>住&nbsp;&nbsp;&nbsp;址</label><input type="text" name="address" placeholder="住址"></div><div class="input-row"><label>电&nbsp;&nbsp;&nbsp;话</label><input type="tel" name="phone" placeholder="电话"></div><div class="input-row"><input type="hidden" name="isDefault" value="1"><label>缺&nbsp;&nbsp;&nbsp;省</label><div id="toggleDefault" onclick="toggleDefault();" class="toggle active"><div class="toggle-handle"></div></div></div></form></li></ul><div style="margin-top:30px;" class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a onclick="saveAddress();" class="btn btn-block btn-round btn-primary orange-linear">新增地址</a></div><div class="pure-u-5-24"></div></div></div><nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav><script type="text/javascript">document.querySelector('#toggleDefault .toggle-handle').addEventListener('toggle', null);</script></body>
    
</html>
