<?php
class AjaxPage extends AjaxPageBase {
    protected $wishModel;
    protected $response;
    protected $user_id;
    public function __construct() {
        parent::__construct();
        $this->wishModel = new WishModel();
        $this->response = new AjaxResponse();
        $this->user_id = &$this->userData[0];
    }
    
    /**
     * Load user wishes 
     * TODO: restrict by privacy
    */
	//die("text");
	public function actionLoadRegistError() {    
		$fieldname = @$_POST["fieldname"];
		$fieldvalue = @$_POST["fieldvalue"];
		if($fieldname == "username"){
			$slimit = 1;
		}
		if($fieldname == "email"){
			$slimit = 2;
		}
		if($fieldname == "mobile"){
			$slimit = 3;
		}
		//die($fieldname);
	    //$this->data['error_msg'] = $this->SiteHelper->getUserValid($fieldname, $slimit);
		//var_export($this->data['wishes']);				
		$this->loadView('ajax/fieldvalidate');    
	}

    public function actionLoadWishes() {        
        $uid  = isset($_POST['uid']) ? intval($_POST['uid']) : 0 ;
        $ukey = isset($_POST['u_key']) ? $_POST['u_key'] : 0 ;
        if(!$uid || $ukey != WishHelper::generateUserKey($uid)) {
            PageFunctions::show404();
        }        
		$slimit = @$_POST['slimit'];
		$this->data['privacies']  = WishModel::getPrivacies();     
        $this->data['wishes'] = $this->wishModel->getUserWishes($uid, $this->user_id, $slimit);
        $this->loadView('ajax/wishes');    
        die;
    }   
    
	  public function actionLoadWishes1() {        
		$uid  = isset($_POST['uid']) ? intval($_POST['uid']) : 0 ;
		//echo $this->user_id;
		//$uid  = $_POST['uid'];
        $ukey = isset($_POST['u_key']) ? $_POST['u_key'] : 0 ;    
        /*if(!$uid || $ukey != WishHelper::generateUserKey($uid)) {
            PageFunctions::show404();
        }*/       
        //echo $uid.' - '.  $this->user_id;
		$group_no = @$_POST['group_no'];
		//die('მომხმარებელი უკვე არის თქვენს მეგობრების სიაში');
		 $this->data['wishes'] = $this->wishModel->getUserWishes($uid, $this->user_id, $group_no);
		//var_export($this->data['wishes']);
        $this->loadView('ajax/wishes');    
        die;
    }   

    public function actionFriend() {
        $act = isset($_POST['act']) ? $_POST['act'] : '';        
		//$friendfindtext = @$_POST['findfriends'];
        $ukey = @$_POST['u_key'];
		//$userfindtext = @$_POST['findfriends'];
        //echo $act." ".$friendId." ".$this->user_id;
        $possibleAction = array(
			'add' =>1,
			'accept' => 2,
			'remove' => 3,
			'reject' => 4,
			'cancel' => 5,
			'find' => 6
        );
		if($act != 'find')
		{
			$friendfind = intval(@$_POST['frId']);
				if($friendfind == $this->user_id 
				OR ($friendfind < 1)
				OR (!isset($possibleAction[$act]))) 
				{
					PageFunctions::show404();
				}
        }//find
		else
		{
			$friendfind = @$_POST['frId'];
		}
		//die($friendfind);
        $isFriend = ProfileModel::areFriends($this->user_id, $friendfind);        
        if($act == 'add') {
            if($isFriend) {
                die('მომხმარებელი უკვე არის თქვენს მეგობრების სიაში');
            }            
            $res = ProfileModel::addFriend($this->user_id, $friendfind);       
			//header('Refresh: 0');
            if($res) {
              die('მოთხოვნა გაგზავნილია');
            } else {
              die('თქვენს შორის უკვე არსებობს მეგობრობაზე მოთხოვნა');
            }      
			//header('Refresh: 0');     
            //მეგობრებში დამატება            
        } 
        // დათანხმება მეგობრობაზე
        else if('accept' == $act) {
            if($isFriend) {
               die('მომხმარებელი უკვე არის თქვენს მეგობრების სიაში');
            }

            $acceptKey = URL::generateKey(array($friendfind, 'accept'));
            if($acceptKey != $ukey) {
               die('არასწორი მოთხოვნა');
            }            
            // ვადასტურებთ მეგობარს
            $res = ProfileModel::acceptFriend($this->user_id, $friendfind);            
            if($res == -1) {
               die('მეგობრობაზე მოთხოვნა არ არის');
            } else if($res == 0) {
               die("მოხდა შეცდომა");
            } else {
               die("წარმატებით დაამატეთ მეგობარი");
            }
        }
        // მეგობრობაზე უარი
        else if('reject' == $act) {
            $rejectKey = URL::generateKey(array($friendfind, 'reject'));
            if($rejectKey != $ukey) {
               die('არასწორი მოთხოვნა');
            }            
            $res = ProfileModel::rejectFriend($this->user_id, $friendfind);
            if($res) {
               die('წარმატებით დასრულდა');
            } else {
               die('მოთხოვნა არ არსებობს');
            }            
        } 
        // წაშლა მეგობრებიდან
        else if ('remove' == $act) {
            /*$removeKey = URL::generateKey(array($friendfind, 'remove'));
            if($removeKey != $ukey) {
               die('არასწორი მოთხოვნა');
            }            
            if(!$isFriend) {
               die('მომხმარებელი არ არის თქვენს მეგობრებში'); 
            }*/          
            $res = ProfileModel::removeFriend($this->user_id, $friendfind);
            if($res) {
				$newlistoffriends = ProfileModel::getFriends($this->user_id);
				$this->data['found'] = $newlistoffriends;    
				$this->loadView('ajax/friends');  
				$not = NotificationModel::deleteFriendshipNtfs($this->user_id, $friendfind);
                die($not);
            } /* else {
              die('მომხმარებელი არ არის თქვენს მეგობრებში');
            } */            
        }      
        // მეგობრობის მოთხოვნის გაუქმება
        elseif('cancel' == $act) {
            // $removeKey = URL::generateKey(array($friendId, 'remove'));
            /* if($removeKey != $ukey) {
                die('არასწორი მოთხოვნა');
            } */        
            $res = ProfileModel::cancelFriend($this->user_id, $friendfind);
            if($res) {
               die('მოთხოვნა გაუქმებულია');
            } else {
               die('მომხმარებელი არ არის თქვენს მეგობრებში');
            }         
        }  
		// ხალხის მოძიება 
        elseif ('find' == $act) {
			//die('არასწორი მოთხოვნა');
            //$removeKey = URL::generateKey(array($friendId, 'remove'));
            /*if($removeKey != $ukey) {
                die('არასწორი მოთხოვნა');
            } */      
			if($friendfind=="")
			{
				$res = ProfileModel::getFriends($this->user_id);
			} else {
				$res = ProfileModel::findFriend($this->user_id, $friendfind);
			}
			$this->data['found'] = $res;    
			$this->loadView('ajax/friends');  
			//$this->loadView('ajax/findfriend');
			//die($friendfind);
			/*foreach($this->data['found'] as $w) :
			$username = (string)$w->username;
			die($username);
			endforeach;*/
			
			// die('ძებნა შესრულებულია');
            /* if($res) {
               die('ძებნა შესრულებულია');
            }  else {
               die('სამწუხაროდ ძებნა ვერ შესრულდა');
            } */       			
        }      
        die;
    }  


public function actionWish() {
        $act = isset($_POST['act']) ? $_POST['act'] : '';        
		$wish_id = @$_POST['wid'];
        $ukey = @$_POST['u_key'];
		//$userfindtext = @$_POST['findfriends'];
        //echo $act." ".$friendId." ".$this->user_id;
        $possibleAction = array(
			'change_privacy' =>1,
        );

		$wish = null;
		if($wish_id) {
			$wish = WishModel::getWish($wish_id, $this->userData[0]);
		}

		// tu survili ar ipovna an ar aris avtorizebuli momxmareblis
		// mashin achvenos 404
        if(!$wish || $this->userData[0] != $wish['user_id']) {
            PageFunctions::show404();
        }        
        ///$wishURL = WishHelper::getWishURL($wid);

		if($act == 'change_privacy')
		{
				$privacy = intval(@$_POST['privacy']);
				if($privacy && $privacy != $wish['privacy'])	{
						$res = WishModel::changePrivacy($this->userData[0], $wish_id, $privacy);
						exit("$res");
				} 
				//PageFunctions::show404();
				
        }//find
		die('-1');
 }



}
