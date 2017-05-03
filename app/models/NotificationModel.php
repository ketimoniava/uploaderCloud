<?php

class NotificationModel extends Model {

    public static $NTFTYPE_YOU_ADDED_WISH               = 1 ;
    public static $NTFTYPE_YOUR_WISH_SELECTED           = 2 ;
    public static $NTFTYPE_YOUR_WISH_EXPIRES            = 3 ;
    public static $NTFTYPE_YOUR_WISH_EXPIRED            = 4 ;
    public static $NTFTYPE_YOUR_FRIEND_ADDED_WISH       = 5 ;
    public static $NTFTYPE_FRIENDSHIP_REQUESTED         = 6 ;
    public static $NTFTYPE_FRIENDSHIP_ACCEPTED          = 7 ; 
    public static $NTFTYPE_YOUR_SELECTED_WISH_EXPIRES   = 8 ;
    public static $NTFTYPE_YOUR_SELECTED_WISH_EXPIRED   = 9 ; 
    
    public static $messages = array(
        1 => 'თქვენ დაამატეთ სურვილი' ,
        2 => 'მეგობარმა თქვენი სურვილი მონიშნა' ,
        3 => 'თქვენს სურვილს ვადა გასდის' ,
        4 => 'თქვენს სურვილს ვადა ამოეწურა' ,
        5 => 'თქვენმა მეგობარმა დაამატა სურვილი' ,
        6 => 'თქვენ გაქვთ მეგობრობაზე მოთხოვნა' ,
        7 => 'თქვენს მეგობრობას დათანხმდნენ' ,
        8 => 'თქვენს მიერ მონიშნულ სურვილს ვადა გასდის' ,
        9 => 'თქვენს მიერ მონიშნულ სურვილს ვადა გაუვიდა' ,
    );

    protected $table = "user_notifications";

    protected $fields = array(
 	 'id'           => 'int:10', 
	 'type_id'      => 'tinyint:3',
	 'user_id'      => 'int:10', 	
	 'body'         => 'text',
	 'created'	=> 'timestamp',
	 'seen'         => 'timestamp',
	 'link'         => 'varchar:120',
	 'from_user_id'	=> 'int:10',
	 'wish_id'	=> 'int:10',
	 'data'         => 'varchar:120' // თავისუფალი ველი. რასაც გინდა ჩაწერ
    );

    /**
     * Get notifications for user
     * @param int $user_id
     * @param boolean $onlyNew
     * @return array
     */
    public static function getUserNotifications($user_id, $onlyNew = true) {
        $user_id = intval($user_id);
        $statements = "
            AND nt.user_id = $user_id  
        ";
        
        if($onlyNew == true) {
            $statements .= " AND nt.seen IS NULL ";
        }
        
        return static::getAll($statements);
    }

    
    /**
     * აქ განახლდება შეტყობინებების ნახვის თარიღი
     * თავიდან არის ნულლ ტიპის რაც ნიშნავს რომ შეტყობინება ახალია
     * 
     * @param int $user_id მომხმარებელი ვისი შეტყობინებებიც ნახლდება
     * @param int $notifId თუ ნოთიფიკაციის იდ არის, მაშინ 1 კონკრეტული განახლდება
     * @return int განახლებული შეტყობინებების რაოდენობა
     */
    public static function userSawNtfs($user_id, $notifId = null) {
        $notifId = intval($notifId);
        if($notifId) {
            $notifSQL = " AND id = $notifId ";
        } else {
            $notifSQL = "";
        }
        
        $statement = DB::getInstance()->prepare("
            UPDATE user_notifications
            SET seen = NOW()
            WHERE 
                    user_id = :uid
                AND seen IS NULL
                $notifSQL
        ");
        $statement->bindParam(':uid', $user_id, PDO::PARAM_INT);
        $statement->execute();        
        
        return $statement->rowCount();
    }
    
    /**
     * მომხმარებლის შეტყობინებების წაშლა.
     * ახლა არის ასე: იშლება მხოლოდ ის რომელიც ამ მომხმარებელს უჩანდა
     * ასევე შესაძლებელია წაიშალოს სრულად ანუ + ისინიც, 
     * რომლებიც ამ მომხმარებელმა გამოიწვია, მაგ: მონიშნა სურვილი, 
     * ამისათვის პარამეტრი $fullDelete უნდა იყოს true
     * 
     * @param int $user_id მომხმარებელი ვისი შეტყობინებებიც იშლება
     * @param boolean $fullDelete ასევე წაიშალოს შეტყობინებები,
     *          ამ მომხმარებლით გამოწვეული
     * @return int წაშლილი შეტყობინებების რაოდენობა
     */
    public static function deleteUserNtfs($user_id, $fullDelete = false) {
        
        $user_id = intval($user_id);
        if($fullDelete == true) {
            $fromUserSql = " OR from_user_id = $user_id ";
        } else {
            $fromUserSql = "";
        }
        
        $statement = DB::getInstance()->prepare("
            DELETE FROM user_notifications
            WHERE 
                user_id = :uid
                $fromUserSql
        ");
        $statement->bindParam(':uid', $user_id, PDO::PARAM_INT);
        $statement->execute();        
        
        return $statement->rowCount();
    }
    
    
    /**
     * სურვილის შეტყობინებების წაშლა.
     * 
     * @param int $wishId სურვილი რომლის შეტყობინებებიც უნდა წაიშალოს
     * @return int წაშლილი შეტყობინებების რაოდენობა
     */
    public static function deleteWishNtfs($wishId) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM user_notifications
            WHERE wish_id = :wid
        ");
        $statement->bindParam(':wid', $wishId, PDO::PARAM_INT);
        $statement->execute();        
        
        return $statement->rowCount();
    }
    
    
    /**
     * სურვილის შეტყობინებების წაშლა.
     * 
     * @param int $wishId სურვილი რომლის შეტყობინებებიც უნდა წაიშალოს
     * @return int წაშლილი შეტყობინებების რაოდენობა
     */
    public static function deleteWishFulfilNtfs($wishId) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM user_notifications
            WHERE wish_id = :wid AND type_id = :tid
        ");
        $statement->bindParam(':wid', $wishId, PDO::PARAM_INT);
        $statement->bindParam(':tid', self::$NTFTYPE_YOUR_WISH_SELECTED, PDO::PARAM_INT);
        $statement->execute();        
        
        return $statement->rowCount();
    }
    
    
    
    /**
     * მეგობრობის შეტყობინების წაშლა
     * 
     */
    public static function deleteFriendshipNtfs($user, $friend) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM user_notifications
            WHERE 
                (user_id = :uid AND from_user_id = :fid)
                OR
                (user_id = :fid AND from_user_id = :uid)
                AND 
                type_id in ("
                    .self::$NTFTYPE_FRIENDSHIP_REQUESTED.","
                    .self::$NTFTYPE_FRIENDSHIP_ACCEPTED.","
                    .self::$NTFTYPE_YOUR_FRIEND_ADDED_WISH."
                )
        ");
        $statement->bindParam(':uid', $user,   PDO::PARAM_INT);
        $statement->bindParam(':fid', $friend, PDO::PARAM_INT);
        $statement->execute();        
        
        return $statement->rowCount();
    }

    
    

    /**
     * ეს არის საერთო ქვერი შეტყობინებების, 
     * რომელსაც გადაეცემა სტეიტმენტები (ფილტრაციები)
     * 
     * @param string $statements
     * @return mixed მასივი თუ მოიძებნა, ან ცარიელი
     */
    private static function getAll($statements = '') {
                
        $statement = DB::getInstance()->prepare("
            SELECT 
                nt.*
                ,
                p.display_name AS from_user_name
                ,
                CONCAT(f.name,'.',f.extension) as avatar
            FROM  user_notifications AS nt
            LEFT JOIN user_profile p
                ON nt.from_user_id = p.user_id
            LEFT JOIN file f 
                ON p.file_id = f.id
            WHERE 1 = 1 
                $statements
            ORDER BY nt.created DESC
        ");
        
        $statement->execute();        
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /**
     * აქ გადმოეცემა ნოთიფიკაციის მასივი,
     * რაც უნდა ჩაიწეროს ბაზაში
     * @param array $data
     * @return int ნოთიფიკაციის id
     */
    private static function createNtf(&$data) {
        $ntfId = self::getThis()->createEntry($data);
        return $ntfId;
    }

    
    /**
     * როცა მომხმარებელი ამატებს სურვილს უვარდება შეტყობინება,
     * რომ მან ეს ახლახან გააკეთა
     * 
     * @param int $userId მომხარებლის id ვინც ქნა ეს
     * @param int $wishId სურვილის id რის გამოც იქმნება ამხელა ალიაქოთი
     * @return int აბრუნებს შეტყობინების id-ს
     */
    public static function ntfYouAddedWish($userId, $wishId) {
        $userId = intval($userId);
        
        $message = self::$messages[self::$NTFTYPE_YOU_ADDED_WISH];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => static::$NTFTYPE_YOU_ADDED_WISH,
            'user_id'       => $userId, 	
            'body'          => $message,
            //'link'         => '',
            'from_user_id'  => $userId,
            'wish_id'       => intval($wishId)
        );
        
        return self::createNtf($data);
    }
     
    
    /**
     * სურვილის მონიშვნისას, სურვილის ავტორს მიუვიდეს შეტყობინება
     * 
     * @param int $userId მომხმარებელი ვისაც ეკუთვნის სურვილი
     * @param int $wishId სურვილის id, რომელიც მოინიშნა
     * @param int $selectedBy მომხმარებელი ვინც მონიშნა სურვილი
     * @return int შეტყობინების id
     */
    public static function ntfYourWishSelected($userId, $wishId, $selectedBy, $showIdentity = false) {
        $message = self::$messages[self::$NTFTYPE_YOUR_WISH_SELECTED];
        
        $data = array(
            'type_id'      => static::$NTFTYPE_YOUR_WISH_SELECTED,
            'user_id'      => intval($userId), 	
            'body'         => $message,
            //'link'         => '',
            'from_user_id' => intval($selectedBy),
            'wish_id'	   => intval($wishId)
        );
        
        if($showIdentity == true) {
            $data['data'] = '1';
        }
        
        return self::createNtf($data);
    }
    
    
    
    /**
     * როცა შენს სურვილს ვადა გასდის, მოგივა შეტყობინება, არ იდარდო!
     * 
     * @param int $userId მომხმარებელი ვისაც ეკუთვნის სურვილი
     * @param int $wishId სურვილის id, რომელსაც ვადა გასდის
     * @return int შეტყობინების id
     */
    public static function ntfYourWishExpires($userId, $wishId) {
        $userId = intval($userId);
        $message = self::$messages[self::$NTFTYPE_YOUR_WISH_EXPIRES];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_YOUR_WISH_EXPIRES,
            'user_id'       => $userId, 	
            'body'          => $message,
            //'link'         => '',
            'from_user_id'  => $userId,
            'wish_id'       => intval($wishId)
        );
        
        return self::createNtf($data);
    }
    
    
    /**
     * როცა შენს სურვილს ვადა გაუვა, მოგივა შეტყობინება, 
     * არ იდარდო თუ აგისრულეს, თუ არა და აბა შენ იცი!
     * 
     * @param int $userId მომხმარებელი ვისაც ეკუთვნის სურვილი
     * @param int $wishId სურვილის id, რომელსაც ვადა გაუვა
     * @return int შეტყობინების id
     */
    public static function ntfYourWishExpired($userId, $wishId) {
        $userId = intval($userId);
        $message = self::$messages[self::$NTFTYPE_YOUR_WISH_EXPIRES];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_YOUR_WISH_EXPIRES,
            'user_id'       => $userId, 	
            'body'          => $message,
            //'link'         => '',
            'from_user_id'  => $userId,
            'wish_id'       => intval($wishId)
        );
        
        return self::createNtf($data);
    }
    
    
    
    
    /**
     * როცა შენს მიერ მონიშნულ სურვილს ვადა გასდის, მოგივა შეტყობინება, 
     * იდარდე (დროზე უნდა აასრულო)!
     * 
     * @param int $yourId მომხმარებელი ვისაც აქვს სურვილი მონანიშნი
     * @param int $wishId სურვილის id, რომელსაც ვადა გასდის
     * @return int შეტყობინების id
     */
    public static function ntfYourSelectedWishExpires($yourId, $wishId) {
        $yourId = intval($yourId);
        $message = self::$messages[self::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRES];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRES,
            'user_id'       => $yourId, 	
            'body'          => $message,
            //'link'         => '',
            //'from_user_id'  => $userId,
            'wish_id'       => intval($wishId)
        );
        
        return self::createNtf($data);
    }
    
   
    /**
     * როცა შენს მიერ მონიშნულ სურვილს ვადა გაუვა, მოგივა შეტყობინება, 
     * გაგიხარდეს (ან შეასრულე: სიკეთით ხარ სავსე, 
     * თუ ვერა და წარსულს ვეღარ მიეწევი)!
     * 
     * @param int $yourId მომხმარებელი ვისაც აქვს სურვილი მონანიშნი
     * @param int $wishId სურვილის id, რომელსაც ვადა გაუვიდა
     * @return int შეტყობინების id
     */
    public static function ntfYourSelectedWishExpired($yourId, $wishId) {
        $yourId = intval($yourId);
        $message = self::$messages[self::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRED];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRED,
            'user_id'       => $yourId, 	
            'body'          => $message,
            //'link'         => '',
            //'from_user_id'  => $userId,
            'wish_id'       => intval($wishId)
        );
        
        return self::createNtf($data);
    }
    

    
    
    /**
     * შენი რჩეული მეგობრები ამატებენ სურვილს და შენ მოგდის შეტყობინება
     * ამ ბედნიერი ამბის შესახებ
     * 
     * @param int $userId მომხმარებელი ვისაც მისდის შეტყობინება
     * @param int $wishId სურვილის id, რომელიც დაემატა
     * @param int $friendId სურვილის ავტორი
     * @return int შეტყობინების id
     */
    public static function ntfYourFriendAddedWish($userId, $wishId, $friendId) {
        $message = self::$messages[self::$NTFTYPE_YOUR_FRIEND_ADDED_WISH];
        
        $data = array(
            'type_id'      => static::$NTFTYPE_YOUR_FRIEND_ADDED_WISH,
            'user_id'      => intval($userId), 	
            'body'         => $message,
            //'link'         => '',
            'from_user_id' => intval($friendId),
            'wish_id'	   => intval($wishId)
        );
        
        return self::createNtf($data);
    }    
    
    
    
        
   
    /**
     * როცა ერთი ამატებს მეორეს მეგობრად, მეორეს მისდის შეტყობინება
     * 
     * @param int $userId მომხმარებელი ვისაც გაუგზავნეს მეგობრობის სურვილი
     * @param int $friendId ვინც აგზავნის მეგობრობის მოთხოვნას
     * @return int შეტყობინების id
     */
    public static function ntfFriendshipRequested($userId, $friendId) {
        $userId = intval($userId);
        
        $message = self::$messages[self::$NTFTYPE_FRIENDSHIP_REQUESTED];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_FRIENDSHIP_REQUESTED,
            'user_id'       => $userId, 	
            'body'          => $message,
            'from_user_id'  => intval($friendId),
        );
        
        return self::createNtf($data);
    }
    
	/*public static function ntfFriendshipRequested($userId, $friendId) {
        $userId = intval($userId);
        
        $message = self::$messages[self::$NTFTYPE_FRIENDSHIP_REQUESTED];
        $data = array(
            //'id'           => 'int:10', 
            'type_id'       => self::$NTFTYPE_FRIENDSHIP_REQUESTED,
            'user_id'       => $userId, 	
            'body'          => $message,
            'from_user_id'  => intval($friendId),
        );
        
        return self::createNtf($data);
    }*/
   
    /**
     * როცა ერთი ადასტურებს მეორეს მეგობრად, მეორეს მისდის შეტყობინება
     * 
     * @param int $approvedId მომხმარებელი ვის მეგობრობასაც დაეთანხმა
     * @param int $approverId მეგობარი ვინც დაეთანხმა
     * @return int შეტყობინების id
     */
    public static function ntfFriendshipAccepted($approvedId, $approverId) {
        $message = self::$messages[self::$NTFTYPE_FRIENDSHIP_ACCEPTED];
        $data = array(
            'type_id'       => self::$NTFTYPE_FRIENDSHIP_ACCEPTED,
            'user_id'       => intval($approvedId), 	
            'body'          => $message,
            'from_user_id'       => intval($approverId)
        );
        
        return self::createNtf($data);
    }
    
    
    /**
     * ეს არის დროებითი ობიექტი სტატიკური ფუნქციებისთვის, 
     * ბაზაში მონაცემების ჩასაწერად
     * 
     * @var NotificationModel
     */
    private static $thisObject;
    
    /**
     * ქმნის და ახალ ობიექტს თუ არ არის უკვე შექმნილი
     * 
     * @return \NotificationModel 
     */
    private static function getThis() {
        if(!self::$thisObject) {
            self::$thisObject = new NotificationModel(); 
        }
        
        return self::$thisObject;
    }
    
}