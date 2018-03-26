<?php 
header("Content-type: text/html; charset=utf-8");
mysql_connect("localhost","bib","BibMysql2015");
mysql_select_db("babyinbook");
mysql_query("set names utf8");
$sql = "select * from qm_total_info t1 join qm_customer_info t2 on t1.attach = t2.orderid";
$res = mysql_query($sql);

while($a = mysql_fetch_assoc($res)){
	$aa[] = $a;
}
?>
<html>
<head>
<title></title>
<style type="text/css">
table.gridtable {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

</head>
<body>
<table class="gridtable"> 
<tr>
<td>商户单号</td>

<td>交易单号</td>


<td>交易时间</td>


<td>数量</td>
<td>总金额</td>

<td>客户姓名</td>

<td>客户电话</td>
<td>是否填写收货地址</td>
<td>收货人姓名</td>
<td>收货地址</td>
<td>收货电话</td>
<td>省</td>
<td>市</td>
<td>区</td>
<td>pvid</td>
 </tr>
<?php foreach($aa as $key=>$value){  ?>
<tr>
<td><?php echo $value['out_trade_no']; ?></td>
<td><?php echo $value['transaction_id']; ?></td>
<td><?php echo $value['time_end']; ?></td>
<td><?php echo $value['nums']; ?></td>
<td><?php $fee = $value['total_fee']/100;echo $fee."元"; ?></td>
<td><?php echo $value['name']; ?></td>
<td><?php echo $value['phone']; ?></td>
<td><?php if($value['otheraddress'] == 'otheraddress'){echo "是"; }else{ echo "否";} ?></td>
<td><?php echo $value['oname']; ?></td>

<td><?php echo $value['oaddress']; ?></td>
<td><?php echo $value['ophone']; ?></td>
<td><?php echo $value['shen']; ?></td>
<td><?php echo $value['shi']; ?></td>
<td><?php echo $value['qu']; ?></td>
<td><?php echo $value['pvid']; ?></td>
 </tr>
<?php } ?>
</table>
</body>

</html>
