<?php
App::import('Lib', 'Facebook');
class MessageController extends AppController {
	public $uses = array();
	
	public function count(){
		$config = Configure::read('Facebook');
		$facebook = new Facebook(array(
			'appId' => $config['appId'],
			'secret' => $config['secret']
		));
		
		$user = $facebook->getUser();
		if ($user) {
  			$logoutUrl = $facebook->getLogoutUrl();
		}
	  	$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'read_mailbox,publish_stream'  
		));
	  	$this->set('loginUrl', $loginUrl);
	  	
		$access_token = $facebook->getAccessToken();
		debug($access_token);
		if($access_token) {
			$threads = $facebook->api(array(
				'method' => 'fql.query',
				'query' => 'select recent_authors,message_count from thread where viewer_id = me() and folder_id = 0 order by message_count desc'
			));
//			$facebook->setAccessToken($access_token);
			$me = $facebook->api('/me');

			$result = array();
			$i = 1;
			//$message = 'Ai nhắn tin cho bạn nhiều nhất?
			$message = 'Tag cái nhỉ?
			';
			
			foreach($threads as $thread){
				if($i > 10) break;
				$user = array();
				foreach($thread['recent_authors'] as $author){
					if($author != $me['id'])
						$user['id'] = $author;
				}
				$user['count'] = $thread['message_count'];
				$response = $facebook->api(array(
					'method' => 'fql.query',
					'query' => 'select name from user where uid=' . $user['id']
				));
				$user['name'] = $response[0]['name'];
				$result[] = $user;
				//$message .= $i . '. ' . $user['name'] . ': ' . $user['count'] . '
				$message .= $i . '. @[' . $user['id'] . ':' . $user['name'] . '] : ' . $user['count'] . '
				';
				$i++;
				break;
			}
			
			if($result) {
				$arg = array(
					'message' => $message
				);
				$facebook->api('/me/feed', 'POST', $arg);
			}
		}
		
	}
}