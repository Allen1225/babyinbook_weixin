<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/12/4
 * Time: 22:32
 */
//namespace weixinpayApp;
include 'wechatH5Pay.php';

//$data 金额和订单号
function wxh5Request($data)
{
    $appid = 'wx6a77790bf7451603';
    $mch_id = '1287105701';//商户号
    $key = 'QJo8HBUBca98kpKW4Ga6NKJZFoaPZFe2';//商户key
    $notify_url = "http://weixin.babyinbook.com/wxzf/example/orderreturn.php";//回调地址
    $wechatAppPay = new wechatAppPay($appid, $mch_id, $notify_url, $key);
    $params['body'] = '宝贝在书里绘本定制';                       //商品描述
    $params['out_trade_no'] = $data['oid'];    //自定义的订单号
    $params['total_fee'] = '1';                       //订单金额 只能为整数 单位为分
    $params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP
    $params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "https://www.babyinbook.com","wap_name": "宝贝在书里绘本定制"}}';
	var_dump($params);die;
    $result = $wechatAppPay->unifiedOrder( $params );
	var_dump($result);die;
    $url = $result['mweb_url'].'&redirect_url=http://weixin.babyinbook.com/wxzf/example/wapcreateorder.php';//redirect_url 是支付完成后返回的页面
    return $url;
}
