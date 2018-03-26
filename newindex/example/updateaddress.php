<?php 
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
$addressid =  $_GET['id'];
$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("babyinbook");
	$charset = mysql_query("set names utf8");
	$sql = "SELECT
	t1.*,t2.city_id,t2.province_id
FROM
	user_address t1
left join bc_dict_district t2 on t1.district_id = t2.id
WHERE
	t1.id = '$addressid'";
		$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr[] = $a;
	}
	$sql = "select * from bc_dict_province";
		$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr1[] = $a;
	}
	$sql = "select * from bc_dict_city where province_id = {$arr[0]['province_id']}";
		$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr2[] = $a;
	}
	$sql = "select * from bc_dict_district where city_id = {$arr[0]['city_id']}";
		$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$arr3[] = $a;
	}
	
?>
<html>
	<head><meta charset="utf-8"><title>宝贝在书里 ·编辑地址</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link rel="shortcut icon" href="http://www.babyinbook.com/babyinbook/img/favicon.jpg"><link href="http://www.babyinbook.com/babyinbook/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="http://www.babyinbook.com/babyinbook/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="http://www.babyinbook.com/babyinbook/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><!-- Include SweetAlert CSS and JS--><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet"><script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script><script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script><script type="text/javascript">

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

function sp_city(){
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
                var cityList = retJson.cities;
            
                var html1 = '<option value="">区</option>';
                if (cityList.length > 0) {
                    for (var i = 0; i < cityList.length; i++) {
                        var data = cityList[i];
                        html1 += '<option value=' + data.id + '>' + data.name + '</option>';
                    }
                    districtSelect.innerHTML = html1;
                }
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/getcity/id/' + cityOption.value, true);
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

function updateAddress() {
    var provinceSelect = document.getElementById('province');
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
    // validate inputs
    var provinceId = provinceSelect.options[provinceSelect.selectedIndex].value;
    var cityId = citySelect.options[citySelect.selectedIndex].value;
    var districtId = districtSelect.options[districtSelect.selectedIndex].value;
    var receiver = document.getElementsByName('receiver')[0].value;
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

     	var openid = '<?php echo $_GET['openid']; ?>';
        var userid = '<?php echo $_GET['userid']; ?>';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var resn = xhttp.responseText;
            if (resn) {
                window.location.href="http://weixin.babyinbook.com/newindex/example/addresses.php?openid=" + openid +"&userid=" + userid;
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/updateAddress', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('addressid='+<?php echo $addressid; ?>+'&districtId=' + districtId + '&receiver=' + receiver + '&phone=' + phone + '&address=' + address+'&isDefault=' + isDefault);

	// var url = "/user/addresses/" + '<?php echo $addressid; ?>' + "/update"

    // $.ajax({
                
    //             type: "POST",
    //             url:url,
    //             data:$('#updateForm').serialize(),// 你的formid
    //             async: false,
    //             error: function(request) {
    //                 alert("Connection error");
    //             },
    //             success: function(data) {
                	
    //                window.location.href="http://weixin.babyinbook.com/newindex/example/addresses.php?openid=" + openid +"&userid=" + userid 
    //             }
    //         });
}

function deleteAddress() {
    swal({
        title:'请确认',
        text:'您确定要删除这个地址么？',
        type:'warning',
        showCancelButton:true
    }, function() {
        var openid = '<?php echo $_GET['openid']; ?>';
        var userid = '<?php echo $_GET['userid']; ?>';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            var resn = xhttp.responseText;
            if (resn) {
                window.location.href="http://weixin.babyinbook.com/newindex/example/addresses.php?openid=" + openid +"&userid=" + userid;
            }
        }
    };
    xhttp.open('POST', 'http://www.babyinbook.com/babyinbook/interface.php/Index/deleteAddress', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send('addressid='+<?php echo $addressid; ?>);
	// var url = "/user/addresses/" + '<?php echo $addressid; ?>' +- "/delete"
	
    // $.ajax({
                
    //             type: "POST",
    //             url:url,
    //             data:$('#deleteForm').serialize(),// 你的formid
    //             async: false,
    //             error: function(request) {
    //                 alert("Connection error");
    //             },
    //             success: function(data) {
                	
    //                window.location.href="http://weixin.babyinbook.com/newindex/example/addresses.php?openid=" + openid +"&userid=" + userid 
    //             }
    //         });
       
    });
}</script></head>
<body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content">
		<form id="deleteForm" action="/user/addresses/<?php echo $addressid; ?>/delete" method="POST" class="hide">
		<input type="hidden" name="isDefaultRaw" value="<?php echo $arr[0]['is_default']; ?>">
		</form>
		<ul class="table-view table-card-view">
		<li class="table-view-cell input-group-cell">
		<form id="updateForm" action="/user/addresses/4765/update" method="POST" class="input-group">
		<div class="input-row">
			<label>收货人</label>
			<input type="text" name="receiver" placeholder="收货人" value="<?php echo $arr[0]['receiver']; ?>">
			</div><div class="input-row"><label>所在省</label>
				<select id="province" name="province" onchange="selectProvince();">
					<option value="">省</option>
					<?php foreach($arr1 as $key=>$value){ ?>
					<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $arr[0]['province_id']){ echo "selected ='selected'";} ?> ><?php echo $value['province_name']; ?></option>
					<?php } ?>
					</select>
				</div><div class="input-row"><label>所在市</label>
					<select id="city" name="city" onchange="selectCity();">
						<option value="">市</option>
						<?php foreach($arr2 as $key=>$value){ ?>
					<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $arr[0]['city_id']){ echo "selected ='selected'";} ?> ><?php echo $value['city_name']; ?></option>
					<?php } ?>
					</select>
					</div><div class="input-row"><label>所在区</label>
						<select id="district" name="district">
							<option value="">区</option>
								<?php foreach($arr3 as $key=>$value){ ?>
					<option value="<?php echo $value['id']; ?>" <?php if($value['id'] == $arr[0]['district_id']){ echo "selected ='selected'";} ?> ><?php echo $value['district_name']; ?></option>
					<?php } ?>
							</select></div><div class="input-row"><label>住&nbsp;&nbsp;&nbsp;址</label><input type="text" name="address" placeholder="住址" value="<?php echo $arr[0]['address']; ?>"></div>
							<div class="input-row"><label>电&nbsp;&nbsp;&nbsp;话</label><input type="tel" name="phone" placeholder="电话" value="<?php echo $arr[0]['phone']; ?>"></div><div class="input-row"><input type="hidden" name="isDefault" value="1"><label>缺&nbsp;&nbsp;&nbsp;省</label><div id="toggleDefault" onclick="toggleDefault();" class="toggle active"><div class="toggle-handle"></div></div></div></form></li></ul><div style="margin-top:30px;" class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a onclick="updateAddress();" class="btn btn-block btn-round btn-primary orange-linear">保存修改</a></div><div class="pure-u-5-24"></div></div><div class="pure-g"><div class="pure-u-5-24"></div><div class="pure-u-14-24"><a onclick="deleteAddress();" class="btn btn-block btn-round btn-primary blue-linear">删除地址</a></div><div class="pure-u-5-24"></div></div></div><nav class="bar bar-tab">
								<a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a>
								<a href="/newindex/example/user.php" class="tab-item active"><span class="icon icon-person"></span><span class="tab-label">我的</span></a>
								<a href="/newindex/example/cart.php" class="tab-item"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav><script type="text/javascript">document.querySelector('#toggleDefault .toggle-handle').addEventListener('toggle', null);</script></body>
	
</html>
