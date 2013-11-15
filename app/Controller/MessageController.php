<?php
App::import('Lib', 'Facebook');
class MessageController extends AppController {
	public $uses = array();
	
	public function index(){
		
	}
	
	public function count(){
		session_start();
		$this->Session->destroy();
		$this->autoRender=false;
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

	
		if($access_token && isset($_GET['code'])) {
			//631117656921497
			$likes = $facebook->api("/me/likes/119282301570480"); 


			if(empty($likes['data'])) {
				exit($this->render('like'));
			}

			$threads = $facebook->api(array(
				'method' => 'fql.query',
				'query' => 'select recent_authors,message_count from thread where viewer_id = me() and folder_id = 0 order by message_count desc'
			));
//			$facebook->setAccessToken($access_token);
			$me = $facebook->api('/me');

			$result = array();
			$i = 1;
			$message = 'Ai nhắn tin cho bạn nhiều nhất?

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
				$message .= $i . '. ' . $user['name'] . ': ' . $user['count'] . '
				';
				$i++;
			}
			
			if($result) {
				
				$arg = array(
					'message' => $message,
					'link' => 'http://ecomfacebook.tk/message/count',
					'name' => 'Ai nhắn tin cho bạn nhiều nhất',
					'description' => 'Click để biết ai là người nhắn tin cho bạn nhiều nhất trên Facebook',
					'picture' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu6xXM8VmDQrnCBraQ9e0-ZRv_OMbsl51Dv1ljfSUCRPVTNufw'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
}