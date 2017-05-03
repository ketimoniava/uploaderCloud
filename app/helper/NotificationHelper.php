<?php

/**
 * შეტყობინებებისთვის დამხმარე კლასი
 */
class NotificationHelper {

    /**
     * შეატყობინე მომხმარებელს მისი სურვილზე ვადის გასვლის თაობაზე <br />
     * და ასევე ამსრულებელს, თუ აქვს ვინმეს მონიშნული იმ შემთხვევაში.
     *
     * შეტყობინება მიდის საიტზეც და ფოსტაზეც
     *
     * ეს მუშაობს ორივე შემთხვევაში ვადა რომ გასდის და ასევე ვადა რომ გაუვიდა
     * თუ $expired = false მაშინ მიდის 'ვადა გასდის მალე' ტიპის შეტყობინება 
     * თუ $expired = true  მაშინ იგზავნება 'ვადა გაუვიდა' ტიპის შეტყობინება
     * 
     * @param string $date თარიღი, როცა სურვილს გასდის ვადა,
     * ანუ შენ თვითონ წყვეთ რომელი თარიღია ვადა გასული დღევანდელი 
     * თუ წინა დღის.
     * 
     * @param boolean $expired თუ ჭეშმარიტია გაიგზავნება
     * უკვე ვადა გასულის შეტყობინებები
     */
    public static function warnWishExpire($date, $expired = false) {
        $expWishes = WishModel::getExpWishes($date);

        
        if($expired !== true) {
            $selfNtfType = NotificationModel::$NTFTYPE_YOUR_WISH_EXPIRES;
            $fulfNtfType = NotificationModel::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRES;
        } else {
            $selfNtfType = NotificationModel::$NTFTYPE_YOUR_WISH_EXPIRED;
            $fulfNtfType = NotificationModel::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRED; 
        }
        
        
        foreach($expWishes as $expWish) {
            // Add notification to database
            NotificationModel::ntfYourWishExpires(
                    $expWish['user_id'],
                    $expWish['id']
                    );

            // Send mail
            $message = NotificationModel::$messages[$selfNtfType];
            EmailNotifications::sendNotification($expWish['uMail'], $message);


            /**
             * ამსრულებლის მაილი, ანუ თუ არის 
             * სურვილი მონიშნული იმ შემთხვევაში
             */
            if(isset($expWish['fuMail'])) { 
                NotificationModel::ntfYourSelectedWishExpires(
                        $expWish['fulfilled_by'],
                        $expWish['id']
                        );
                // Send mail
                $message = NotificationModel::$messages[$fulfNtfType];
                EmailNotifications::sendNotification($expWish['fuMail'], $message);
            } // end fulfuler block


        }

    }


    /**
     * შეტყობინების html კოდის გენერირება
     * @param array $notification
     * @return string
     * @throws Exception თუ ნოთიფიკაციის ტიპი განუსაზღვრელია
     */
    public static function getNotificationHTML($notification) {
        switch ($notification['type_id']) {
            case NotificationModel::$NTFTYPE_YOU_ADDED_WISH:
                return self::youAddedWishHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_WISH_SELECTED:
                return self::yourWishSelectedHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_FRIEND_ADDED_WISH:
                return self::yourFriendAddedWishHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_WISH_EXPIRES:
                return self::yourWishExpiresHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_WISH_EXPIRED:
                return self::yourWishExpiredHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRES:
                return self::yourSelectedWishExpiresHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_YOUR_SELECTED_WISH_EXPIRED:
                return self::yourSelectedWishExpiredHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_FRIENDSHIP_REQUESTED:
                return self::friendshipRequestedHTML($notification);
                break;
            case NotificationModel::$NTFTYPE_FRIENDSHIP_ACCEPTED:
                return self::friendshipAcceptedHTML($notification);
                break;
            default :
                throw new Exception("Undefined notification type id ($notification[type_id])");
        }
    }


    /**
     * შემომსასღვრელი ტაგი შეტყობინების
     * @param string $content
     * @return string
     */
    private static function HTMLWrapper($content) {
        return "<div class='ntf-item'>"
                . "$content"
                . "</div>";
    }


    /**
     * თქვენ დაამატეთ სურვილი
     */
    public static function youAddedWishHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]</p>";
        return self::HTMLWrapper($str);
    }

    /**
     * თქვენი სურვილი მონიშნეს
     */
    public static function yourWishSelectedHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        // თუ არ არის დამალული ამსრულებლის ვინაობა
        if($notification['data'] == 1) {
            $str .= " მეგობარი: $notification[from_user_name]";
        }
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }

    /**
     * ეს არის რჩეული მეგობრების დამატებული სურვილები
     * TODO: რჩეული მეგობრების ფუნქციონალი დასამატებელია
     */
    public static function yourFriendAddedWishHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        $str .= " მეგობარი: $notification[from_user_name]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }
    
    /**
     * თქვენს სურვილს ვადა გასდის
     */
    public static function yourWishExpiresHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }

    /**
     * თქვენს სურვილს ვადა გაუვიდა
     */
    public static function yourWishExpiredHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }

    /**
     * თქვენს მიერ მონიშნულ სურვილს ვადა გასდის
     */
    public static function yourSelectedWishExpiresHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }
    
    /**
     * თქვენს მიერ მონიშნულ სურვილს ვადა გაუვიდა
     */
    public static function yourSelectedWishExpiredHTML($notification) {
        $str = "<p>$notification[body]. სურვილის id: $notification[wish_id]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }

    
    /**
     * მოთხოვნა მეგობრობაზე
     */
    public static function friendshipRequestedHTML($notification) {
        $acceptKey = URL::generateKey(array($notification['from_user_id'], 'accept'));
        $rejectKey = URL::generateKey(array($notification['from_user_id'], 'reject'));
        
        $str = "<p>$notification[body].";
        $str .= " მეგობარი: $notification[from_user_name]";
        $str .= " <br /> <button onclick=\"acceptFriend($notification[from_user_id],'$acceptKey'); return false;\">დათანხმება</button>";
        $str .= " <button onclick=\"rejectFriend($notification[from_user_id],'$rejectKey'); return false;\">უარყოფა</button>";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }
    
    
    /**
     * დათანხმება მეგობრობაზე
     */
    public static function friendshipAcceptedHTML($notification) {
        $str = "<p>sd $notification[body].";
        $str .= " მეგობარი: $notification[from_user_name]";
        $str .= "</p>";
        return self::HTMLWrapper($str);
    }

}