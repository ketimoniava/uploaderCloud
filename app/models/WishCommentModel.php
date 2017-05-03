<?php

class WishCommentModel extends Model {
    
    protected $table = "wish_comment";
    
    protected $fields = array(
                'id'   => 'int:10',
                'wish_id'   => 'int:10',
                'body'   => 'text',
                'created'   => 'timestamp',
                'user_id'   => 'int:10',
              );
    
    /**
     * Delete user comment
     * @param type $commentID
     * @param type $userID
     * @return type
     */
    public static function deleteComment($commentID, $userID) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM wish_comment
            WHERE   
                    id      = :cid
                AND 
                    user_id = :uid
        ");
        
        $statement->bindParam(':cid' , $commentID, PDO::PARAM_INT);
        $statement->bindParam(':uid' , $userID, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
    
    
    /**
     * კონკრეტული სურვილის ყველა კომენტარის წაშლა
     * 
     * @param int $wishID სურვილი რომლის კომენტარებიც უნდა წაიშალოს
     * @param int $userID ასევე მომხმარებელი,
     *  რომელსაც ეკუთვნის ეს სურვილი და კომენტარი
     * @return int
     */
    public static function deleteWishComments($wishID, $userID) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM wish_comment
            WHERE   
                    wish_id = :wid
                AND 
                    user_id = :uid
        ");
        
        $statement->bindParam(':wid' , $wishID, PDO::PARAM_INT);
        $statement->bindParam(':uid' , $userID, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
    
    /**
     * კონკრეტული მომხმარებლის ყველა კომენტარის წაშლა
     * 
     * @param int $userID მომხმარებლის იდ რომლის კომენტარებსაც ვშლით
     * @return int რამდენი ჩანაწერიც წაიშალა
     */
    public static function deleteUserComments($userID) {
        $statement = DB::getInstance()->prepare("
            DELETE FROM wish_comment
            WHERE user_id = :uid
        ");
        
        $statement->bindParam(':uid' , $userID, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
    
    
}   


