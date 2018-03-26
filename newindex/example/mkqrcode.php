<?php
include 'phpqrcode.php'; 
$couponid = $_GET['cid'];
$orderid = $_GET['oid'];
QRcode::png('http://weixin.babyinbook.com/newindex/example/getcoupon.php?oid=$oid&cid=$cid');
