<h2>Bạn cần like để sử dụng ứng dụng</h2>

<div id="fb-root"></div>
<script type="text/javascript">
<!--
window.fbAsyncInit = function() {
 FB.init({appId: '401582569900520', status: true, cookie: true, xfbml: true});
 FB.Event.subscribe('edge.create', function(href, widget) {
 	// Do something, e.g. track the click on the "Like" button here
	window.location.href = "<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'count')) ?>";
});

};
(function() {
 var e = document.createElement('script');
 e.type = 'text/javascript';
 e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
 e.async = true;
 document.getElementById('fb-root').appendChild(e);
 }());
//-->
</script>
<div class="fb-like-box" data-href="https://www.facebook.com/FacebookDevelopers" data-layout="box_count" data-width="292" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>