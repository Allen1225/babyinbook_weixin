<?php
header("Content-type: text/html; charset=utf-8");
$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
//$xml = json_encode($xml);

mysql_connect("localhost","bib","BibMysql2015");
mysql_select_db("bibtest");
mysql_query("set names utf8");
//mysql_query("INSERT qm_total_info(attach) VALUES('$xml')");die;
//mysql_select_db("bibtest");
//mysql_query("set_names_utf8");
//$sql = "select * from qm_test";
//$res = mysql_query($sql);

//while($a = mysql_fetch_assoc($res)){
//	$aa[] = $a;
//}

//$xml = $aa[0]['info'];

//$xml = str_replace("\"", "'", $xml);
//mysql_query("INSERT qm_total_info(attach) VALUES('$xml')");die;
$xml = str_replace("<![CDATA[", "", $xml);
$xml = str_replace("]]>", "", $xml);
//mysql_query("INSERT qm_total_info(attach) VALUES('$xml')");die;
$matches = "/<attach>([\s\S]*)<\/attach>/";
preg_match_all($matches, $xml,$attach);
$attach = $attach[1][0];

$matches = "/<bank_type>([\s\S]*)<\/bank_type>/";
preg_match_all($matches, $xml,$bank_type);
$bank_type = $bank_type[1][0];

$matches = "/<cash_fee>([\s\S]*)<\/cash_fee>/";
preg_match_all($matches, $xml,$cash_fee);
$cash_fee = $cash_fee[1][0];

$matches = "/<fee_type>([\s\S]*)<\/fee_type>/";
preg_match_all($matches, $xml,$fee_type);
$fee_type = $fee_type[1][0];

$matches = "/<is_subscribe>([\s\S]*)<\/is_subscribe>/";
preg_match_all($matches, $xml,$is_subscribe);
$is_subscribe = $is_subscribe[1][0];

$matches = "/<mch_id>([\s\S]*)<\/mch_id>/";
preg_match_all($matches, $xml,$mch_id);
$mch_id = $mch_id[1][0];

$matches = "/<nonce_str>([\s\S]*)<\/nonce_str>/";
preg_match_all($matches, $xml,$nonce_str);
$nonce_str = $nonce_str[1][0];

$matches = "/<openid>([\s\S]*)<\/openid>/";
preg_match_all($matches, $xml,$openid);
$openid = $openid[1][0];

$matches = "/<out_trade_no>([\s\S]*)<\/out_trade_no>/";
preg_match_all($matches, $xml,$out_trade_no);
$out_trade_no = $out_trade_no[1][0];

$matches = "/<result_code>([\s\S]*)<\/result_code>/";
preg_match_all($matches, $xml,$result_code);
$result_code = $result_code[1][0];

$matches = "/<sign>([\s\S]*)<\/sign>/";
preg_match_all($matches, $xml,$sign);
$sign = $sign[1][0];

$matches = "/<time_end>([\s\S]*)<\/time_end>/";
preg_match_all($matches, $xml,$time_end);
$time_end = $time_end[1][0];

$matches = "/<total_fee>([\s\S]*)<\/total_fee>/";
preg_match_all($matches, $xml,$total_fee);
$total_fee = $total_fee[1][0];

$matches = "/<return_code>([\s\S]*)<\/return_code>/";
preg_match_all($matches, $xml,$return_code);
$return_code = $return_code[1][0];

$matches = "/<trade_type>([\s\S]*)<\/trade_type>/";
preg_match_all($matches, $xml,$trade_type);
$trade_type = $trade_type[1][0];

$matches = "/<transaction_id>([\s\S]*)<\/transaction_id>/";
preg_match_all($matches, $xml,$transaction_id);
$transaction_id = $transaction_id[1][0];
$sqlcheck = "SELECT * from qm_total_info where out_trade_no = '{$out_trade_no}' and sign = '{$sign}' and transaction_id = '{$transaction_id}'";
$res = mysql_query($sqlcheck);
while($a = mysql_fetch_assoc($res)){
      $aa[] = $a;
}
if(empty($aa) && $result_code == 'SUCCESS'){
$sql = "INSERT qm_total_info(attach,bank_type,cash_fee,fee_type,is_subscribe,mch_id,nonce_str,openid,out_trade_no,result_code,return_code,sign,time_end,total_fee,trade_type,transaction_id)
VALUES('{$attach}','{$bank_type}','{$cash_fee}','{$fee_type}','{$is_subscribe}','{$mch_id}','{$nonce_str}','{$openid}','{$out_trade_no}','{$result_code}','{$return_code}','{$sign}','{$time_end}','{$total_fee}','{$trade_type}','{$transaction_id}')";
mysql_query($sql);
$sql = "update bib_v1_orders set paystatus = 1 where orderid = '{$attach}'";
mysql_query($sql);
$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/commission/orderid/{$attach}";
file_get_contents($url);
}
?>
