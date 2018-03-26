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
	$db = mysql_select_db("babyinbook");
	$charset = mysql_query("set names utf8");
	$sql = "select * from pb_member where m_wechat_openid = '$openId'";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$member[] = $a;
	}
	
$rolenum = $_GET['rolenum'];
$bookid = $_GET['bookid'];
	if(empty($member)){
		header("Location: http://www.babyinbook.com/newindex/login.php?openId=$openId&rolenum=$rolenum&bookid=$bookid");
		// header("Location: http://www.babyinbook.com/babyinbook/signup.php?openId={$openId}");
	}else{
		$_SESSION['member'] = $member;
	}
$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/Preview/id/{$bookid}";
$json = file_get_contents($url);
$res = json_decode($json,true);

$icon = 1;
$eventnum = $res['bookinfo']['eventnum1'] + $res['bookinfo']['eventnum2'];

$na="http://www.babyinbook.com/babyinbook/interface.php/Index/getname/bookid/{$_GET['bookid']}/openid/{$_GET['openid']}";
$name=file_get_contents($na);
$name = json_decode($name,true);
$name = str_replace(".", "/", $name['title']);

?>
<html><head>
	<meta charset="utf-8">
	<title>宝贝在书里 · 定制</title>
	<!-- Sets initial viewport load and disables zooming-->
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	<!-- Makes your prototype chrome-less once bookmarked to your phone's home screen-->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link href="/css/pure-min.css" rel="stylesheet">
	<!-- Include the compiled Ratchet CSS-->
	<link href="/css/ratchet.min.css" rel="stylesheet">
	<!-- Include the Awesome Font CSS-->
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/app.css" rel="stylesheet">
	<!-- Include the compiled Ratchet JS-->
	<script src="/js/ratchet.min.js"></script>
	<!-- Include SweetAlert CSS and JS-->
	<link href="/js/sweetalert/sweetalert.css" rel="stylesheet">
	<link href="/js/sweetalert/theme.css" rel="stylesheet">
	<script src="/js/sweetalert/sweetalert.min.js"></script>
	<script src="http://www.babyinbook.com/babyinbook/js/jquery-1.9.1.min.js"></script>
	<style type="text/css">
	.selected{
			border:2px solid rgb(142,208,0);
		}
		.unselected{
			border:1px solid #ccc;
		}
		.selected2{
			border:2px solid rgb(142,208,0);
		}
		.selected3{
			border:2px solid rgb(142,208,0);
		}
		.selected4{
			border:2px solid rgb(142,208,0);
		}
	</style>
</head>
<body>
	<div id="overlay" style="display: none;">
		<div class="overlay"></div>
		<img src="http://www.babyinbook.com/babyinbook/img/loading.gif" class="overlay-label">
	</div>
	<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content content-home">
		<?php if($res['bookinfo']['kind'] == 1){ ?>
			<form id="mainForm" action="preview.php" onsubmit="return createBook();"  method="POST">
				<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
		<?php }else if($res['bookinfo']['kind'] == 2){ ?>
			<form id="mainForm" action="http://www.babyinbook.com/babyinbook/interface.php/Index/insert" onsubmit="return createCand();"  method="POST">
		
		<?php } ?>
			<input type="hidden" name="bookid" value="<?php echo $_GET['bookid']; ?>" />
			<input type="hidden" name="role" value="<?php echo $_GET['rolenum']; ?>" />

				<input type="hidden" name="openid"  value="<?php echo $_SESSION['openId']?>" />
			<div class="card">
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; $icon++; ?>.png" class="icon-step">&nbsp;请输入名字
			<input type="text" id="name" name="name" placeholder="<?php if($_GET['bookid']==59){echo '11个以内英文字母';}else{echo '4位以内中文或8位以内英文';}?>"  value="<?php if(!empty($name)){echo base64_decode($name);}?>" class="input-name">
			</div>
			<?php if($res['bookinfo']['englishname'] == 1){ ?>
			<div class="card">
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; $icon++; ?>.png" class="icon-step">&nbsp;请输入英文名
			<input type="text" onkeyup="value=value.replace(/[^\a-\z\A-\Z]/g,'')" onpaste="value=value.replace(/[^\a-\z\A-\Z]/g,'')" oncontextmenu = "value=value.replace(/[^\a-\z\A-\Z]/g,'')"  id="englishname" name="englishname" placeholder="11位以内英文"  value="" class="input-name">
			</div>
			<?php } ?>
			
			
			
			<?php if($res['bookinfo']['kind'] == 1){ ?>
			<div class="card"><div class="card-title"></div>
			<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; $icon++; ?>.png" class="icon-step">&nbsp;选择角色
			<div id="genderToggle" class="toggle toggle-gender active pull-right">
				<div class="toggle-handle"></div></div>
				<div id="maleCharactors" style="display:block" class="pure-g charactor-row">
					<input name="character" type="hidden" value="<?php echo $res['roleinfo']['male1'][0]['id']; ?>" />
					
					<?php foreach($res['roleinfo']['male1'] as $key => $value){ ?>
					<div class="pure-u-8-24">
						<a href="javascript:;" class="character <?php if($key == 0){ echo 'active';}else{ echo ''; } ?>">
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="character-unselected img-responsive">
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" style="border:2px solid rgb(142,208,0)" class="character-selected img-responsive">
						</a><input name="character" type="radio" value="<?php echo $value['id']; ?>" class="hidden">
						
					</div>
					<?php } ?>
				</div>
				
				<div id="femaleCharactors" style="display: none;" class="pure-g charactor-row">
						<?php foreach($res['roleinfo']['female1'] as $key => $value){ ?>
					<div class="pure-u-8-24"><a href="javascript:;" class="character">
					<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="character-unselected img-responsive">
							<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" style="border:2px solid rgb(142,208,0)" class="character-selected img-responsive">
					
					</a><input name="character" type="radio" value="<?php echo $value['id']; ?>" class="hidden"></div>
				<?php } ?>
						</div>
								</div>
				<div class="card" <?php if($rolenum == 1 || 1==1){ echo "style='display:none'"; }?>>
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; if($rolenum == 2){ $icon++;} ?>.png" class="icon-step">&nbsp;请输入另一个名字 
			<input type="text" id="name2"  name="name2" placeholder="4位以内中文或8位以内英文" data="en" value="" class="input-name">
			</div>	
			
			<div class="card" <?php if($rolenum == 1 || 1==1){ echo "style='display:none'"; }?>>
				<input name="character2" type="hidden" value="<?php echo $res['roleinfo']['male2'][0]['id']; ?>" />
						
				<div class="card-title"></div>
			<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; if($rolenum == 2){ $icon++;} ?>.png" class="icon-step">&nbsp;选择另一个角色
			<div id="genderToggle1" class="toggle toggle-gender active pull-right">
				<div class="toggle-handle"></div></div>
				<div id="maleCharactors1" style="display:block" class="pure-g charactor-row">
					<?php foreach($res['roleinfo']['male2'] as $key => $value){ ?>
					<div class="pure-u-8-24">
							<a href="javascript:;">
							<img   src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>"  class="<?php if($key ==0){echo 'selected';} ?> character2 img-responsive"><input type="radio" name="character2"  value="<?php echo $value['id']; ?>" style="display: none" />
					</a></div>
					<?php } ?>
				</div>
				
				<div id="femaleCharactors1" style="display: none;" class="pure-g charactor-row">
						<?php foreach($res['roleinfo']['female2'] as $key => $value){ ?>
					<div class="pure-u-8-24"><a href="javascript:;" >
							<img  src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>"  class="character2 img-responsive"><input type="radio" name="character2"  value="<?php echo $value['id']; ?>" style="display: none" />
					</a></div>
				<?php } ?>
				
						</div>
						</div>	
			
				<div class="card" <?php if(count($res['eventinfo']['top']) <=1) echo "style='display:none'"; ?>>
				<div class="card-title"></div>

				
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; if(count($res['eventinfo']['top']) >1) $icon++; ?>.png" class="icon-step">
				&nbsp;<?php echo $res['bookinfo']['topmessage']; ?><div class="pure-g pal-row">
					<?php foreach($res['eventinfo']['top'] as $key => $value){ ?>
						<div class="pure-u-6-24">
						<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="pal pal2 <?php if($key ==0) echo "selected2"; ?>"><input type="radio" <?php if($key ==0) echo "checked='checked'"; ?> name="top" value="<?php echo $value['id'].",".$value['page']; ?>" style="display: none" /><p style="text-align: center"><?php echo $value['name']; ?>&nbsp;</p></div>
					<?php } ?>
						
					</div>
				</div>		
						
			<div class="card" <?php if(empty($res['eventinfo']['event'])) echo "style='display:none'"; ?>>
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; $icon++; ?>.png" class="icon-step">
				&nbsp;<?php echo $res['bookinfo']['eventmessage']; ?><div class="pure-g pal-row">
	
					
					<?php foreach($res['eventinfo']['event'] as $key => $value){ ?>
					<?php if(count($res['eventinfo']['event']) == 5 && $key >= 3){  ?>
						<div class="pure-u-2-24"></div>
					<?php } ?>
					<div class="pure-u-<?php if(count($res['eventinfo']['event']) == 5){ echo 8; }else{ echo 6;} ?>-24">
					
					
						<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="pal pal1"><input type="checkbox" name="event[]" value="<?php echo $value['id']; ?>" style="display: none" /> <p style="text-align: center"><?php echo $value['name']; ?>&nbsp;</p></div>
						
					<?php } ?>
						
					</div>
			</div>
			<div class="card" <?php if(count($res['eventinfo']['mid']) <=1 || $_GET['bookid'] == 11) echo "style='display:none'"; ?>>
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; if(count($res['eventinfo']['mid']) >1) $icon++; ?>.png" class="icon-step">
				&nbsp;<?php echo $res['bookinfo']['midmessage']; ?><div class="pure-g pal-row">
					<?php foreach($res['eventinfo']['mid'] as $key => $value){ ?>
						<div class="pure-u-6-24">
						<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="pal pal3 <?php if($key ==0) echo "selected3"; ?>"><input type="radio" <?php if($key ==0) echo "checked='checked'"; ?> name="mid" value="<?php echo $value['id'].",".$value['page']; ?>" style="display: none" /><p style="text-align: center"><?php echo $value['name']; ?>&nbsp;</p></div>
					<?php } ?>
						
					</div>
					
				
					</div>
					<div class="card" <?php if(count($res['eventinfo']['bottom']) <=1) echo "style='display:none'"; ?>>
				<div class="card-title"></div>
				<img src="http://www.babyinbook.com/babyinbook/img/icon_<?php echo $icon; if(count($res['eventinfo']['bottom']) >1) $icon++; ?>.png" class="icon-step">
				&nbsp;<?php echo $res['bookinfo']['bottommessage']; ?><div class="pure-g pal-row">
					<?php foreach($res['eventinfo']['bottom'] as $key => $value){ ?>
						<div class="pure-u-6-24">
						<img src="http://www.babyinbook.com/babyinbook/Public/upload/<?php echo $value['pic']; ?>" class="pal pal4 <?php if($key ==0) echo "selected4"; ?>"><input type="radio" <?php if($key ==0) echo "checked='checked'"; ?> name="bottom" value="<?php echo $value['id'].",".$value['page']; ?>" style="display: none" /><p style="text-align: center"><?php echo $value['name']; ?>&nbsp;</p></div>
					<?php } ?>
						
					</div>
					
				
					</div>
				<div style="margin-top:30px;" class="pure-g">
					<div class="pure-u-5-24"></div>
					<div class="pure-u-14-24">
						<input type="submit" value="创建绘本" class="btn btn-block btn-round btn-primary">
					</div>
				<div class="pure-u-5-24"></div></div>
				
				<?php }else{?> 
				<div style="margin-top:30px;" class="pure-g">
					<div class="pure-u-5-24"></div>
					<div class="pure-u-14-24">
						<input type="submit" value="创建台历" class="btn btn-block btn-round btn-primary">
					</div>
				<div class="pure-u-5-24"></div></div>	
				<?php } ?>
				</form></div>
				<nav class="bar" style='bottom: 50px;background-color:transparent;'> 
	<a href="/newindex/example/customer.php"><img style="height:30px;float:right" src="http://www.babyinbook.com/babyinbook/images/customer.png"></a>
	</nav>
				<nav class="bar bar-tab">
				<a href="/newindex/index.php" class="tab-item active">
					<span class="icon icon-home"></span>
					<span class="tab-label">首页</span>
				</a>
				<a href="/newindex/example/user.php" class="tab-item">
					<span class="icon icon-person"></span>
					<span class="tab-label">我的</span>
				</a>
				<a href="/newindex/example/cart.php" class="tab-item">
					<span class="icon fa fa-shopping-cart"></span>
					<span class="tab-label">购物车</span>
				</a>
			</nav>
		<?php if($res['bookinfo']['kind'] == 1){ ?>
			<script type="text/javascript">
			document.getElementById('mainForm').reset();

			document.getElementById('genderToggle').addEventListener('toggle', function toggleGender() {
    if (this.className.indexOf(' active') >= 0) {
        document.getElementById('femaleCharactors').style.display = 'none';
        document.getElementById('maleCharactors').style.display = 'block';
    } else {
        document.getElementById('maleCharactors').style.display = 'none';
        document.getElementById('femaleCharactors').style.display = 'block';
    }
});
document.getElementById('genderToggle1').addEventListener('toggle', function toggleGender() {
    if (this.className.indexOf(' active') >= 0) {
        document.getElementById('femaleCharactors1').style.display = 'none';
        document.getElementById('maleCharactors1').style.display = 'block';
    } else {
        document.getElementById('maleCharactors1').style.display = 'none';
        document.getElementById('femaleCharactors1').style.display = 'block';
    }
});
var characterLink = document.querySelectorAll('.character');
for (var i = 0; i < characterLink.length; i++) {
    characterLink[i].addEventListener('click', function (event) {
        var activeCharacter = document.querySelector('.character.active');
        if (activeCharacter) {
            activeCharacter.className = activeCharacter.className.replace(' active', '');
        }
        this.className += ' active';
        console.log(this.nextSibling)
        this.nextSibling.checked = true;
    });
}

var character2 = document.querySelectorAll('.character2');
for (var i = 0; i < character2.length; i++) {
    character2[i].addEventListener('click', function (event) {
       $(".selected").removeClass("selected");
       this.className += ' selected';
       this.nextSibling.checked = true;
    });
}
var pal2 = document.querySelectorAll('.pal2');
for (var i = 0; i < pal2.length; i++) {
    pal2[i].addEventListener('click', function (event) {
       $(".selected2").removeClass("selected2");
       this.className += ' selected2';
       this.nextSibling.checked = true;
    });
}
var pal3 = document.querySelectorAll('.pal3');
for (var i = 0; i < pal3.length; i++) {
    pal3[i].addEventListener('click', function (event) {
       $(".selected3").removeClass("selected3");
       this.className += ' selected3';
       this.nextSibling.checked = true;
    });
}
var pal4 = document.querySelectorAll('.pal4');
for (var i = 0; i < pal4.length; i++) {
    pal4[i].addEventListener('click', function (event) {
       $(".selected4").removeClass("selected4");
       this.className += ' selected4';
       this.nextSibling.checked = true;
    });
}


var palLink = document.querySelectorAll('.pal1');
for (var i = 0; i < palLink.length; i++) {
    palLink[i].addEventListener('click', function (event) {
        event.preventDefault();
        if (this.className.indexOf(' active') >= 0) {
            this.className = this.className.replace(' active', '');
            this.nextSibling.checked = false;
        } else {
            var activePal = document.querySelectorAll('.pal1.active');
            if (activePal.length == <?php echo $eventnum; ?>) {
                swal({title: '输入错误', text: '您已选择了<?php echo $eventnum; ?>个冒险小伙伴', type: 'warning'});
            } else {
                this.className += ' active';
                
                this.nextSibling.checked = true;
            }
        }
    });
}

function getByteLen(val) { 
var len = 0; 
for (var i = 0; i < val.length; i++) { 
if (val[i].match(/[^\x00-\xff]/ig) != null) //全角 
len += 2; 
else 
len += 1; 
} 
return len; 
}
<?php }else{?>
</script><script>
<?php } ?>
function getByteLen(val) {
	var len = 0;
	for (var i = 0; i < val.length; i++) {
		if (val[i].match(/[^\x00-\xff]/ig) != null) //全角
			len += 2;
		else
			len += 1;
	}
	return len;
}
function createCand(){
	 var namelen = getByteLen($("#name").val());

	  if (namelen > 12) {
        swal({title: '输入错误', text: '名字最多不可超过12个字符(6个汉字)', type:'warning'});
        return false;
    }
    if (namelen < 1) {
        swal({title: '输入错误', text: '请输入名字', type:'warning'});
        return false;
    }
    var name = $("#name").val();
    if (name.indexOf(" ") != -1) {
        swal({title: '输入错误', text: '名字不可以带空格', type:'warning'});
        return false;
    }
}
function createBook() {

    var nameVerified = false;
    var name = $("#name").val();
    var namelen = getByteLen($("#name").val());
   
   var name2 = $("#name2").val();
   var englishname = $("#englishname").val();
    <?php if ($bookid == 59) {?>
   		if (namelen > 11) {
        swal({title: '输入错误', text: '名字最多不可超过11个字符', type:'warning'});
        return false;
    }
   	<?php }else{?>

    if (namelen > 8) {
        swal({title: '输入错误', text: '名字最多不可超过8个字符(4个汉字)', type:'warning'});
        return false;
    }
    <?php }?>

    if (namelen < 1) {
        swal({title: '输入错误', text: '请输入名字', type:'warning'});
        return false;
    }
    if (name.indexOf(" ") != -1 || (name2 && name2.indexOf(" ") != -1) || (englishname && englishname.indexOf(" ") != -1)) {
    	swal({title: '输入错误', text: '名字不可以带空格', type:'warning'});
        return false;
    }
    <?php if($bookid == 61 || $bookid == 62 || $bookid == 64){ ?>
    	if(getByteLen(englishname)<1){
    		swal({title: '系统提示', text: '请输入英文名', type:'warning'});
        	return false;
    	}if(getByteLen(englishname)> 11){
    		swal({title: '系统提示', text: '英文名最多不可超过11个字符', type:'warning'});
        	return false;
    	}
    <?php } ?>
    <?php
    if($rolenum == 2){ ?>
    	  var name2len = getByteLen($("#name2").val());
		 if (name2len > 8) {
        swal({title: '输入错误', text: '名字最多不可超过8个字符(4个汉字)', type:'warning'});
        return false;
    }
    if (name2len < 1) {
        swal({title: '输入错误', text: '请输入另一个名字', type:'warning'});
        return false;
    }
		
   <?php }  ?>
    if (document.querySelectorAll('.pal1.active').length != <?php echo $eventnum; ?>) {
        swal({title: '输入错误', text:  '您要选择<?php echo $eventnum; ?>个冒险小伙伴', type:'warning'});
        return false;
    }
}

			</script>
</body>
</html>
