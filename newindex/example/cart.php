<?php 
header("Content-Type:text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
$tools = new JsApiPay();
session_start();
include "mysql.php";
if(!empty($_SESSION['openId'])){
	$openId = $_SESSION['openId'];
}else{
	$openId = $tools->GetOpenid();
	$_SESSION['openId'] = $openId;
}
	$link = mysql_connect("localhost","bib","BibMysql2015");
	$db = mysql_select_db("bibtest");
	$charset = mysql_query("set names utf8");
	
if(!empty($_POST['id']) && !empty($_POST['type'])){

	if($_POST['type'] == 'plus'){
		$f = '+';
		$sql = "update bib_v1_cart set num = num $f 1 where id = {$_POST['id']}";
	}else if($_POST['type'] == 'minus'){
		$f = '-';
		$sql = "update bib_v1_cart set num = num $f 1 where id = {$_POST['id']}";
	}else if($_POST['type'] == 'delete'){
		$f = '-';
		$sql = "delete from bib_v1_cart  where id = {$_POST['id']} and openid = '$openId'";
	}
	
	
	mysql_query($sql);
	header('Location: http://weixin.babyinbook.com/newindex/example/cart.php');
	
}
	$sql = "SELECT
	t2.rolenum,
	t2.name,
	t2.pic,
	t2.price,
	t1.*,
	t3.index_page,
	t2.kind,
	t3.bookid
FROM
	bib_v1_cart t1
LEFT JOIN bib_v1_bookinfo t2 ON t1.productid = t2.id
LEFT JOIN bib_v1_fpage t3 on t1.fpage = t3.id
WHERE
	t1.openid =  '{$openId}' order by t1.id desc";

	$res = mysql_query($sql);
	while($a = mysql_fetch_assoc($res)){
		$cartinfo[] = $a;
	}
	
	$allprice = 0;
	foreach($cartinfo as $key=>$value){
		$allprice = $allprice + ($value['price']*$value['num']);
		$str = $value['index_page'];
        if(strpos($str,"/Public/preview/") !== false){
            $tmp_arr = explode('/',$str);
            $a = explode('_',$tmp_arr[6]);

            foreach ($a as $k=>&$v){
                if($k == 2){
		    if(!is_base64($v)){
                        $name = base64_encode($a[2]);
                        $name = str_replace("+",'-',$name);
                        $name = str_replace("/",'-',$name);
                        $name = str_replace(".",'-',$name);
                        $name = str_replace("=",'-',$name);
                        $v = $name;
		    } 
                }
            }
            $new = implode('_',$a);
            foreach ($tmp_arr as $c=>&$d){
                if($c == 6){
                    $d = $new;
                }
            }
            $new_str = implode('/',$tmp_arr);
            $value['index_page'] = $new_str;
        }
	}
	
?>
<html>
	<head>
		<meta charset="utf-8"><title>宝贝在书里 · 购物车</title>
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
		<link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet">
		<!-- Include the compiled Ratchet JS-->
		<script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script>
		<link href="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.css" rel="stylesheet">
		<link href="http://www.babyinbook.com/babyinbook/js/sweetalert/theme.css" rel="stylesheet">
		<script src="http://www.babyinbook.com/babyinbook/js/sweetalert/sweetalert.min.js"></script>
		<script src="http://www.babyinbook.com/babyinbook/js/turn/jquery.min.1.7.js"></script>
		<script type="text/javascript">
function qtyMinus(itemId) {
	if(itemId){
		
	
     var cartForm = document.getElementById('cartForm');
  
    var id = document.getElementById('id');
    id.value = itemId;
     var type = document.getElementById('type');
    type.value = 'minus';
    cartForm.submit();
   }
}

function qtyPlus(itemId) {
    var cartForm = document.getElementById('cartForm');
  
    var id = document.getElementById('id');
    id.value = itemId;
     var type = document.getElementById('type');
    type.value = 'plus';
    cartForm.submit();
}

function deleteItem(itemId) {
    swal({
        title:'请确认',
        text: '您确定要删除这本书么？',
        type: 'warning',
        showCancelButton: true
    }, function () {
        var cartForm = document.getElementById('cartForm');
        id.value = itemId;
      var type = document.getElementById('type');
    type.value = 'delete';
        cartForm.submit();
    });
}

function settleCart() {
    if (document.getElementById('checklist').value == '') {
        swal({title: '输入错误', text: '请至少选择一件物品进行结算', type: 'warning'});
    } else {
        var cartForm = document.getElementById('settle');
        cartForm.submit();
    }
}

	function changeChecked(cartItem) {
    var checkedItems = document.querySelectorAll('.checked-item:checked');
    var items = '';
    for (var i = 0; i < checkedItems.length; i++) {
        var checkedItem = checkedItems[i];
        if (items == '') {
            items = checkedItem.value;
        } else {
            items += (',' + checkedItem.value);
        }
    }
    document.getElementById('checklist').value = items;

    var total = document.querySelector('strong.price').textContent.replace('¥', '');
    var item = document.querySelector('#cartItem' + cartItem.value + ' span.price').textContent.replace('¥', '');
    var qty = document.querySelector('#cartItem' + cartItem.value + ' span.number').textContent.replace('本', '');
    if (cartItem.checked) {
        document.querySelector('strong.price').textContent = '¥' + (parseInt(total) + parseInt(item) * parseInt(qty));
    } else {
        document.querySelector('strong.price').textContent = '¥' + (parseInt(total) - parseInt(item) * parseInt(qty));
    }
}

</script></head>
<body><!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls)-->
	<div class="content">
		<form id="cartForm" action="" method="POST" class="hide">
			<input id="id" type="hidden" name="id" value="">
			<input id="type" type="hidden" name="type" value="">
		</form>
		<form id="settle" action="settle.php" method="POST" class="hide">
			<input type="hidden" name="checklist" id="checklist" />
			<input type="hidden" name="openid" id="openid" value= "<?php echo $openId; ?>" />
		</form>
		<ul class="table-view table-card-view">
			<?php foreach($cartinfo as $key=> $value){ ?>
			<li id="cartItem<?php echo $value['id']; ?>" style="padding-right:15px;" class="table-view-cell">
				<div class="upper-part">
					<div class="pull-left">
						<input <?php if(!empty($_GET['id']) && $_GET['id']==$value['id']){echo 'checked="checked"';}?> id="box<?php echo $value['id']; ?>" type="checkbox" name="money"  value="<?php echo $value['id']; ?>" onchange="changeChecked(this)"  class="checked-item filled-in">
						<label for="box<?php echo $value['id']; ?>"></label>
					</div>
					<a href="javascript:;" class="thumbnail-list-item"><img style="margin-left:20px;height:50px;"  src="<?php echo str_replace("/show/show", "",$value['index_page']); ?>">
					
					</a><div>
					<strong>
						<?php
							$value['name1'] = str_replace(" ", "+", $value['name1']);
							$value['name1'] = str_replace(".", "/", $value['name1']);
							$value['name2'] = str_replace(" ", "+", $value['name2']);
							$value['name2'] = str_replace(".", "/", $value['name2']);

							if($value['rolenum'] > 0){
								$value['name1']=base64_decode($value['name1']);
							if($value['rolenum'] == 2){
								$value['name1'].= "与".base64_decode($value['name2']);
							}
							}
							// var_dump($value['name']);die;
							$value['name']=str_replace("宝贝",$value['name1'],$value['name']);
							$value['name']=str_replace("不怕打针",$value['name1']."不怕打针",$value['name']);
							$value['name']=str_replace("不怕看病",$value['name1']."不怕看病",$value['name']);
							// var_dump($value['name1']);die;
							echo $value['name'];
						?>
					</strong>
					<p><span class="price text-sm">¥<?php echo $value['price']; ?></span></p>
					</div>
					</div><div class="number-adjuster pull-left">
						<a href="javascript:;" onclick="qtyMinus(<?php if($value['num']> 1) {echo $value['id'];} ?>);" class="btn">−</a><span class="number"><?php echo $value['num']; ?>本</span><a href="javascript:;" onclick="qtyPlus(<?php echo $value['id']; ?>);" class="btn">+</a></div>
							<div class="pull-right" style="width:180px;">
								<?php if($value['kind'] == 1){ ?>
								<form action="repreview.php" method="post">
								<?php }else{ ?>
								<form action="repreviewcand.php" method="post">
								<?php } ?>
								<input type="hidden" name="bookid" value="<?php echo $value['bookid']; ?>" />
									<?php $url = trim($value['url'],'/');?>
									<input type="hidden" name="url" value="<?php echo $url.'/repreview/'.$value['fpage']; ?>" />
									<input type="button" onclick="deleteItem(<?php echo $value['id']; ?>);" style="width:60px;margin-right:10px;border:none;background: white;float:right" class="btn-delete" value="删除" >
						
									<input type="submit"  class="btn-delete" style="width:60px;margin-right:10px;border:none;background: white;float:right" value="预览" />
							
								</form>
								</div>
							</li>
						<?php } ?>
						</ul>
						
						</div>
				<div class="bar bar-standard bar-footer">
					<div class="pure-g">
						<div style="line-height:48px;" class="pure-u-19-24">
							<span class="price-label">合计：</span><strong class="price">
							</strong>
						</div>
						<div class="pure-u-5-24">
							
							<a href="javascript:;" onclick="settleCart();" class="btn btn-primary btn-block btn-round-sm orange-linear">结算</a>
						</div></div></div>
						
						<nav class="bar bar-tab"><a href="/newindex/index.php" class="tab-item"><span class="icon icon-home"></span><span class="tab-label">首页</span></a><a href="/newindex/example/user.php" class="tab-item"><span class="icon icon-person"></span><span class="tab-label">我的</span></a><a href="/newindex/example/cart.php" class="tab-item active"><span class="icon fa fa-shopping-cart"></span><span class="tab-label">购物车</span></a></nav></body>
	
</html>
<script>
function index()
{
	var max = document.querySelectorAll('.checked-item:checked').length;
	var price = 0;
	<?php $res = ''; ?>
	if(max > 0){
		document.getElementById('checklist').value ="<?php echo $cartinfo[0]['id'];?>";
		price = <?php echo $cartinfo[0]['price'];?>;
		document.querySelector('strong.price').textContent = '¥' + price;
	}else{
		document.querySelector('strong.price').textContent = '¥' + 0;
	}
}
index();

</script>
