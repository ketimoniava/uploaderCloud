<?php
class HomePage extends Page {
    public function actionIndex() {
        if(User::isAuthed()){		
			$this->loadPage('home/loggedin');
        } else {
			$commdetail = SiteModel::getCommonMain(); 
			$this->data['CommonMain'] = $commdetail;     
			
			$one =6;
			$two = 7;
			$three = 8;
			$limit = 1; 

			$CommonMainOne = SiteModel::getCommonMainItems($one); 
			$this->data['CommonMainOne'] = $CommonMainOne; 
			$itemid1 = $this->data['CommonMainOne']["id"];
			$CommonMainOnePic = SiteModel::geItemPics($itemid1, $limit); 
			
			$this->data['CommonMainOnePic'] = $CommonMainOnePic; 

			$CommonMainTwo = SiteModel::getCommonMainItems($two); 
			$this->data['CommonMainTwo'] = $CommonMainTwo; 
			$itemid2 = $this->data['CommonMainTwo']["id"];
			$CommonMainTwoPic = SiteModel::geItemPics($itemid2, $limit); 
			$this->data['CommonMainTwoPic'] = $CommonMainTwoPic; 

			$CommonMainThree = SiteModel::getCommonMainItems($three); 					
			$this->data['CommonMainThree'] = $CommonMainThree; 
			$itemid3 = $this->data['CommonMainThree']["id"];
			$CommonMainThreePic = SiteModel::geItemPics($itemid3, $limit); 
			$this->data['CommonMainThreePic'] = $CommonMainThreePic; 

			$this->loadPage('home/index');
		}
    }
  
   public function actionContact(){
        $contacts = SiteModel::getContacts();    
        $this->data['contacts'] = $contacts;        
        $this->loadPage('home/contact');
    }

	public function actionCommon() {
		$categories = SiteModel::getCommonCats(); 
		$this->data['categories'] = $categories;     
		if(isset($_GET["comid"])): 
			$comid = @$_GET["comid"]; 
			$commdetail = SiteModel::getCommonDetail($comid); 
			$this->data['commdetail'] = $commdetail;     
		endif;	
		if(isset($_GET["catid"])): 
			$catid = @$_GET["catid"]; 
		endif;
		if(isset($this->data['commdetail']['categoryid'])):
			$catid =$this->data['commdetail']['categoryid'];
		endif;
		if(isset($catid)):
			$commlist = SiteModel::getCommonList($catid); 
			$this->data['commlist'] = $commlist;     
		endif;	
		$this->loadPage('home/common');
    }
    
   public function actionLogin(){        
      $message = '';
	  if(isset($_POST["submit_registration"])){
			$user = $_POST;
			if(User::regist($user) == true){
				//$message = "რეგისტრაციის დასასრულებლათ გთხოვთ მიუთითოთ თქვენს მობილურ ტელეფონზე/ელფოსტით მიღებული სმს კოდი";
				$message = "Please check your email to end signing up";
				$showsmsform = true;
			} else {
				$message = "Sign up don't made";	
				$errors =  User::regist($user) ;
				$this->data['errors'] = $errors->info;
				//$errors = $errors->info->error[0][0];
				/*$errornumber = $this->data['errors'] ->errornumber;
				if($errornumber>0)
				{
					echo "<ul class='error_list'>\n";
					for($i=0; $i<$errornumber; $i++)
					{
						$error =$this->data['errors']->error[$i];
						echo "<li>".$error."</li>\n";
					}
					echo "</ul><!--error_list-->\n";
				}//error number */				
			}			
		} else {
			$vf = new ValidFluent(array());
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$vf = new ValidFluent($_POST);
				$vf->name('g_user')->required();
				$vf->name('g_pass')->required();
				if($vf->isGroupValid()){
				$user = @$_POST['g_user'];
				$pass = @$_POST['g_pass'];                
				if(User::auth($user, $pass)){
					PageFunctions::redirect(URL::getPath("profile"));
					//header('Location:index.php?'.  urldecode(@$_GET[r]));
					die;
				}
			  }    
			  $message = "Username or password isn't right";
			}			
			$this->data['vf'] = $vf;        
		}//else regist
		$this->data['message'] = $message;
        $this->template = 'Simple';
        $this->loadPage('home/login');
    }
    
   public function actionLogout() {
       if(User::isAuthed()){
			session_destroy();
       }
       PageFunctions::redirect(BASE_NAME);
   }    
}