<?php

/**
 * ფოსტის გასაგზავნი კლასი
 * 
 * TODO: დასამთავრებელია send მეთოდი
 */
class EmailNotifications {
    
    /**
     * ფოსტის გაგზავნა 
     * 
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    protected static function send($to, $subject, $message) {
        return true;
    } 

    /**
     * შეტყობინების გაგზავნა
     * 
     * @param string $to
     * @param string $message
     * @return boolean
     */
    public static function sendNotification($to, $message) {
        return self::send($to, 'შეტყობინება msurs.ge-დან', $message);
    }

    
}