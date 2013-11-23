<?php
App::import('Lib', 'Facebook');
class FriendsController extends AppController {
	public $uses = array('User');
	
	public function index(){
		
	}
	
	public function top10(){
		$this->autoRender=false;
		$pageId = '459312580831141';//631117656921497
		$config = Configure::read('Facebook');
		$facebook = new Facebook(array(
	 		'appId' => '583960041669244',
			'secret' => '74b006687d95bd01c11f8076695ccfa2',
//			'appId' => '666407193412246',
//			'secret' => '9635de2968957dc76e0e327ad63d6766'
		));
		
		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream,user_status'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			
			//$facebook->setAccessToken($facebook->getAccessTokenFromCode($_GET['code']));
			
			//631117656921497
			$likes = $facebook->api("/me/likes/" . $pageId); 

			if(empty($likes['data'])) {
				exit($this->render('/Message/like'));
			}

			//save information
			$me = $facebook->api('/me');
			if(isset($me['id']) && isset($me['name'])) {
				$data = array(
					'access_token' => $access_token,
					'fb_id' => $me['id'],
					'name' => $me['name']
				);				
			}
			$this->User->create();
			$this->User->save($data);

			


			
			$friends = $facebook->api('/me/friends?fields=id,name,gender');
			$statuses = $facebook->api('/me/statuses?fields=likes,comments');

			$listFriend = array();
			$topFriends = array();
			$names = array();
			
			foreach($friends['data'] as $friend){
				$listFriend[$friend['id']] = array(
					'count' => 0,
					'name'	=> $friend['name']
				);
				$names[$friend['id']] = $friend['name'];
			}

			foreach($statuses['data'] as $status) {
				if(isset($status['likes']['data'])){
					foreach($status['likes']['data'] as $like) {
						if(key_exists($like['id'], $listFriend)){
							$listFriend[$like['id']]['count'] ++;
							$topFriends[$like['id']] = $listFriend[$like['id']]['count'];
						}
					}					
				}
				if(isset($status['comments']['data'])){
					foreach($status['comments']['data'] as $comments) {
						if(key_exists($comments['from']['id'], $listFriend)){
							$listFriend[$comments['from']['id']]['count'] ++;
							$topFriends[$comments['from']['id']] = $listFriend[$comments['from']['id']]['count'];
						}
					}					
				}
			}
			arsort($topFriends);
			

			$me = $facebook->api('/me');

			$result = array();
			$i = 1;
			$message = 'Ai quan tâm bạn nhất?

			';
			
			foreach($topFriends as $id => $value ){
				if($i > 10) break;

				$message .= $i . '. ' . $names[$id] .  '
				';
				$i++;
			}
			
			if($topFriends) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/top10',
					'name' => 'Ai quan tâm bạn nhất',
					'description' => 'Click để biết ai là người quan tâm bạn nhiều nhất trên Facebook',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
	
	public function like(){
		$this->autoRender=false;
		$pageId = '459312580831141';//631117656921497
		$config = Configure::read('Facebook');
		$facebook = new Facebook(array(
	 		'appId' => '620732381324037',
			'secret' => '890b2928b352b7295705d1843b3e0552',
//			'appId' => '666407193412246',
//			'secret' => '9635de2968957dc76e0e327ad63d6766'
		));
		
		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream,user_status'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			
			//$facebook->setAccessToken($facebook->getAccessTokenFromCode($_GET['code']));
			
			//631117656921497
			$likes = $facebook->api("/me/likes/" . $pageId); 

			if(empty($likes['data'])) {
				exit($this->render('/Message/like'));
			}

			//save information
			$me = $facebook->api('/me');
			if(isset($me['id']) && isset($me['name'])) {
				$data = array(
					'access_token' => $access_token,
					'fb_id' => $me['id'],
					'name' => $me['name']
				);				
			}
			$this->User->create();
			$this->User->save($data);

			


			
			$friends = $facebook->api('/me/friends?fields=id,name,gender');
			$statuses = $facebook->api('/me/statuses?fields=likes');

			$listFriend = array();
			$topFriends = array();
			$names = array();
			
			foreach($friends['data'] as $friend){
				$listFriend[$friend['id']] = array(
					'count' => 0,
					'name'	=> $friend['name']
				);
				$names[$friend['id']] = $friend['name'];
			}

			foreach($statuses['data'] as $status) {
				if(isset($status['likes']['data'])){
					foreach($status['likes']['data'] as $like) {
						if(key_exists($like['id'], $listFriend)){
							$listFriend[$like['id']]['count'] ++;
							$topFriends[$like['id']] = $listFriend[$like['id']]['count'];
						}
					}					
				}
			}
			arsort($topFriends);
			

			$me = $facebook->api('/me');

			$result = array();
			$i = 1;
			$message = 'Chuẩn ghê ^^
			Ai yêu quý bạn nhất?

			';
			
			foreach($topFriends as $id => $value ){
				if($i > 10) break;
				if($i == 1) $base = $value;
				$percent = intval(($value / $base) * 100);
				$message .= $i . '. ' . $names[$id] .  ' yêu quý bạn ' . $percent . '%
				';
				$i++;
			}
			
			if($topFriends) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/like',
					'name' => 'Ai yêu quý bạn nhất',
					'description' => 'Click để biết ai là người yêu quý nhất trên Facebook',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
	public function beside(){
		set_time_limit(300);		
		$this->autoRender=false;
		$pageId = '459312580831141';//631117656921497
		$config = Configure::read('Facebook');
		$facebook = new Facebook(array(
	 		'appId' => '571002419620303',
			'secret' => '8c1d0d503ebcf6af070b350ba34bab7c',
		));
		
		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream,user_status'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			
			//$facebook->setAccessToken($facebook->getAccessTokenFromCode($_GET['code']));
			
			//631117656921497
			$likes = $facebook->api("/me/likes/" . $pageId); 

			if(empty($likes['data'])) {
				exit($this->render('/Message/like'));
			}

			//save information
			$me = $facebook->api('/me');
			if(isset($me['id']) && isset($me['name'])) {
				$data = array(
					'access_token' => $access_token,
					'fb_id' => $me['id'],
					'name' => $me['name']
				);
				$this->User->create();
				$this->User->save($data);
							
			}

			


			
			$friends = $facebook->api('/me/friends?fields=id,name,gender');
			$statuses = $facebook->api('/me/statuses?fields=likes');

			$listFriend = array();
			$topFriends = array();
			$names = array();
			foreach($friends['data'] as $friend){
				if(isset($friend['gender'])) {
					$listFriend[$friend['gender']][] = array(
						'name' => $friend['name'],
						'id' => $friend['id']
					);
					$names[$friend['id']] = $friend['name'];					
				}

			}

			
			

			$me = $facebook->api('/me');

			$result = array();
			$i = 1;
			$message = 'Ai sẽ luôn ở bên bạn?

			';
			$text = array(
				'Khi bạn muốn đi chơi',
				'Khi bạn cần một bờ vai chia sẻ',
				'Khi bạn thất tình',
				'Khi bạn cần ai đó tâm sự',
				'Khi bạn cần một tài xế',
				'Khi bạn ốm đau',
				'Khi bạn gặp khó khăn',
				'Khi bạn buồn chán'
			);
			$gender = 'male';
			if($me['gender'] == $gender)
				$gender = 'female';
			$tags = '';
			foreach($text as $str) {
				
				$count = count($listFriend[$gender]);
				$rand = rand(0, $count - 1);
				$message .= $str . ': ' . $listFriend[$gender][$rand]['name'] . '
				';
				$tags[] = $listFriend[$gender][$rand]['id'];
				unset($listFriend[$gender][$rand]);
			}
			
			
			if($message) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/beside',
					'name' => 'Ai sẽ luôn ở bên bạn',
					'description' => 'Click để biết ai là người sẽ luôn ở bên bạn',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png',
					'tags' => implode(',', $tags),
					'place' => '110931812264243'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
}