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
			location.reload();
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
<div class="fb-like-box" layout="box_count" href="https://www.facebook.com/pages/Ong-Vàng-Shop/119282301570480" data-layout="box_count" data-width="292" data-colorscheme="light" data-show-faces="false" data-header="false" show_faces="false" data-stream="false" data-show-border="false"></div>
