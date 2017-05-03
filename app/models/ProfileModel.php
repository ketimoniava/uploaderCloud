<?php
class ProfileModel extends Model {
    protected $table = "user_profile";	
    /**
     * Get user profile data
     * @param int $profileID user id
     * @return array
     */    
    public static function getProfile($profileID) {
        /*$sth = DB::getInstance()->prepare("
            SELECT * 
            FROM user_profile
            WHERE user_id = :pid
        ");
        $sth->bindParam(':pid',$profileID,PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);*/
		$userid = (int)$profileID;	
		$algo = 'sha256';
		$userid = (int)$profileID;
		$data = "usercheck".$userid;
		//$raw_output = false;
		//$profileID;
		$hashcode = hash($algo, $data, false);
		$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$userid.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		//print_r($url);
		// get first book title
		$resultcode = $xml->result;
		$login_user = array();
		if($resultcode == 0)
		{
			/*
			$user_id = (string)$xml->info->u_id;
			$username = (string) $xml->info->username;
			$first_name = (string)$xml->info->first_name;
			$last_name = (string)$xml->info->last_name;
			$email = (string)$xml->info->email;
			$profilepic = (string)$xml->info->profilepic;
			$password = (string)$xml->info->password;
			*/
			$login_user[] = (string)$xml->info->u_id;
			$login_user[] = (string)$xml->info->username;
			$login_user[] = (string)$xml->info->first_name;
			$login_user[] = (string)$xml->info->last_name;
			$login_user[] = (string)$xml->info->birthday;
			$login_user[] = (string)$xml->info->birthmonth;
			$login_user[] = (string)$xml->info->birthyear;
			$login_user[] = (string)$xml->info->mobile;
			$login_user[] = (string)$xml->info->email;
			$login_user[] = (string)$xml->info->profilepic;
			$login_user[] = (string)$xml->info->password;
		}
		return $login_user;
    }
    
    /**
     * მეგობრად დამატება, პირველი ეტაპი
     * @param type $userId
     * @param type $friendId
     * @return int
    */
    public static function addFriend($userId, $friendId) {
        $sth = DB::getInstance()->prepare("
            INSERT INTO friend_request 
                (user, friend_id) 
            VALUES
                (LEAST(:us, :fr), GREATEST(:us, :fr))
        ");         
        $sth->bindParam(':us', $userId,  PDO::PARAM_INT);
        $sth->bindParam(':fr', $friendId, PDO::PARAM_INT);
        $sth->execute();        
        if(!$sth->rowCount()) {
            return FALSE;
        }        
        NotificationModel::ntfFriendshipRequested($friendId, $userId);        
        return TRUE;        
    }

	public static function hasRequest($user, $friend) {
	$sth = DB::getInstance()->prepare("
		SELECT * FROM friend_request 
		WHERE 
			user = LEAST(:us, :fr)
		AND 
			friend_id = GREATEST(:us, :fr)
	");        
	$sth->bindParam(':us', $user,   PDO::PARAM_INT);
	$sth->bindParam(':fr', $friend, PDO::PARAM_INT);
	$sth->execute();
	return $sth->rowCount();
    }

    /**
     * მოთხოვნის წაშლა
    */
    public static function deleteRequest($user, $friend) {
		//echo $friend;
        $sth = DB::getInstance()->prepare("
            DELETE FROM friend_request 
            WHERE 
              user = LEAST(:us, :fr)
            AND 
              friend_id= GREATEST(:us, :fr)
        ");        
        $sth->bindParam(':us', $user,   PDO::PARAM_INT);
        $sth->bindParam(':fr', $friend,  PDO::PARAM_INT);
        $sth->execute();
        //return $sth->rowCount();
		 if(!$sth->rowCount()) {
            return FALSE;
        }        
        return TRUE;       
    }
    
    /**
     * მეგობრობაზე თანხმობა
     * @return int -1 თუ მოთხოვნა არ არსებობდა, 0 შეცდომა, 1 წარმატება
    */
    public static function acceptFriend($user, $friend) {
        $res = self::deleteRequest($user, $friend);
        if(!$res) return -1;     
        $sth = DB::getInstance()->prepare("
            INSERT INTO friend 
              (user_id,friend_id) 
            VALUES
              (LEAST(:us, :fr), GREATEST(:us, :fr))
        "); 
        $sth->bindParam(':us', $user,   PDO::PARAM_INT);
        $sth->bindParam(':fr', $friend, PDO::PARAM_INT);
        $sth->execute();
        $res = $sth->rowCount();
        if($res) {
            NotificationModel::ntfFriendshipAccepted($friend, $user);
        }        
        return $res;
    }

    /**
     * მეგობრობაზე უარის თქმა
    */
    public static function rejectFriend($user, $friendId) {
        return self::deleteRequest($user, $friendId);
    }

    /**
     * megobrobis gauqmeba, nu es igive gamovida 
    */
    public static function cancelFriend($user, $friendId) {
        return self::deleteRequest($user, $friendId);
    }

    /**
     * მეგობრის წაშლა
    */
    public static function removeFriend($user, $friend) {
		/* WHERE 
                user_id = LEAST(:us, :fr)
            AND 
                friend_id = GREATEST(:us, :fr)
		*/
        $sth = DB::getInstance()->prepare(" 
            DELETE FROM friend 
            WHERE 
                user_id IN (:us, :fr)
            AND 
                friend_id IN (:us, :fr)
        ");         
        $sth->bindParam(':us', $user,   PDO::PARAM_INT);
        $sth->bindParam(':fr', $friend, PDO::PARAM_INT);
        $sth->execute();
        $res = $sth->rowCount();        
        // მეგობრობაზე არსებული შეტყობინებების წაშლა მომხმარებლებს შორის
        if($res) {
            //echo ' waiSala: '.NotificationModel::deleteFriendshipNtfs($user, $friend);
        }
        return $res;
    }
    /**
     * მომხმარებლების ძიება კონკრეტული მომხმარებლის მიმართ.
     * თუ უბრალოდ გინდა მოძებნო მაშინ მომხმარებელში შეგიძია მიუთითო -1
     * @param int $user ვის მეგობრებსაც ვეძებთ
     * @param string $friend_name და რასაც ვეძებთ
     * @return array
    */
    public static function findFriendByName($user, $friend_name) {
        //return array();        
        if(!$friend_name) return array();        
        $friend_name = str_replace(array('%','_'), array('\%','\_'), $friend_name);
        //echo $friend_name;
        $sth = DB::getInstance()->prepare("
		 SELECT 
			us.*
			,                   
			(SELECT 
				1  
			FROM 
				friend
			WHERE user_id = LEAST(:user, us.id)
				AND 
					friend_id = GREATEST(:user, us.id)
			) AS isfriend
			FROM 
				users AS `us`
			WHERE
				us.id != :user 
				AND (
				`us`.`fullName` LIKE CONCAT('%',:frnm,'%')
				OR
				`us`.`mail` = :frnm
				)  
        ");        
        //echo $friend_name;        
        $sth->bindParam(':user', $user, PDO::PARAM_INT);
        $sth->bindValue(':frnm', $friend_name, PDO::PARAM_STR);
        $sth->execute();        
        //echo $sth->queryString;
        //var_export($sth->errorInfo());
        return $sth->fetchAll(PDO::FETCH_ASSOC);        
    }

	public static function findFriend($user, $friend_name) {  
        if(!$friend_name) return array();        
        //echo $friend_name = str_replace(array('%','_'), array('\%','\_'), $friend_name);        
		$algo = 'sha256';
		//echo $friend_name;
		$data = "user".$user."friend_name".$friend_name;
		$hashcode = hash($algo, $data, false);
		$url = 'http://service.ge/xml_moduls/finduser.php?cat=findfriend&friend_name='.$friend_name.'&user='.$user.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		//print_r($url);
        //$sth->bindParam(':user', $user, PDO::PARAM_INT);
        //$sth->bindValue(':frnm', $friend_name, PDO::PARAM_STR);
        //$sth->execute();        
        //return $sth->fetchAll(PDO::FETCH_ASSOC);    
		return $xml->info;
    }

	public static function getFriends($whose) {  
		//echo $whose;
		//მეგობრების წამოღება
		/*$sth = DB::getInstance()->prepare("
			SELECT 
				CASE WHEN friend_id = :whose THEN user_id ELSE friend_id END id
				FROM friend WHERE user_id = :whose OR friend_id = :whose
		");*/
		/*SELECT 
		   friend_id
		   CONCAT(friend_id,','userid,') as result
		   FROM ()
		*/
		//მეგობრების წამოღება გაერთიანებით CONCAT
	   $sth = DB::getInstance()->prepare("
	   SELECT 					
		CASE WHEN friend_id = :whose THEN user_id ELSE friend_id END id
		FROM friend WHERE user_id = :whose OR friend_id = :whose				
		");
		$sth->bindParam(':whose', $whose, PDO::PARAM_INT);
		$sth->execute(); 
		//$sth->fetch(PDO::FETCH_ASSOC);
		//დააბრუნებს ყველა იმ მეგობრის იდს ვინც მოიძებნა
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		//echo count($result);
		//print_r($result);
		$least = "";
		foreach($result as $row) :
			$friendid = $row["id"];
			//echo print_r($row);
			if($least == "")
			{ 
				$least = $least.$friendid;
			} else { $least = $least.",".$friendid; }
		endforeach;
		//echo $least;
		$algo = 'sha256';
		$data = "least".$least;
		$hashcode = hash($algo, $data, false);
		$url = 'http://service.ge/xml_moduls/finduser.php?cat=findfriend&least='.$least.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		//print_r($xml);
		return $xml->info;
		//return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
        
    /**
     * Check if users are friends
     * @param int $aUserID user id
     * @param int $bUserID user id
     * @return boolean
    */    
    public static function areFriends($aUserID, $bUserID) {        
		//echo $aUserID;
        $sth = DB::getInstance()->prepare("
			SELECT 1	FROM friend WHERE user_id IN (:aUser, :bUser) 
			AND friend_id IN (:aUser, :bUser)
        ");        
		$aUserID = (int)$aUserID;
		$bUserID = (int)$bUserID;
        $sth->bindParam(':aUser', $aUserID, PDO::PARAM_INT);
        $sth->bindParam(':bUser',$bUserID, PDO::PARAM_INT);
        $sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$result = count($result);
        return $result;
		//count($resultcount);
    }
   
    /**
     * მომხმარებლის მეგობრების სია
     * @param type $whose
     * @return type
    */
   /*$forUser=0*/
	/*public static function getFriends($whose, ) {        
        $sth = DB::getInstance()->prepare("
			SELECT 
				fr.*
				,
				p.display_name
			   ,
			   CONCAT(f.name,'.',f.extension) as avatar
			FROM (
				SELECT 
					CASE WHEN friend_id = :whose
						THEN user_id
						ELSE friend_id
					END id
				FROM friend
				WHERE 
				   user_id     = :whose
				 OR
				   friend_id   = :whose
			) fr                
			LEFT JOIN user_profile p 
				ON fr.id = p.user_id
			LEFT JOIN file f 
				ON p.file_id = f.id            
        ");        
        $sth->bindParam(':whose', $whose, PDO::PARAM_INT);
        //$sth->bindParam(':forUser', $forUser, PDO::PARAM_INT);
        $sth->execute();            
        if(PageFunctions::isDebug()) {
				PageFunctions::debug('Get user friends for '.$whose);
				PageFunctions::debug('QUERY: '.$sth->queryString);
				//PageFunctions::debug('DATA: ');
				//PageFunctions::debug($data);
				PageFunctions::debug('ERROR: '.$sth->errorCode());
				PageFunctions::debug($sth->errorInfo());
				PageFunctions::debug('Rows: '.$sth->rowCount());
				//PageFunctions::debug('ID: '.$id);
        } 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }*/    
    
    
}