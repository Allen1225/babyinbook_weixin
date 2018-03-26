<?php

/**
 * 本页仅供测试
 */

class WebAction extends Action {

	protected function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
	}
	public function pheader(){
		$login = 0;
		if(!empty($_SESSION['user'])){
			$login = 1;
			
		}
		
		$this->assign("login",$login);
		$this->display();
	}
	public function loginout(){
		session_start();
		 unset($_SESSION['user']);
		  unset($_SESSION['unionid']);
		   unset($_SESSION['openid']);
		header('Location: /babyinbook/index.php/Web/Index');
	}
	public function MyCard(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$Model = D("Web"); 
		$coupon = $Model->getcoupon($_SESSION['user']['m_id']);
	
		foreach($coupon as $key=>$value){
			if(!empty($value['date_used'])){
				$coupon[$key]['status'] = 'used';
				$coupon[$key]['col'] = 'grey';
			}else if($value['valid_to'] < date("Y-m-d")){
				$coupon[$key]['status'] = 'outime';
				$coupon[$key]['col'] = 'grey';
			}else{
				$coupon[$key]['status'] = 'can';
				$coupon[$key]['col'] = 'red';
			}
		}
		
		$this->assign("coupon",$coupon);
		$this->display();
	}
	public function Dopreview(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$bookid = $_POST['bookid'];
		$name1 = base64_encode($_POST['name']);
		$name1 = str_replace("/", ".", $name1);
		$name2 = !empty($_POST['name2'])?base64_encode($_POST['name2']):'null';
		$name2 = str_replace("/", ".", $name2);
		$role1 = $_POST['character'];
		$role2 = !empty($_POST['character2'])?$_POST['character2']:'null';
		$top = !empty($_POST['top'])?$_POST['top']:'null';
		$mid = !empty($_POST['mid'])?$_POST['mid']:'null';
		$bottom = !empty($_POST['bottom'])?$_POST['bottom']:'null';
		$event = implode(",",$_POST['event']);
		$role = $_POST['role'];
		$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/makePreview/id/$bookid/role/$role/role1/$role1/role2/$role2/name1/$name1/name2/$name2/top/$top/mid/$mid/bottom/$bottom/event/$event";
		
		$json = file_get_contents($url);
		$res = json_decode($json,true);
		$this->assign("bookid",$bookid);
		$this->assign("url",$url);
		$this->assign("res",$res);
		$this->display();
	}
	
	
	
	public function Cart(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		if(empty($_SESSION['user']['m_wechat_openid'])){
			$_SESSION['user']['m_wechat_openid'] = 0;
		}
		$Model = D("Web"); 
		if(!empty($_POST['id']) && !empty($_POST['type'])){

		if($_POST['type'] == 'plus'){
		$f = '+';
		$sql = "update bib_v1_cart set num = num $f 1 where id = {$_POST['id']}";
		}else if($_POST['type'] == 'minus'){
		$f = '-';
		$sql = "update bib_v1_cart set num = num $f 1 where id = {$_POST['id']} and num > 1";
		}else if($_POST['type'] == 'delete'){
		$f = '-';
		$sql = "delete from bib_v1_cart  where id = {$_POST['id']} and openid in ('{$_SESSION['user']['m_wechat_openid']}','{$_SESSION['user']['m_id']}')";
		}
	
	
		$res = $Model->doquery($sql);
		header('Location: http://www.babyinbook.com/babyinbook/index.php/Web/Cart');
	
		}
		
		
		
		
		
		$where = "t1.openid in ('{$_SESSION['user']['m_wechat_openid']}','{$_SESSION['user']['m_id']}')";
		$res = $Model->getcartinfo($where);
		
		$this->assign("roleinfo",$res);
		$this->display();
	}
	
	public function Settle(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$openid = $_POST['openid'];
		$checklist = $_POST['checklist'];
		$Model = D("Web"); 
		$address = $Model->getUserAddress($_SESSION['user']['m_id']);
		$coupon = $Model->getUserCoupon($_SESSION['user']['m_id']);
		if(!empty($_SESSION['user']['m_wechat_openid'])){
			$openid = $_SESSION['user']['m_wechat_openid'];
		}else{
			$openid = 0;
		}
		$goods = $Model->getGoods($_SESSION['user']['m_id'],$openid,$checklist);
		$this->assign("address",$address);
		$this->assign("coupon",$coupon);
		$this->assign("checklist",$checklist);
		$this->assign("goods",$goods);
		$this->display();
		
	}
	public function f5Address(){
		$Model = D("Web"); 
		$address = $Model->getUserAddress($_SESSION['user']['m_id']);
	
		foreach($address as $key=>$value){
			$str .= '<div class="changeaddress hover" style="border-radius:10px;margin-top:10px;width:500px;height:40px;margin-left:50px;border:1px solid black;background-color:#ccc;">
		<input type="hidden" name="receiver" value="'.$value['receiver'].'" />
		<input type="hidden" name="phone" value="'.$value['phone'].'" />
		<input type="hidden" name="province_name" value="'.$value['province_name'].'" />
		<input type="hidden" name="city_name" value="'.$value['city_name'].'" />
		<input type="hidden" name="district_name" value="'.$value['district_name'].'" />
		<input type="hidden" name="address" value="'.$value['address'].'" />
		&nbsp;&nbsp;&nbsp;&nbsp;收件人：'.$value['receiver'].'
		&nbsp;&nbsp;&nbsp;&nbsp;联系电话'.$value['phone'].'<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;地址：'.$value['province_name']."&nbsp;".$value['city_name']."&nbsp;".$value['district_name']."&nbsp;".$value['address'].'
	</div>';

		}
			echo $str;
	}
	public function CheckPayStatus($orderid){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$Model = D("Web"); 
		$res = $Model->checkOrder($orderid);
		if(!empty($res)){
			$status = 1;
		}else{
			$status = 0;
		}
		
		$this->assign("status",$status);
		$this->display();
		
	}
	
	
	public function fpage(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$url = $_POST['url'];
		$this->assign("url",$url);
		
		$this->display();
	}
	
	public function BookShelves(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$Model = D("Web"); 
		if(empty($_SESSION['user']['m_wechat_openid'])){
			$_SESSION['user']['m_wechat_openid'] = 0;
		}
		$where = "t1.openid in ('{$_SESSION['user']['m_wechat_openid']}','{$_SESSION['user']['m_id']}')";
		
		$info = $Model->getbookshelves($where);
			foreach($info as $key=>$value){
$matches = "/name1\/([\s\S]*)\/name2\//";
preg_match_all($matches, $value['url'],$bookid);
$info[$key]['name1'] = base64_decode($bookid[1][0]);
$matches = "/name2\/([\s\S]*)\/top\//";
preg_match_all($matches, $value['url'],$bookid);
$info[$key]['name2'] = base64_decode($bookid[1][0]);
	}
		$this->assign("info",$info);
		$this->display();
	}
	public function preview(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$url = $_POST['url'];
$json = file_get_contents($url);

$res = json_decode($json,true);
$this->assign("res",$res);
		$this->display();
	}
	
	public function Myinfo(){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$Model = D("Web"); 
		if(!empty($_POST['receiver'])){
			$Model->changname($_POST['receiver'],$_SESSION['user']['m_id']);
			header('Location: /babyinbook/index.php/Web/Signin');
		}
		$name = $Model->getname($_SESSION['user']['m_id']);
		$this->assign("name",$name[0]);
		$this->display();
	}
	
	public function Signin(){
		$login = 0;
		if(!empty($_SESSION['user'])){
			$login = 1;
		}
		if(!empty($_REQUEST['sign'])){
			$sign = $_REQUEST['sign'];
		}else{
			$sign = 1;
		}	
		

		if($sign == 4){
			$where['userid'] = $_SESSION['user']['m_id'];
			$where['paystatus'] = 0;
		}else if($sign == 1){
			$where['userid'] = $_SESSION['user']['m_id'];
			
		}else if($sign == 2){
			$where['userid'] = $_SESSION['user']['m_id'];
			$where['paystatus'] = 1;
			$where['sendstatus'] = 0;
		}else if($sign == 3){
			$where['userid'] = $_SESSION['user']['m_id'];
			$where['paystatus'] = 1;
			$where['sendstatus'] = 1;
		}

		//sign 4 未付款
		//sign 1 全部
		//sign 2 已付款 未发货
		//sign 3 已付款 已发货
		$Model = D("Web"); 
		
		
		if(!empty($_POST['orderid'])){
			$wherea['id'] = $_POST['orderid'];
			$wherea['userid'] = $_SESSION['user']['m_id'];
			$Model->cancel($wherea);
		}
		$name = $Model->getname($_SESSION['user']['m_id']);
		$orders = $Model->getorders($where);
		foreach($orders as $key=>$value){
			$orders[$key]['detail'] = $Model->getorderdetail($value['orderid']);
		}

		$this->assign("orders",$orders);
		
		$this->assign("sign",$sign);
		$this->assign("name",$name[0]);
		$this->assign("login",$login);
		$this->display();
	}
	public function Showorders($orderid){
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		$Model = D("Web");
		$where['orderid'] = $orderid;
		$where['userid'] = $_SESSION['user']['m_id'];
		$res = $Model->getorders($where);
		$res2 = $Model->getorderdetail($orderid);
		$this->assign("orders",$res);
		$this->assign("orderdetail",$res2);
		$this->display();
	}
	public function changeaddress($id){
	if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
			$this->assign("login",$login);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
	$Model = D("Web");
	
	
	if(!empty($_POST['receiver'])){	
			$receiver = $_POST['receiver'];
			$phone = $_POST['phone'];
			$district = $_POST['district'];
			$address = $_POST['address'];
			$Model->dochangeadd($receiver,$phone,$district,$address,$id,$_SESSION['user']['m_id']);
			header('Location: /babyinbook/index.php/Web/Address');
		}
	$res = $Model->getDetial($id);

	$province = $Model->getprovince();
	$city = $Model->getcity($res[0]['proid']);
	$district = $Model->getdistrict($res[0]['cityid']);
	$this->assign("city",$city);
	$this->assign("district",$district);
	$this->assign("province",$province);
	$this->assign("detail",$res[0]);
	$this->display();		
	}
	public function Addaddress(){
				$Model = D("Web");
		
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		if(!empty($_POST['receiver'])){	
			$receiver = $_POST['receiver'];
			$phone = $_POST['phone'];
			$district = $_POST['district'];
			$address = $_POST['address'];
			$Model->doaddadd($receiver,$phone,$district,$address,$_SESSION['user']['m_id']);
			header('Location: /babyinbook/index.php/Web/Address');
		}
		$province = $Model->getprovince();

		$this->assign("province",$province);
		$this->assign("login",$login);
		$this->display();
	}
	public function getcity(){
		$id = $_REQUEST['id'];
		$Model = D("Web");
		$city = $Model->getcity($id);
		$str="<option>请选择</option>";
		foreach($city as $key=>$value){
			$str .= "<option value='{$value['id']}'>{$value['city_name']}</option>";
		}
		echo $str;
	}
	public function getdistrict(){
		$id = $_REQUEST['id'];
		$Model = D("Web");
		$city = $Model->getdistrict($id);
		$str="<option>请选择</option>";
		foreach($city as $key=>$value){
			$str .= "<option value='{$value['id']}'>{$value['district_name']}</option>";
		}
		echo $str;
	}
	public function Address(){
			$Model = D("Web");
		if(!empty($_POST['type'])){
			if($_POST['type'] == 'mkdefault'){
				if(!empty($_POST['user']) && !empty($_POST['addressid'])){
					$Model->mkdefault($_POST['user'],$_POST['addressid']);
				}
			}
			if($_POST['type'] == 'delete'){
				if(!empty($_POST['user']) && !empty($_POST['addressid'])){
					$Model->delete($_POST['user'],$_POST['addressid']);
				}
			}
		}
		$login = 0;
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("user",$_SESSION['user']);
		}else{
			header('Location: /babyinbook/index.php/Web/Login');
		}
		
	
		$res = $Model->getAddress($_SESSION['user']['m_id']);
		foreach($res as $key=>$value){
			if($value['is_default'] == 1){
				$this->assign("default",$value);
				unset($res[$key]);
			}
		}
		
		$this->assign("res",$res);
		$this->assign("login",$login);
		$this->display();
	}
	public function ConnectLogin(){
		if(!empty($_POST)){
		$openid = $_POST['wopenid'];
		$unionid = $_POST['wunionid'];
		$username = $_POST['waccount'];
		$password = md5($_POST['wpassword']);
		$Model = D("Web");
		$res = $Model->checklogin($username,$password);
		if(!empty($res[0])){
			$check = $Model->connectlogin($res[0]['m_id'],$openid,$unionid);
			
			if($check == 'error'){
				header('Location: /callback.php?error=1');
				die;
			}
		
			session_start();
			$_SESSION['user'] = $res[0];
			header('Location: /babyinbook/index.php/Web/Index');
			}else{
			header('Location: /babyinbook/index.php/Web/Login');	
			}
		}
	}

public function CartNum($id,$openid){
	$Model = D("Web");
	$res = $Model->getCartNum($id,$openid);
	echo $res;
}
public function RLogin(){
	
	
		$Model = D("Web");
		if(!empty($_POST['rpassword'])){
		$username = $_POST['raccount'];
		$password = md5($_POST['rpassword']);
		$res = $Model->checklogin($username,$password);
		if(!empty($res[0])){
			session_start();
			$_SESSION['user'] = $res[0];
			header('Location: /babyinbook/index.php/Web/Index');
			}
		}
		header('Location: /babyinbook/index.php/Web/Login');
	}
	public function Login(){
		$Model = D("Web");
		if(!empty($_POST['password'])){
		$username = $_POST['account'];
		$password = md5($_POST['password']);
		$res = $Model->checklogin($username,$password);
		if(!empty($res[0])){
			session_start();
			$_SESSION['user'] = $res[0];
			header('Location: /babyinbook/index.php/Web/Index');
			}
		}
		$this->display();
	}
	public function Register(){
		session_start();
	
		$this->display();
	}
	public function Index() {
		$login = 0;
		if(!empty($_SESSION['user'])){
			$login = 1;
		}
		$json = file_get_contents("http://www.babyinbook.com/babyinbook/interface.php/Index/getBook");
		$book = json_decode($json,true);
		$this->assign("book",$book);
		
		$this->assign("login",$login);
		$this -> display();
	}

	public function Make() {
		$login = 0;
		if(!empty($_SESSION['user'])){
			$login = 1;
			$this->assign("login",$login);
		}
		$bookid = $_GET['id'];
		$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/Preview/id/{$bookid}";
		$json = file_get_contents($url);
		$res = json_decode($json, true);
		$icon = 1;
		$eventnum = $res['bookinfo']['eventnum1'] + $res['bookinfo']['eventnum2'];
		$Model = D("Web");
		$item = $Model->getItem($bookid);
		
		$this->assign("res",$res);
		$this->assign("item",$item);
		$this->assign("icon",$icon);
		$this->assign("eventnum",$eventnum);
		$this -> display();
	}

}
?>