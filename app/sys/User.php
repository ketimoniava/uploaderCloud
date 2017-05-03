<?php
class User {
    protected static $USER_RELATION_GUEST   = 1;
    //protected static $USER_RELATION_GUEST_AUTHED = 1;
    protected static $USER_RELATION_FRIEND  = 2;
    protected static $USER_RELATION_SELF    = 3;
    //private static $USER_RELATION_FRIENDOF = 4;
    
    /**
     * Calculate logged in user relation to $_GET user
    */
    public static function getRelation($user, $relative){
        if($user==$relative) {
           return self::$USER_RELATION_SELF;
        }        
        if(ProfileModel::areFriends($user, $relative)) {
            return self::$USER_RELATION_FRIEND;
        }
        // Friend of friend can be added later         
        return self::$USER_RELATION_GUEST;
    }
    /**
     * Get user data (if authed) from session
     * @return mixed <i>array</i> if user info exists <i>null</i> otherwise
   */
    public static function getUserData() {
         if(isset($_SESSION['AUTHED'],$_SESSION['USER_DATA'])) {
             return $_SESSION['USER_DATA'];
         }
         return null;
    }
    /**
     * Check if user authorized
     * @return boolean
     */
    public static function isAuthed() {
        if(isset($_SESSION['AUTHED'],$_SESSION['USER_DATA'])) {
            return true;
        } else {
            return false;
        }
    }
    
	/**
     * Authenticate user
     * @param string $user
     * @param string $pass
     * @return boolean
    */
    public static function auth($user,$pass) {
		$dbResult = UserModel::CheckUser($user,$pass);
		if(!$dbResult) : 
			return FALSE; 
		endif; 
		$_SESSION['AUTHED'] = 1;
		$_SESSION['USER_DATA'] = $dbResult;	
		return true;
    }
    
	public static function regist($user) {
		//$user["registusername"];
		echo $dbResult = UserModel::RegistUser($user);
		echo $resultcode = $dbResult->result;
		if($resultcode == 0) {
			return TRUE; 
		} else {
			return $dbResult;
		}
		/*if(!$dbResult) : 
			return FALSE; 
		endif; */
		//$_SESSION['AUTHED'] = 1;
		//$_SESSION['USER_DATA'] = $dbResult;	
		
    }

    /**
     * Log out user, redirect to main page
    */
    public static function logout() {
        $_SESSION['AUTHED'] = NULL;
        $_SESSION['USER_DATA'] = NULL;
        PageFunctions::redirect(BASE_NAME);
    }       
}
