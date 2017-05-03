<?php
class ProfilePage  extends AuthedPage {
    protected $profileID = 0;
    protected $userRelation = 1;    
    protected $profileData = null;           
    /**
     * Initialize profile
    */
    function __construct() {
        parent::__construct();
        $this->model = new caseModel();		
        //$this->template = 'ajax';
    }
    /**
     * Check for relationship
    */
    protected function checkRelation() {
        $this->userRelation = 
		User::getRelation(
			$this->profileID , 
			$this->userData[0]
		);
    }
    /**
     * წავშალოთ სურვილი და მასთან დაკავშირებული 
     * ყველა მონაცემები სერვერიდან 
     * @param array $case
    */
    private function deletecase($case) {
        //Remove files
        caseHelper::deletecaseFiles($case);
        //Clear comments
        caseCommentModel::deletecaseComments(
			$case['id'], 
			$this->userData['0']
        );
        //trash notifications 
        NotificationModel::deletecaseNtfs($case['id']);
        //Garbage case access grants
        caseModel::deletecaseAccessList($case['id']);
        //Boom case :D 
        return $this->model->deleteEntry($case['id']);
    }

    /**
     * Load index page for profile
    */
    public function actionIndex() {              
        if(isset($_GET['pid'])) {
            $this->profileID = intval($_GET['pid']);
        } else {
            if(User::isAuthed()) {
              $this->profileID = $this->userData[0];
            }
        }        
        if(!$this->profileID || !($this->profileData = ProfileModel::getProfile($this->profileID))) {
           PageFunctions::show404();
        }        
		//$totalcasenumber = caseModel::getcaseesTotal($this->userData[0], true);
		$this->profileData['totalcasenumber'] =  $this->model->getcaseesTotal($this->userData[0], $viewerUserID=null);
        $this->checkRelation();        
        $this->loadPage('profile/index');
    }

    public function actionCategory() {
        $act = isset($_GET['act']) ? $_GET['act'] : '';        
		//$friendfindtext = @$_POST['findfriends'];
        $ukey = @$_GET['u_key'];		
        //echo $act." ".$friendId." ".$this->user_id;
        $possibleAction = array(
			'add' => 1,
			'edit' => 2,
			'del' => 3,
        );
		
		if(isset($_POST['catname'])) {
			$category_name = trim(strip_tags($_POST['catname']));
		} else {
			$category_name = '';
		}
	   
		if(isset($_GET['id'])) {
			$catid = intval($_GET['id']);
			$catdata = caseModel::getCategories($this->userData[0], true, $catid);
			if($catid && !$catdata) {
				PageFunctions::redirect(URL::getPath("profile/category"));
				die;
			}
		} else {
			$catid = 0;
			$catdata = array();
		}

		$result = 0;
		$message = '';
        if($act == 'add' && $category_name) {
		  $res = caseModel::addCategory($this->userData[0], $category_name);
		  if($res) {
				$result = 'suc';
				$message = 'კატეგორია დაემატა';
				//header("Refresh: 0");
		  } else { 
				$result = 'err';
				$message = 'კატეგორია არ დაემატა';
		  }
        } 
        // redaqtireba
        else if('edit' == $act && $catid) {
			if(!$category_name) {
				$this->data['catname'] = $catdata['name'];
			} else {
				  $res = caseModel::editCategory($this->userData[0], $category_name, $catid);
				  if($res) {
						$result = 'suc';
						$message = 'კატეგორია განახლდა';
						//header("Refresh: 0");
				  }  else { 
						$result = 'err';
						$message = 'კატეგორია არ განახლდა';
				  }
			}
        }
        // washla
        else if('del' == $act && $catid) {
			$res = caseModel::deleteCategory($this->userData[0], $catid);
			if($res) {
				$result = 'suc';
				$message = 'კატეგორია წაიშალა';
				//header("Refresh: 0");
			  } else { 
				$result = 'err';
				$message = 'კატეგორია არ წაიშალა';
			  }
        } 
        
	$categories = caseModel::getCategories($this->userData[0], true);		
	$this->data['act'] = $act ? $act : 'add' ;   
	$this->data['catid'] = $catid;			
	$this->data['result'] = $result;
	$this->data['message'] = $message;
	$this->data['categories'] = $categories;    
	$this->loadPage('profile/category');  				
}      

    /*public function actionFindFriends() {
		
		echo "text";
        if(isset($_GET['findfriends'])) {
          $findfriends = trim(strip_tags($_GET['findfriends']));
        } else {
          $findfriends = '';
        }        
        $people = array();        
        $people = ProfileModel::findFriend($this->userData[0], $findfriends);               
        $this->data['found'] = $people;        
        $this->loadPage('profile/find_friend/find');        
    }*/

	public function actionFindFriends(){		
		$people = array(); 
        if(isset($_GET['findfriends'])) {
		$findfriends = @($_GET['findfriends']);
		  $people = ProfileModel::findFriend($this->userData[0], $findfriends);       
        } else {
		  $people = ProfileModel::getFriends($this->userData[0]);       
        }  
		//echo count($people);
        $this->data['found'] = $people;        
        $this->loadPage('profile/find_friend/find');        
    }
    /**
     * მეგობრის სურვილების გვერდი
    */
    public function actionFriendscasees() {
		//echo "text";
		$slimit =0;
		$nlimit = 10;
		//echo $this->userData[0];
        $frcasees = caseModel::getUserFriendscasees($this->userData[0], false, $slimit, $nlimit);
        $this->data['casees'] = $frcasees;
        $this->loadPage('ajax/friendscasees');         
    }

    /**
     * აქ არის კონკრეტული სურვილის გვერდი 
     * 
     * აქ ხდება მონიშვნა, განიშვნა, წაშლა, კომენტარების დამატება წაშლა.
    */
    public function actionViewcase() {        
		$slimit  = 0;       
		$nlimit = 1;   
        $wid = isset($_GET['wid']) ? intval($_GET['wid']) : 0; 
        $case = caseModel::getcase($wid, $this->userData[0]);
		//$case = $this->model->getcase($wid, $this->userData[0]);
        //PageFunctions::debug($case);        
        /**
         * თუ მოწოდებული აიდით არ არის სურვილი, 
         * ან არ აქვს ამ მომხმარებელს ნახვის უფლება, 
         * ვაჩვენებთ 404 გვერდს
        */
        if(!$case) {
            PageFunctions::show404();
        }        
        $caseURL = caseHelper::getcaseURL($wid);
        /**
         * $act განსაზღვრავს მოქმედების ტიპს
         * dc = delete comment
         * ff = fulfil 
         * unff = unfulfil
         * delW = delete case
        */
        $act = isset ($_GET['act']) ? trim(strip_tags($_GET['act'])) : null ;        
        /**
         * თუ არის $_POST ე.ი. ვამატებთ კომენტარს
        */
        if($_SERVER['REQUEST_METHOD']=='POST') 
        {
            $vf = new ValidFluent($_POST);
            $vf->name('comment')->required()->maxSize(1000);
            if($vf->isGroupValid()) {
                $data = array(
                    'case_id' => $wid,
                    'user_id' => $this->userData[0],
                    'body'    => $vf->getValue('comment'),
                );
                // CREATE case MODEL INSTANCE
                $wcm = new caseCommentModel();
                $cmntID = $wcm->createEntry($data);
                header('Refresh:0');
            }            
        } 
        /**
        * კომენტარის წაშლა, $_GET['cid'] კომენტარის აიდით
        */
        elseif (isset ($_GET['act'],$_GET['cid']) && $_GET['act']=='dc') 
        {
            // DELETE COMMENT
            $cid = intval($_GET['cid']);
            caseCommentModel::deleteComment($cid, $this->userData[0]);
            PageFunctions::redirect($caseURL);            
        } 
        /**
         * სურვილის ასრულება
        */
        elseif(@$_GET['act'] == 'ff') // FULFIL
        {   
            $showFF = isset($_GET['show-ff']) and $_GET['show-ff'] == 1 ? 1 : 0;
            $res = $this->model->fulfil($wid,  $this->userData[0], $showFF);            
            if(PageFunctions::isDebug()){
                PageFunctions::debug('Start fulfil: ');
                PageFunctions::debug('ShowFF: '.$showFF);
                PageFunctions::debug('Result (affected rows): '.$res);
            }            
            if($res==1) {
                //შეტყობინების გაგზავნა სურვილის პატრონთან
                NotificationModel::ntfYourcaseSelected(
                    $case['user_id'], $wid, 
                    $this->userData[0], 
                    $showFF
                );                
                //header('Refresh: 0');
                PageFunctions::redirect($caseURL);
            }
        }
        /**
         * ასრულების გაუქმება
        */
        else if (@$_GET['act'] == 'unff') // Cancel fulfil
        {
            $res = $this->model->unFulfil($wid,  $this->userData[0]);            
            if(PageFunctions::isDebug()){
                PageFunctions::debug('Start unFulfil: ');
                PageFunctions::debug('Result (affected rows): '.$res);
            }            
            if($res==1) {
                /**
                 * იმ შემთხვევაში თუ მომხმარებელი აუქმებს ასრულებას, 
                 * წაიშალოს სურვილის ასრულების შეტყობინება 
                */
                NotificationModel::deletecaseFulfilNtfs($wid);
                //header('Refresh: 0');
                PageFunctions::redirect($caseURL);
            }
        } 
        /**
         * სურვილის წაშლა
        */
        else if ('delW' == $act) // DELETE case
        {
            if($case['user_id'] == $this->userData[0]) {
                //var_export($case);
                //წავშალოთ სურვილი
                $res = $this->deletecase($case);
                if($res) {
                    PageFunctions::redirect(url::getPath('profile'));
                }
            }
        }        
        $this->data['case'] = &$case;
        $this->data['comments'] = $this->model->getcaseComments($wid);        
        unset($case, $wid, $act);        
        $this->loadPage('profile/viewcase');
    }   
    
    /**
     * მომხმარებელს შეუძლია ნახოს ყველა შეტყობინებები
    */
    public function actionNotifications() {
        $notes = NotificationModel::getUserNotifications(
        $this->userData[0], 
        false
        );        
        /**
         * აქ ხდება შეტყობინებების განახლება,
         * რომ მომხმარებელმა უკვე ნახა აქამდე არსებული უნახავი შეტყობინებები
        */
        NotificationModel::userSawNtfs($this->userData[0]);        
        $this->data['notifications'] = &$notes;
        $this->loadPage('profile/notifications');
    }

    /**
     * Add new case from post
    */
    public function actionAddcase() {     
        $this->data['categories'] = caseModel::getCategories($this->userData[0]);
        $this->data['privacies']  = caseModel::getPrivacies();       
        // VALIDATE IF POST
        if($_SERVER['REQUEST_METHOD']!= 'POST'){            
        } else {
            $code = 0;
            $message = '';            
            // If set with end date
            $caseEndDate = date('Y-m-d',strtotime(@$_POST['case-end-date']));
            if($caseEndDate<date('Y-m-d')) {
                $caseEndDate = null;
            }            
            //echo '-:'.$caseEndDate.':-';            
            $vf = new ValidFluent($_POST);
            $isUpload = false;            
            $vf->name('case-type')->required()->oneOf('status:photo:link');
            $caseType = $vf->getValue('case-type');            
            /**
             * If link
            */
            if($caseType=='link') {
                $vf->name('case-link')->required();
            }
            $vf->name('case-category')->numberInteger();
            $vf->name('case-privacy')->required()->numberInteger();
            $vf->name('case-title')->required()->maxSize(255);
            $vf->name('case-text')->required();  
            //var_export($_FILES);    
            /**
             * If upload type is photo
             */
            if($caseType == 'photo') {
                $isUpload = true;
                $upload = caseHelper::getPhotoUploadObject();

                $fvalid = $upload->check();
                if($fvalid){
                    // Nothing still here
                } else {
                    //var_dump($upload->get_errors());
                    $vf->name('case-photo')->setError(implode('<b/>', $upload->get_errors()));
                }
                $fileinfo = $upload->get_state();
            }
            
            // IF VALID
            if($vf->isGroupValid()){                
                if($isUpload) {					
                    //FILE DATA
                    $fileData = array(
                        //'id' => 'int:10',
                        'name' => $fileinfo['filename'],
                        'orig_name' => $fileinfo['original_filename'],
                        'extension' => $fileinfo['extension'],
                        'user_id' => '1',
                        //'added' => 'timestamp',
                        //'folder' => $this->path,
                        'size' => $fileinfo['size_in_mb'].' mb',
                        'OK' => 'WSH', // Optional KEY 
                        //'comment' 
                    );	                
	                
                    // CREATE FILE MODEL OBJECT
                    $fModel = new FileModel();
                    $fileID = $fModel->createEntry($fileData);
	            unset($fileData);   
                    if($fileID) {
                        $upload->save();
                        unset($upload);
                    }                
                } else {
                    $fileID = 'null';
                }
                // Make the thumb
                if(is_numeric($fileID)) {
                    $tmp_fpath = UPLOAD_PRIVATE_PATH.DS."pht".DS;
                    $tmp_fname = $fileinfo['filename'].".".$fileinfo['extension'];
                    $origpath = $tmp_fpath.$tmp_fname;
                    $thumbpath = $tmp_fpath.'thmb'.DS."a".DS.$tmp_fname;
                    // *** 1) Initialise / load image
                    $resizeObj = new resize($origpath);
                    // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                    $resizeObj -> resizeImage(200, 160, 'auto');
                    $resizeObj -> saveImage($thumbpath, 90);
                    //echo "++++ test";                    
                    // Clear buffer
                    unset($tmp_fname,$tmp_fpath,$origpath,$thumbpath,$resizeObj);                    
	        }
                
                /**
                 * Finally create case data 
                */                
                $data = array(
                    'user_id' => $this->userData[0],
                    'category_id' => $vf->getValue('case-category'),
                    'privacy' => $vf->getValue('case-privacy'),
                    'title'  => $vf->getValue('case-title'),
                    'text' => $vf->getValue('case-text'),
                    'type' => $vf->getValue('case-type'),
                );                
                if($caseType=='photo') {
                    $data['file_id'] = $fileID;
                } else if($caseType=='link') {
                    $data['link'] = $vf->getValue('case-link');
                }                
                // IF expiring case
                if($caseEndDate!=null) {
                    $data['expire'] = $caseEndDate;
                }             
                $vf = null;
                unset($vf);               
                $entryID = $this->model->createEntry($data);
                if($entryID){                    
                    $message = SiteHelper::getAlert("File added successfully",'success');
                    //$vf = new ValidFluent(array());                    
					//es refrhs uketebs gverds, 'confirm form submussion' ro ar moitxovos xolme 
					//ok es gasagebia magram surilis cashla sad aris? linki ok 
                    header('Refresh: 0');
                    // redirect to /profile                    
                } else {
                    //var_export($this->model->getError());
                    $message = SiteHelper::getAlert("Technical problem",'danger');
                }                
            } else {
                //var_export($vf);
                $message = SiteHelper::getAlert("Error occurred!",'danger');
            }            
        }
        
        if(!isset($vf)){
            $vf = new ValidFluent(array());
        }        
        $this->data['message'] = &$message;
        $this->data['vf'] = &$vf;             
        $this->loadPage('profile/addcase');
       }
}