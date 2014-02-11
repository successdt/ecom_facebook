<?php
App::import('Lib', 'Facebook');
class TestController extends AppController {
	
	public function index(){
		
	}
	
	public function getMessage(){

	}
	
	public function share($pageID = ''){
		if(!$pageID)
			exit('Bạn vui lòng nhập page_id');
		$facebook = new Facebook(array(
	 		'appId' => '634956596571361',
			'secret' => 'aa7b261d8c7815c30da57c03bb4f1ebd',
//			'appId' => '614516575252495',
//			'secret' => 'da3dc92fca3b71d4c3bc3ee37d1390ce'
		));

		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream,user_status, export_stream'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			$posts = $facebook->api("/$pageID/posts?fields=id,created_time&limit=100");
			//$post = $facebook->api('/494809360630930/sharedposts');
			$shared = array();
			foreach($posts['data'] as $post) {
				$postTime = date('U', strtotime($post['created_time']));
				if(time() - $postTime <= 7 * 86400) {
					$ids = explode('_', $post['id']);
					$postId = end($ids);
					$shares = $facebook->api('/' . $postId . '/sharedposts?fields=from&limit=1000');
					if($shares['data']) {
						foreach ($shares['data'] as $share) {
							$shared[] = $share['from'];					
						}

					}
				}
	
			}
			$this->set('shared', $shared);
		} else {
			$this->redirect($loginUrl);
		}
	}
}