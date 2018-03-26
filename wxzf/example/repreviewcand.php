<?php

header("Content-type: text/html; charset=utf-8");


$url = $_POST['url'];
$json = file_get_contents($url);

$res = json_decode($json,true);
?>
<html>
	<head><meta charset="utf-8"><title>宝贝在书里 · 定制</title><!-- Sets initial viewport load and disables zooming--><meta name="viewport" content="initial-scale=1, maximum-scale=1"><!-- Makes your prototype chrome-less once bookmarked to your phone's home screen--><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black"><link href="/css/pure-min.css" rel="stylesheet"><!-- Include the compiled Ratchet CSS--><link href="/css/ratchet.min.css" rel="stylesheet"><!-- Include the Awesome Font CSS--><link href="/css/font-awesome.min.css" rel="stylesheet"><link href="/css/app.css" rel="stylesheet"><link href="/css/magazine.css" rel="stylesheet"><!-- Include the compiled Ratchet JS--><script src="/js/ratchet.min.js"></script><script src="/js/turn/jquery.min.1.7.js"></script><script src="/js/turn/turn.min.js"></script><script src="/js/turn/zoom.min.js"></script><script src="/js/newmagazine.js"></script><script type="text/javascript">$(document).ready(function () {


    var flipbook = $('.magazine');
    bookPath = '/data/fd9c24c867b412f9/preview/';

    // Create the flipbook

    flipbook.turn({

        // Magazine width

        width: 1650,

        // Magazine height

        height: 612,

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
var x = '<?php echo $json; ?>';
x = JSON.parse( x );
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


</script></head>
<body style="position: relative">
			<?php foreach($res as $key=>$value){ ?>
		<div style="width:100%">
			<img src="<?php echo $value; ?>" style="width:100%">
			
		</div>	
		<?php } ?>
	
</body>

</html>
