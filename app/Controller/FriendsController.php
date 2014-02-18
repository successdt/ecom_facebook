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
	 		'appId' => $config['appId'],
			'secret' => $config['secret']
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
			
			$topFriends = $this->topFriendsByGender($facebook);
			
			foreach($text as $str) {
				
//				$count = count($listFriend[$gender]);
//				$rand = rand(0, $count - 1);
				if(key($topFriends[$gender])) {
					$message .= $str . ': ' . $names[key($topFriends[$gender])] . '
					';
					$tags[] = key($topFriends[$gender]);
					unset($topFriends[$gender][key($topFriends[$gender])]);					
				}

			}

			if($message) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/beside',
					'name' => 'Ai sẽ luôn ở bên bạn',
					'description' => 'Click để biết ai là người sẽ luôn ở bên bạn',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png',
//					'tags' => implode(',', $tags),
//					'place' => '110931812264243'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}

	public function visit(){
		$this->autoRender=false;
		$pageId = '459312580831141';//631117656921497
		$config = Configure::read('Facebook.ung-dung-hot');
		$facebook = new Facebook(array(
	 		'appId' => $config['appId'],
			'secret' => $config['secret']
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
			$message = 'Ai hay ghé thăm tường nhà bạn trong tuần qua?

			';
			
			foreach($topFriends as $id => $value ){
				if($i > 10) break;

				$message .= $i . '. ' . $names[$id] . ': ' . $listFriend[$id]['count'] . ' lượt 
				';
				$i++;
			}
			if($topFriends) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/visit',
					'name' => 'Ai hay ghé thăm tường nhà bạn',
					'description' => 'Click để xem ai hay ghé thăm tường nhà bạn nhiều nhất',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
	
	public function kieptruoc(){
		$this->autoRender=false;
		$pageId = '397071897093833';//631117656921497
		$pageUrl = 'https://www.facebook.com/muasamkm';
		$config = Configure::read('Facebook.kiep-truoc');
		$facebook = new Facebook(array(
	 		'appId' => '626511720750170',
			'secret' => 'e164c516ac0c3080eb6a8a4117e95302'
		));
		
		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream,user_status, friends_birthday'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			

			$likes = $facebook->api("/me/likes/" . $pageId); 
			if(empty($likes['data'])) {
				$data = array('pageId', 'pageUrl');
				$this->set(compact($data));
				exit($this->render('like'));
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

			$friends = $facebook->api('/me/friends?fields=id,name,birthday');
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
				if(isset($friend['birthday']))
					$birthday[$friend['id']] = $friend['birthday'];
				
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
			$message = 'Hài quá :v
			Kiếp trước các bạn của mình là:
			';
			
			foreach($topFriends as $id => $value ){
				if($i > 10) break;
				if(isset($birthday[$id])){
					$date = explode('/', $birthday[$id]);
					if(count($date) > 2){
						$jobs = array(
							1 => 'Nhà sư',
							2 => 'Nông dân',
							3 => 'Thái giám',
							4 => 'Nô tì',
							5 => 'Hoàng hậu',
							6 => 'Tri phủ',
							7 => 'Đại phu',
							8 => 'Lính',
							9 => 'Vua',
							10 => 'Hiệp khách',
							11 => 'Kĩ nữ'
						);
						$ages = array(
					 		0 => 'Nhà Tiền Lý (541-602)',
							1 => 'Nhà Ngô (938-967)',
							2 => 'Nhà Đinh (968-980)',
							3 => 'Nhà Tiền Lê (980-1009)',
							4 => 'Nhà Lý (1009-1225)',
							5 => 'Nhà Trần (1225-1400)',
							6 => 'Nhà Hồ (1400-1407)',
							7 => 'Nhà Hậu Lê (1428-1778)',
							8 => 'Nhà Tây Sơn (1778-1802)',
							9 => 'Nhà Nguyễn (1802-1945)'
						);
						$die = array(
							1 => 'Chém đầu',
							2 => 'Té',
							3 => 'Treo cổ',
							4 => 'Bị giặc giết',
							5 => 'Uống thuốc độc',
							6 => 'Chết đuối',
							7 => 'Cắt gân tay',
							8 => 'Chết già',
							9 => 'Bị bệnh nặng',
							10 => 'Rắn cắn',
							11 => 'Tự sát',
							12 => 'Sét đánh'
						);
						$month = substr($date[1], 0, 1) + substr($date[1], 1, 1);
						$message .= $names[$id] . ': Sống ở thời ' . $ages[$date[2] % 10] . ', làm ' . strtolower($jobs[$month]) . ', chết vì ' .  strtolower($die[$date[0] + 0]) . '
						';
						$i++;						
					}
				}

			}
			if($topFriends) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/friends/kieptruoc',
					'name' => 'Kiếp trước bạn bè của mình là ai?',
					'description' => 'Click để xem kiếp trước bạn bè của bạn là ai?',
					'picture' => 'http://www.veryicon.com/icon/png/Application/iPhonica%20Vol.%202/Contact.png'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
	
	public function wish(){
		$this->autoRender=false;
		$pageId = '397071897093833';//631117656921497
		$pageUrl = 'https://www.facebook.com/muasamkm';
		$appUrl = 'http://ecomfacebook.tk/friends/wish';
		
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
			'scope' => 'read_mailbox,publish_stream,user_status'  
		));
	  	$this->set('loginUrl', $loginUrl);
		
		$access_token = $facebook->getAccessToken();
	
		if($user) {
			

			$likes = $facebook->api("/me/likes/" . $pageId); 
			if(empty($likes['data'])) {
				$data = array('pageId', 'pageUrl');
				$this->set(compact($data));
				exit($this->render('like'));
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

			$statuses = $facebook->api('/me/statuses?fields=likes,comments');

			$listFriend = array();
			$topFriends = array();
			$names = array();
			
			$friends = $facebook->api('/me/friends?fields=id,name,gender');
			
			$topFriends = $this->topFriendsByGender($facebook);
			
		 	arsort($topFriends['female']);
		 	arsort($topFriends['male']);		
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

			
			$wishes['f'] = array(
				'có thật nhiều gấu bông ^^',
				'được ăn thật nhiều quà vặt 0_0',
				'không tăn cân >"<',
				'trở thành hot girl :v',
				'thoát kiếm FA :s',
				'có thật nhiều váy đẹp :x',
				'được mừng tuổi thật nhiều'
				
			);
			
			$wishes['m'] = array(
				'mua được siêu xe >:D<',
				'sớm có gấu <3',
				'không phải học lại :)',
				'về quê lấy vợ :D',
				'không còn xấu trai nữa',
				'trở thành siêu nhân :v'
			);
			shuffle($wishes['f']);
			shuffle($wishes['m']);

			$me = $facebook->api('/me');

			$result = array();
			
			$message = 'Hài quá :v
			Điều ước trong năm mới của mọi người là:
			';
			$i = 1;
			foreach($topFriends['female'] as $id => $value ){
				if($i > 5) break;
				$msg[] = $names[$id] . ': ' . $wishes['f'][$i] . '
				';
				$i++;
			}
			$i = 1;
			foreach($topFriends['male'] as $id => $value ){
				if($i > 5) break;
				$msg[] = $names[$id] . ': ' . $wishes['m'][$i] . '
				';
				$i++;
			}
			
			shuffle($msg);
			
			$message .= implode('', $msg);
			if($topFriends) {
				
				$arg = array(
					'message' => $message,
					'link' => $appUrl,
					'name' => 'Điều ước năm mới?',
					'description' => 'Click để xem điều ước trong năm mới của mọi người',
					'picture' => 'http://www.rit.edu/mobile/uploads/Icon_512.png'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}		
	}
	
	private function topFriendsByGender($facebook) {
			$friends = $facebook->api('/me/friends?fields=id,name,gender');
			$statuses = $facebook->api('/me/statuses?fields=likes,comments');

			$listFriend = array();
			$topFriends = array();
			$names = array();
			
			foreach($friends['data'] as $friend){
				$listFriend[$friend['id']] = array(
					'count' => 0,
					'name'	=> $friend['name'],
					'gender' => isset($friend['gender']) ? $friend['gender'] : 'male'
				);
				$names[$friend['id']] = $friend['name'];
			}

			foreach($statuses['data'] as $status) {
				if(isset($status['likes']['data'])){
					foreach($status['likes']['data'] as $like) {
						if(key_exists($like['id'], $listFriend)){
							$listFriend[$like['id']]['count'] ++;
							$topFriends[$listFriend[$like['id']]['gender']][$like['id']] = $listFriend[$like['id']]['count'];
						}
					}					
				}
				if(isset($status['comments']['data'])){
					foreach($status['comments']['data'] as $comments) {
						if(key_exists($comments['from']['id'], $listFriend)){
							$listFriend[$comments['from']['id']]['count'] ++;
							$topFriends[$listFriend[$comments['from']['id']]['gender']][$comments['from']['id']] = $listFriend[$comments['from']['id']]['count'];
						}
					}					
				}
			}
			arsort($topFriends);
			
			return $topFriends;
	}
}