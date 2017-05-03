<?php
class WishModel extends Model {
    protected $table = 'wish';
    protected $table_comment = 'wish_comment';
    protected $table_profile = 'user_profile';
    
    protected $fields = array(
        'user_id'  => 'int:10',
        'file_id' => 'int:12',
        'added' => 'timestamp',
        'expire' => 'date',
        'category_id'=>'int:11',
        'privacy' => 'int:3',
        'type' => 'int:3',
        'text' => 'text',
        'richtext' => 'text',
        'link' => 'text'
    );
    
    /**
     * მოხდა მშობელი კლასის მეთოდის გადაწერა, შეტყობინების გაგზავნის მიზნით
     * 
     * TODO: აქვე შეისაძლებელია მოხდეს რჩეული მეგობრებისთვის შეტყობინებების გაგზავნა
    */
    public function createEntry(&$data) {
        $id = parent::createEntry($data);
        if($id) {
            NotificationModel::ntfYouAddedWish($data['user_id'], $id);
        }
        return $id;
    }

    /**
     * წაიშალოს სურვილის ნახვის უფლებების სია 
     * TODO: შემდეგში შეიძლება გადაკეთება რომ ან მომხმარებელზე წაშალო, 
     * ან სურვილზე (როგორც ახლა არის)
     * @param int $wishID
     * @return int
    */
    public static function deleteWishAccessList($wishID) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM wish_access_list
            WHERE wish_id = :wid
        ");        
        $statement->bindParam(':wid' , $wishID, PDO::PARAM_INT);       
        $statement->execute();
        return $statement->rowCount();
    }
    
    /**
     * Get user's wish
     * @param int $viewerUserID who is seeing wishes
     * @return type
    */
    public static function getWish($wid, $viewerUserID) {
        $wid = intval($wid);
        $statement = " W.id = $wid "; 
		$slimit = 0;
		$nlimit = 1;
        $res = self::getWishes($viewerUserID, $statement, $slimit, $nlimit);
        if($res) {
            return $res[0];
        }
        return $res;
    }
    
    /**
     * გამოიტანს სურვილებს მითითებული თარიღის მიხედვით.
     * არ აქვს ხედვაზე შეზღუდვა, არის მხოლოდ სისტემისთვის
     * 
     * @param string $date ვადის ამოწურვის დრო
     * @return mixed სურვილების მასივი ან ცარიელი თუ ვერაფერი მოიძებნა
    */
    public static function getExpWishes($date) {
        $statement = DB::getInstance()->prepare("
            SELECT 
                  W.*  , u.mail AS uMail , u.`fullName` AS uName
                , fu.mail AS fuMail
                , fu.`fullName` AS fuName
            FROM wish W
            LEFT JOIN `users` AS u
                ON u.id = W.user_id
            LEFT JOIN `users` AS fu
                ON W.fulfilled_by = fu.id
            WHERE W.expire IS NOT NULL
                AND W.expire = $d
            ORDER BY W.added DESC
       ");        
       $statement->execute();  
       return $statement->fetchAll(PDO::FETCH_ASSOC);
    }    
    
    /**
     * Get wishes
     * @param int $viewerUserID who is seeing wishes
     * @param string $statements ex: W.id = 12, W.user_id in (2,3,..)
     * @return type
    */
    protected static function getWishes($viewerUserID = null, $statements = "", $group_number) {        
        $where = array();          
		$nlimit = 4;
		$items_per_group = 4;
		//echo $group_number;
		$slimit = ($group_number * $nlimit);
		$statements = trim($statements);
        if($statements) {
            //$statements .= "\n\t\t AND ";
            $where[] = $statements;
        }        
        if($viewerUserID == null) {
            $oldEvents = '';
        } else {
            $viewerUserID = intval($viewerUserID);            
            //$where[] = $privacySTR;            
            $oldEvents = " OR W.user_id = $viewerUserID ";
        }        
		$privacySTR = "(
		   (
				W.user_id = :vUser OR ( ( SELECT 1 FROM friend WHERE user_id = LEAST(W.user_id, :vUser) AND friend_id = GREATEST(W.user_id, :vUser))   
				AND
				#Include only wishes which :vUser can see 
				(W.privacy = 2 OR (W.privacy = 9 AND (SELECT 1 FROM wish_access_list WHERE wish_id = W.id AND user_id = :vUser LIMIT 1))
				) AND 
				#Also exclude inactive wishes 
				( W.expire IS NULL OR W.expire >= CURRENT_DATE() $oldEvents )
				#if owner show old events too, else dont show
			) ) )  
		   #and main `AND` clause
		 ";      
		//print_r($privacySTR);
        if($viewerUserID == null) {            
        } else {
            $where[] = $privacySTR;
        }        
        $where = implode(' AND ', $where);
        if($where) {
            $where = " WHERE $where";
        }        
        $statement = DB::getInstance()->prepare("
            SELECT W.* , u_p.display_name, CONCAT (fl.name,'.',fl.extension) as file_name  FROM wish W 
			LEFT JOIN user_profile AS u_p ON W.fulfilled_by = u_p.user_id LEFT JOIN file AS fl ON fl.id = W.file_id $where ORDER BY W.added DESC LIMIT $slimit, $nlimit
        ");         
		//$statement->bindParam(':wid' , $wid);
		$statement->bindParam(':vUser', $viewerUserID);
		/*$statement->bindParam(':slimit', $slimit);
		$statement->bindParam(':nlimit', $nlimit);*/
		$statement->bindParam(':slimit', $slimit);
		$statement->bindParam(':nlimit', $nlimit);
		$statement->execute();       
        if(PageFunctions::isDebug()) {
            PageFunctions::debug('WishModel. getWishes() Line: '.__LINE__);
            PageFunctions::debug($statement->queryString);
            if(intval($statement->errorCode())!=0) {
            PageFunctions::debug($statement->errorInfo());
            }
            PageFunctions::debug('Args:');
            PageFunctions::debug(func_get_args());
        }        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

	public static function getWishesTotal($viewerUserID = null, $statements = "") {        
        $where = array();               
		$statements = trim($statements);
        if($statements) {
            //$statements .= "\n\t\t AND ";
            $where[] = $statements;
        }        
        if($viewerUserID == null) {
            $oldEvents = '';
        } else {
            $viewerUserID = intval($viewerUserID);            
            //$where[] = $privacySTR;            
            $oldEvents = " OR W.user_id = $viewerUserID ";
        }        
		$privacySTR = "(
		   (
				W.user_id = :vUser OR ( ( SELECT 1 FROM friend WHERE user_id = LEAST(W.user_id, :vUser) AND friend_id = GREATEST(W.user_id, :vUser))   
			   AND
			   #Include only wishes which :vUser can see 
			   (W.privacy = 2 OR (W.privacy = 9 AND (SELECT 1 FROM wish_access_list WHERE wish_id = W.id AND user_id = :vUser LIMIT 1))
			   ) AND 
			   #Also exclude inactive wishes 
			   (W.expire IS NULL OR W.expire >= CURRENT_DATE() $oldEvents )
			   #if owner show old events too, else dont show
			) ) )  
		   #and main `AND` clause
		 ";      
		 //print_r($privacySTR );
        if($viewerUserID == null) {            
        } else {
            $where[] = $privacySTR;
        }        
        $where = implode(' AND ', $where);
        if($where) {
            $where = " WHERE $where";
        }        
        $statement = DB::getInstance()->prepare("
            SELECT W.* , u_p.display_name , CONCAT (fl.name,'.',fl.extension) as file_name  FROM wish W 
			LEFT JOIN user_profile AS u_p ON W.fulfilled_by = u_p.user_id LEFT JOIN file AS fl ON fl.id = W.file_id $where ORDER BY W.added DESC 
        ");  
        
        //$statement->bindParam(':wid'    , $wid);
        $statement->bindParam(':vUser', $viewerUserID);
		$statement->bindParam(':slimit', $slimit);
		$statement->bindParam(':nlimit', $nlimit);
        $statement->execute();       
        //echo count($statement);    
        if(PageFunctions::isDebug()) {
            PageFunctions::debug('WishModel. getWishes() Line: '.__LINE__);
            PageFunctions::debug($statement->queryString);
            if(intval($statement->errorCode())!=0) {
                PageFunctions::debug($statement->errorInfo());
            }
            PageFunctions::debug('Args:');
            PageFunctions::debug(func_get_args());
        }        
		$totalresult = $statement->fetchAll(PDO::FETCH_ASSOC);
		$sum = count($totalresult);
        return $sum;
    }
    
    public static function getWishComments($wid) {        
        $statement = DB::getInstance()->prepare("
        SELECT * FROM wish_comment WHERE wish_id='".$wid."' ORDER BY created DESC              
        ");        
        /*$statement = DB::getInstance()->prepare("
            SELECT 
                a.*
				,
                p.display_name
                ,
                CONCAT(f.name,'.',f.extension) as avatar
            FROM wish_comment a
            LEFT JOIN user_profile p
                USING(user_id)
            LEFT JOIN file f 
                ON p.file_id = f.id
            WHERE wish_id = :wid 
            ORDER BY a.created
        ");*/
        //echo $wid;
        $statement->bindParam(':wid', $wid);
        $statement->execute();        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Get user's wishes
     * @param int $userID whos wishes need to load
     * @param int $viewerUserID who is seeing wishes
     * @return type
    */
    public function getUserWishes($userID, $viewerUserID=null, $slimit) {
        $userID = intval($userID);
        $statement = " W.user_id = $userID "; 
       $res = self::getWishes($viewerUserID, $statement, $slimit);      
        return $res;
    }
    
	 public function getUserWishes1($userID, $viewerUserID=null, $group_no) {
		$userID = intval($userID);
		$statement = " W.user_id = $userID "; 
		$res = self::getWishes($viewerUserID, $statement, $group_no);      
		return $res;
    }

	 public function getUserWishesTotal($userID, $viewerUserID=null) {
        $userID = intval($userID);
        $statement = " W.user_id = $userID "; 
        $res = self::getWishes($viewerUserID, $statement);      
        return $res;
    }
    /**
     * Get user'sfriends' wishes
     * @param int $userID whose friends wishes need to load
     * @return array
    */
    public static function getUserFriendsWishes($userID, $includeSelf = true, $slimit, $nlimit) {
        $userID = intval($userID);
        //echo "text";
        if($includeSelf) {
            $selfSQL = " W.user_id = $userID OR ";
        } else {
            $selfSQL = "";
        }        
        $freidnsSQl = "
				($selfSQL W.user_id IN ( #Get friends' id-s
                SELECT CASE WHEN friend_id = $userID THEN user_id ELSE friend_id END id FROM friend WHERE user_id = $userID OR friend_id   = $userID))
        ";
        $res = self::getWishes($userID, $freidnsSQl, $slimit, $nlimit);
		return $res;        
    }   
	

    /**
     * Get categories: system + user defined categories
     * @param int $userID
     * @param boolean $only
     * @return array
    */
    public static function getCategories($userID = 0, $only = false, $catid = 0) {
		if($only == true) {
			$str = '';
		} else {
			$str = " OR a.user_id = -1";
		}

		$catid = intval($catid);
		if($catid) {
			$str = " AND a.id = $catid";
		}

        $statement = DB::getInstance()->prepare("
            SELECT *
            FROM wish_category a
            WHERE a.user_id = :user_id
			$str
            ORDER BY a.user_id,a.name
        ");        
        $statement->bindParam(':user_id', $userID);
        $statement->execute();        

		if($catid) {
				return $statement->fetch(PDO::FETCH_ASSOC);
		}

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }   
    

    /**
	 * add user categories
     */ 
    public static function addCategory($userID = 0, $category) {
        $statement = DB::getInstance()->prepare("
			INSERT INTO wish_category
				(name, user_id)
			VALUES (:n, :user_id)
        ");       
		$statement->bindParam(':n', $category);
        $statement->bindParam(':user_id', $userID);
        $statement->execute();        
        return $statement->rowCount();
    }   


	/**
	 * edit user categories
     */ 
    public static function editCategory($userID = 0, $category, $catid) {
        $statement = DB::getInstance()->prepare("
			UPDATE wish_category
				SET name = :n
			WHERE user_id = :u_id
					AND id = :c_id
        ");       
		$statement->bindParam(':n', $category);
        $statement->bindParam(':u_id', $userID);
		$statement->bindParam(':c_id', $catid);
        $statement->execute();        
        return $statement->rowCount();
    }   
    

	/**
	 * delete user categories
     */ 
    public static function deleteCategory($userID = 0, $catid) {
        $statement = DB::getInstance()->prepare("
			DELETE FROM wish_category
			WHERE user_id = :u_id
					AND id = :c_id
        ");       
        $statement->bindParam(':u_id', $userID);
		$statement->bindParam(':c_id', $catid);
        $statement->execute();        
        return $statement->rowCount();
    }   


    public static function fulfil($wishID, $userID, $showFF=0) {
        $statement = DB::getInstance()->prepare("
            UPDATE wish
            SET fulfilled_by = :uid ,
                fulfil_select_date = NOW(),
                show_to_owner = :showFF
            WHERE 
                id = :wid 
             AND
                fulfilled_by IS null
        ");        
        $statement->bindParam(':uid',    $userID, PDO::PARAM_INT);
        $statement->bindParam(':wid',    $wishID, PDO::PARAM_INT);
        $statement->bindParam(':showFF', $showFF, PDO::PARAM_INT);
        $statement->execute();    
        if(PageFunctions::isDebug()) {
            PageFunctions::debug('WishModel. Line: '.__LINE__);
            PageFunctions::debug($statement->queryString);
            if(intval($statement->errorCode())!=0) {
                PageFunctions::debug($statement->errorInfo());
            }
            PageFunctions::debug('Args:');
            PageFunctions::debug(func_get_args());
        }
        return $statement->rowCount();      
    }    
    
    public static function unFulfil($wishID, $userID) {
        $statement = DB::getInstance()->prepare("
            UPDATE wish
                SET fulfilled_by = NULL ,
				fulfil_select_date = NULL ,
				show_to_owner = NULL
            WHERE 
             id = :wid 
            AND
             fulfilled_by = :uid
        ");        
        $statement->bindParam(':uid', $userID, PDO::PARAM_INT);
        $statement->bindParam(':wid', $wishID, PDO::PARAM_INT);
        $statement->execute();        
        return $statement->rowCount();      
    }

    public static function getPrivacies() {
        return array(
            1 => 'ყველა' , 
            3 => 'მე' ,
            2 => 'მეგობრები' , 
            9 => 'სია'
        );
    }
   

	/**
	 * edit wish privacy
     */ 
    public static function changePrivacy($userID, $wish_id, $privacy) {
        $statement = DB::getInstance()->prepare("
			UPDATE wish
				SET privacy = :p
			WHERE user_id = :u_id
					AND id = :w_id
        ");       
		$statement->bindParam(':p', $privacy);
        $statement->bindParam(':u_id', $userID);
		$statement->bindParam(':w_id', $wish_id);
        $statement->execute();        
        return $statement->rowCount();
    }   




}
