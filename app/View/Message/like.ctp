<h2>Bạn cần like để sử dụng ứng dụng</h2>
<?php /*
<div id="fb-root"></div>
<script type="text/javascript">
<!--
window.fbAsyncInit = function() {
 FB.init({appId: '190385031146259', status: true, cookie: true, xfbml: true});
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
//-->
</script>
<div class="fb-like-box" layout="button_count" data-href="https://www.facebook.com/pages/Ong-Vàng-Shop/119282301570480" data-layout="box_count" data-width="292" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
*/ ?>
<div id="fb-root"></div>
<script>
/*
window.fbAsyncInit = function() {
 FB.init({appId: '190385031146259', status: true, cookie: true, xfbml: true});
 FB.Event.subscribe('edge.create', function(href, widget) {
 	// Do something, e.g. track the click on the "Like" button here
	//window.location.href = "<?php echo $this->Html->url(array('controller' => 'message', 'action' => 'count')) ?>";
	location.reload();
});
};
*/
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=401582569900520";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<fb:like-box href="http://www.facebook.com/FacebookDevelopers" width="100" height="100" colorscheme="light" show_faces="false" header="false" stream="false" show_border="false"></fb:like-box>