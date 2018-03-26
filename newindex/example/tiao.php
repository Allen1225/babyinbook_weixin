<?php 
　 $url = "https://sms.yunpian.com/v1/sms/send.json";
　　$post_data = array ("apikey" => "6dd5ded357d3800bc23b043733cf293d","mobile" => "15801924096","text" => "123321123");

　　$ch = curl_init();

　　curl_setopt($ch, CURLOPT_URL, $url);
　　curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
　　// post数据
　　curl_setopt($ch, CURLOPT_POST, 1);
　　// post的变量
　　curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

　　$output = curl_exec($ch);
　　curl_close($ch);

　　//打印获得的数据
　　print_r($output);


?>