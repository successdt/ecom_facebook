<?php
App::import('Lib', 'Facebook');
class FriendsController extends AppController {
	public $uses = array();
	
	public function index(){
		
	}
	
	public function top10(){
		$this->autoRender=false;
		$pageId = '631117656921497';
		$config = Configure::read('Facebook');
		$facebook = new Facebook(array(
			'appId' => '583960041669244',
			'secret' => '74b006687d95bd01c11f8076695ccfa2'
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
					'picture' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu6xXM8VmDQrnCBraQ9e0-ZRv_OMbsl51Dv1ljfSUCRPVTNufw'
				);
				$facebook->api('/me/feed', 'POST', $arg);
				$this->render('/Message/success');
			}
		} else {
			$this->redirect($loginUrl);
		}
		
	}
}