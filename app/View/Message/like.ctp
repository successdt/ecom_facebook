<h2>Bạn cần like để sử dụng ứng dụng</h2>
<div id="fb-root"></div>
<script type="text/javascript">
/*
window.fbAsyncInit = function() {
 FB.init({appId: '193983577403302', status: true, cookie: true, xfbml: true});
 FB.Event.subscribe('edge.create', function(href, widget) {
 	// Do something, e.g. track the click on the "Like" button here
	//window.location.href = "<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'count')) ?>";
	location.reload();
});
};
*/
	window.fbAsyncInit = function() {
		FB.init({
	    	appId  : '190385031146259', //193983577403302
	    	channelUrl : '//localhost/facebook/message/count',
	    	xfbml  : true,
		 	oauth : true,
			cookie: true,
	    	frictionlessRequests: true,
		});
		fbApiInitialized = true;
		FB.Canvas.setAutoGrow();
		FB.Event.subscribe('edge.create', function(href, widget) {
		 	// Do something, e.g. track the click on the "Like" button here
			//window.location.href = "<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'count')) ?>";
			//location.reload();
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
<fb:like href="hhttps://www.facebook.com/pages/Ong-Vàng-Shop/119282301570480" data-send="false" send="false" layout="box_count" width="70" show_faces="false" font="arial" fb-xfbml-state="rendered" class="fb_edge_widget_with_comment fb_iframe_widget" style="width: 50px;height: 65px; overflow: hidden;">
</fb:like>

<script type="text/javascript">
	function likePage(){
		$('.fb_edge_widget_with_comment').html('<h1>Đợi chút nhé</h1>');
		//window.location = 'http://ecomfacebook.tk/message/count';
		location.reload();
	}
</script>