<?php
App::import('Lib', 'Facebook');
class TestController extends AppController {
	public $uses = array('UserShare');
	
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
		
		$data = array();
		
		if($user) {
			$posts = $facebook->api("/$pageID/posts?fields=id,created_time&limit=100");
			//$post = $facebook->api('/494809360630930/sharedposts');
			$shared = array();
			$lastWeek = date('U', time()) - 7 * 86400;
			$sharedUser = $this->UserShare->find('list', array(
				'conditions' => array(
					'AND' => array(
						array('page_id' => $pageID),
						array('share_date >=' =>  $lastWeek)
					)
				),
				'fields' => array('fb_id'),
				'limit' => 1000					
				)
			 );
			foreach($posts['data'] as $post) {
				$postTime = date('U', strtotime($post['created_time']));
				if(time() - $postTime <= 7 * 86400) {
					$ids = explode('_', $post['id']);
					$postId = end($ids);
					$shares = $facebook->api('/' . $postId . '/sharedposts?fields=from&limit=1000');
					if(isset($shares['data']) && $shares['data']) {
						foreach ($shares['data'] as $share) {
							$id = explode('_', $share['id']);
							if(!in_array($id[0], $sharedUser)) {
								$data[] = array(
									'fb_id' => $id[0],
									'fb_name' => $share['from']['name'],
									'share_date' => $postTime,
									'page_id' => $pageID
								);
							}
			
						}

					}
				}
	
			}
			
			$this->UserShare->saveAll($data);
			//get data to display
			$sharedUser = $this->UserShare->find('all', array(
				'conditions' => array(
					'AND' => array(
						array('page_id' => $pageID),
						array('share_date >=' =>  $lastWeek)
						)				
					)
				)
		 	);
			foreach($sharedUser as $user){
				$shared[$user['UserShare']['id']] = array(
					'fb_id' => $user['UserShare']['fb_id'],
					'fb_name' => $user['UserShare']['fb_name']
				);
			}
			
			$this->set('shared', $shared);
		} else {
			$this->redirect($loginUrl);
		}
	}
}