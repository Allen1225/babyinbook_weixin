<?php

header("Content-type: text/html; charset=utf-8");
session_start();
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
$bookid == 66 && $event=344;
$bookid == 65 && $event=329;
$role = $_POST['role'];
$englishname = !empty($_POST['englishname'])?$_POST['englishname']:'0';
if($bookid == 11){
	if($role1 == 59 || $role1 == 60 || $role1 == 61 ){
		$mid = "88,6";
	}else{
		$mid = "89,6";
	}
}
 $openid = !empty($_REQUEST['openid'])?$_REQUEST['openid']:$_SESSION['openid'];

//$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/makePreview/id/$bookid/role/$role/role1/$role1/role2/$role2/name1/$name1/name2/$name2/top/$top/mid/$mid/bottom/$bottom/event/$event/englishname/$englishname";
$url = "http://www.babyinbook.com/babyinbook/interface.php/Index/MymakePreview/openid/$openid/id/$bookid/role/$role/role1/$role1/role2/$role2/name1/$name1/name2/$name2/top/$top/mid/$mid/bottom/$bottom/event/$event/englishname/$englishname/";
$sql = "select size from bib_v1_bookinfo where  id = $bookid";
include "mysql.php";
$arr1 = query($sql);
$size = explode("*", $arr1[0]['size']);
$json = file_get_contents($url);
$res = json_decode($json,true);

$max = count($res);
if($bookid == 61){
    $res[1]     = "http://www.babyinbook.com/babyinbook/img/sg_top_1.jpg";
    $res[2]     = "http://www.babyinbook.com/babyinbook/img/sg_top_2.jpg";
    $res[3]     = "http://www.babyinbook.com/babyinbook/img/sg_top_3.jpg";
    $res[$max-3] = "http://www.babyinbook.com/babyinbook/img/sg_top_4.jpg";
    $res[$max-2] = "http://www.babyinbook.com/babyinbook/img/sg_top_5.jpg";
    $res[$max-1]  = "http://www.babyinbook.com/babyinbook/img/sg_top_6.jpg";
    $json = json_encode($res);
}
if($bookid==11){
    switch($role1){
        case 58;
            $res[2]="http://www.babyinbook.com/babyinbook/img/green_girl.jpg";
            break;
        case 59:
            $res[2]="http://www.babyinbook.com/babyinbook/img/blue_boy.jpg";
            break;
        case 60:
            $res[2]="http://www.babyinbook.com/babyinbook/img/green_boy.jpg";
            break;
        case 61:
            $res[2]="http://www.babyinbook.com/babyinbook/img/purple_boy.jpg";
            break;
        case 62:
            $res[2]="http://www.babyinbook.com/babyinbook/img/red_girl.jpg";
            break;
        case 63:
            $res[2]="http://www.babyinbook.com/babyinbook/img/orange_girl.jpg";
            break;
    }
    $json=json_encode($res);
}
if($bookid==59){
    switch($role1){
        case  149:
            $res[2]="http://www.babyinbook.com/babyinbook/img/blue_boy_en.jpg";
            break;
        case 150:
            $res[2]="http://www.babyinbook.com/babyinbook/img/green_boy_en.jpg";
            break;
        case 151:
            $res[2]="http://www.babyinbook.com/babyinbook/img/purple_boy_en.jpg";
            break;
        case 152:
            $res[2]="http://www.babyinbook.com/babyinbook/img/green_girl_en.jpg";
            break;
        case 153:
            $res[2]="http://www.babyinbook.com/babyinbook/img/yellow_girl_en.jpg";
            break;
        case 154:
            $res[2]="http://www.babyinbook.com/babyinbook/img/red_girl_en.jpg";
            break;
    }
    $json=json_encode($res);
}

if($bookid==18){
    switch($role1){
        case 91;
            $res[4]="http://www.babyinbook.com/babyinbook/img/blue_boy_sweet.jpg";
            break;
        case 92:
            $res[4]="http://www.babyinbook.com/babyinbook/img/green_boy_sweet.jpg";
            break;
        case 93:
            $res[4]="http://www.babyinbook.com/babyinbook/img/purple_boy_sweet.jpg";
            break;
        case 94:
            $res[4]="http://www.babyinbook.com/babyinbook/img/red_boy_sweet.jpg";
            break;
        case 95:
            $res[4]="http://www.babyinbook.com/babyinbook/img/orange_boy_sweet.jpg";
            break;
        case 96:
            $res[4]="http://www.babyinbook.com/babyinbook/img/brown_girl_sweet.jpg";
            break;
        case 97:
            $res[4]="http://www.babyinbook.com/babyinbook/img/green_girl_sweet.jpg";
            break;
        case 98:
            $res[4]="http://www.babyinbook.com/babyinbook/img/orange_girl_sweet.jpg";
            break;
        case 99:
            $res[4]="http://www.babyinbook.com/babyinbook/img/red_girl_sweet.jpg";
            break;
        case 100:
            $res[4]="http://www.babyinbook.com/babyinbook/img/yellow_girl_sweet.jpg";
            break;
    }
    $json=json_encode($res);
}

//将上一步的数据存入表中
$_SESSION['url']=$url;
$_SESSION['name']=$_POST['name'];
$_SESSION['bookid']=$_POST['bookid'];
/*include 'html2img.php';
require __DIR__ . '../../snap/vendor/autoload.php';
use Knp\Snappy\Image;
$snappy = new Image('../../snap/wkhtmltox/bin/wkhtmltoimage');
foreach ($res as $k=>$v){
    html2img($v,$snappy);
}*/

?>
<html>
	<head><meta charset="utf-8"><title>宝贝在书里 · 定制</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/app.css" rel="stylesheet"><link href="http://www.babyinbook.com/babyinbook/css/magazine.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="http://www.babyinbook.com/babyinbook/js/ratchet.min.js"></script><script src="http://www.babyinbook.com/babyinbook/js/turn/jquery.min.1.7.js"></script><script src="http://www.babyinbook.com/babyinbook/js/turn/turn.min.js"></script><script src="http://www.babyinbook.com/babyinbook/js/turn/zoom.min.js"></script><script src="http://www.babyinbook.com/babyinbook/js/newmagazine.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {


    var flipbook = $('.magazine');
    bookPath = '/data/fd9c24c867b412f9/preview/';
                var x = '<?php echo $json; ?>';
                x = JSON.parse( x );
    // Create the flipbook

    flipbook.turn({

        // Magazine width

        width: <?php echo 2*$size[0]; ?>,

        // Magazine height

        height: <?php echo $size[1]; ?>,

        // Duration in millisecond

        duration: 500,

        // Hardware acceleration

        acceleration: !isChrome(),

        // Enables gradients

        gradients: true,

        // Auto center this flipbook

        autoCenter: true,

        // Elevation from the edge of the flipbook when turning a page

        elevation: 50,

        // The number of pages

        pages: <?php echo count($res); ?>,
		
        // Events

        when: {
            turning: function (event, page, view) {

                var book = $(this),
                        currentPage = book.turn('page'),
                        pages = book.turn('pages');

            },

            turned: function (event, page, view) {

                $(this).turn('center');

                if (page == 1) {
                    $(this).turn('peel', 'br');
                }

            },

            missing: function (event, pages) {

                // Add pages that aren't in the magazine
var a = pages[0] - 1;

                for (var i = 0; i < pages.length; i++){
        
                  var cp = a + i
               
                    addPage(pages[i], $(this), pages ,x[cp]);
					}
            }
        }

    });

    // Zoom.js

    $('.magazine-viewport').zoom({
        flipbook: $('.magazine'),

        max: function () {

            return largeMagazineWidth() / $('.magazine').width();

        },

        when: {

            swipeLeft: function () {
				
                $(this).zoom('flipbook').turn('next');

            },

            swipeRight: function () {

                $(this).zoom('flipbook').turn('previous');

            },

            zoomIn: function () {

                $('.magazine').removeClass('animated').addClass('zoom-in');

                if (!window.escTip && !$.isTouch) {
                    escTip = true;

                    $('<div />', {'class': 'exit-message'}).html('<div>双击退出放大模式</div>').appendTo($('body')).delay(2000).animate({opacity: 0}, 500, function () {
                        $(this).remove();
                    });
                }
            },

            zoomOut: function () {

                $('.exit-message').hide();

                setTimeout(function () {
                    $('.magazine').addClass('animated').removeClass('zoom-in');
                    resizeViewport();
                }, 0);

            }
        }
    });

    // Zoom event

    if ($.isTouch)
        $('.magazine-viewport').bind('zoom.doubleTap', zoomTo);
    else
        $('.magazine-viewport').bind('zoom.tap', zoomTo);

    $(window).resize(function () {
        resizeViewport();
    }).bind('orientationchange', function () {
        resizeViewport();
    });

    resizeViewport();

    $('.magazine').addClass('animated');

});
function showdetail(){
	document.getElementById("detail").style.display = "";
	document.getElementById("preview").style.display = "none";
}
	window.addEventListener("popstate", function(e) { 
				alert(123);
		}, false); 
function showpreview(){
	document.getElementById("detail").style.display = "none";
	document.getElementById("preview").style.display = "";
}

/*	setTimeout(function(){
                var id = document.getElementById("show_content");
//                id.innerHTML = "正在创建您的专属绘本，请耐心等待。。。。";
                id.innerHTML = "如预览过程中有白页出现，可能是网速或系统加载慢造成，请稍等片刻图像即可加载完全";
            },17000);
*/
            /*setTimeout(function(){
             var id = document.getElementById("show_content");
             id.innerHTML = "如预览过程中有白页出现，可能是网速或系统加载慢造成，请稍等片刻图像即可加载完全";
             },30000);*/

            /*setTimeout(function(){
             var id = document.getElementById("show_content");
             id.innerHTML = "很快，小主人专属的定制绘本就要新鲜出炉啦！";
             //                id.innerHTML = "真的，就差最后一点点了，小编手都酸了(T_T)";
             },35000);*/

  /*          setTimeout(function(){
                getCode();
            },34000);


            setTimeout(function(){
                var id = document.getElementById("loading");
                id.style.display = "none";
            },40000);

            var i;
            function getCode(){
                document.getElementById("show_content").style.display='none';
                i = self.setInterval("countdown()", 1000);
            }

            var int = 5;
            function countdown() {
//                document.getElementById("show_content").innerHTML = "真的，就差最后一点点了，小编手都酸了(T_T)" ;
                document.getElementById("show_content").style.display='none';
                document.getElementById("num").style.display='block';
                document.getElementById("num").innerHTML =int;
                int--;
                if(int<0){
                    i=window.clearInterval(i);//结束
                    int = 5; //重新赋值
                }
            }
*/

</script>
        <style>
            #loading{
                width:100%;
                height: 100%;
                position:fixed;
                /*background: url("http://www.babyinbook.com/babyinbook/img/loading.gif") no-repeat 100% 100%;*/
                z-index: 10000;
                /*top: -40%;*/
                /*left: -32%;*/
                background: white;
            }
            #loading div{
                position: fixed;
                z-index: 10000;
                top: 35%;
                /*left: 13%;*/
                text-align: center;
                width: 100%;
                height:30%;
                padding: 20px;
            }
            #loading img{
                position: fixed;
                z-index: 10000;
                top: 45%;
                left: 29%;
            }
        </style>
    </head>
<body style="position: relative">
<!--<div id="loading">
    <div id="show_content" style="font-size: 19px;float: left">正在创建您的专属绘本，请耐心等待。。。。</div>
    <div id="num" style="font-size: 30px;display: none;float: left;margin-top: 12%;color: red;"></div>
    <img src="http://www.babyinbook.com/babyinbook/img/loading.gif" alt="">
</div>-->
<?php
foreach ($res as $k=>$v){?>
   <img src="<?php echo $v;?>" alt="" style="display: none;">
<?php
    }
?>
	<div id="preview" class="content preview" style="display:block">
		<header class="bar bar-nav">
			<a href="javascript:;" onclick="showdetail()" class="icon icon-close pull-right"></a>
			<span class="preview-title">点击边缘翻页 · 双击放大缩小</span></header>
		<div class="magazine-viewport" style="position: relative; overflow: hidden; width: 375px; height: 627px;">
			<div class="container">
				<div class="magazine">
					</div>
				
			</div>
		</div>
	</div>
	<div id="detail" style="position: fixed;top:0px;left:0px;z-index: 9999" class="content content-home" ><div class="customize-card"><div style="margin-bottom:20px;" class="thumbnail-preview"><a href="javascript:;" onclick="showpreview()"><img src="<?php echo str_replace("/show/show", "", $res[0]); ?>" class="img-responsive"><span><i class="fa fa-search"></i> 点击预览</span></a></div></div><div style="" class="pure-g">
		<div class="pure-u-1-24"></div>
		<form class="pure-u-10-24" >
<!--		<a style="border-radius: 10px;padding-left:0px;padding-right:0px;" href="/newindex/example/select.php?id=--><?php //echo $bookid; ?><!--" class="btn btn-negative btn-block btn-round blue-linear">重新定制</a>-->
		<a style="border-radius: 10px;padding-left:0px;padding-right:0px;" href="javascript:;" onclick="window.history.go(-1)" class="btn btn-negative btn-block btn-round blue-linear">重新定制</a>
		</form>
		
		<div class="pure-u-1-24"></div>
		<form class="pure-u-10-24" action="fpage.php" method="post">
		<input  type="hidden" name="url" value="<?php echo $url; ?>">
		<input  type="hidden" name="bookid" value="<?php echo $bookid; ?>">
		<input  type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
		<input  type="hidden" name="englishname" value="<?php echo $englishname; ?>">
		<input type="submit" style="border-radius: 10px;padding-left:0px;padding-right:0px;"  class="btn btn-negative btn-block btn-round blue-linear" value="定制扉页" />
		</form>
</body>

</html>
