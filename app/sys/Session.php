<?php

/**
 * Manage data for session.
 * all data is stored in $_SESSION['d'] variable
 */
class Session {

    /**
     * Store data to session
     * @param mixed $k
     * @param mixed $v
     */
    public static function set($k, $v) {
        $_SESSION['d'][$k] = $v;
    }
    
    /**
     * Check if key exists
     * @param mixed $k
     * @return boolean
     */
    public static function has($k) {
        return isset($_SESSION['d'][$k]);
    }
    
    /**
     * Get value for key
     * @param mixed $k
     * @return mixed
     */
    public static function get($k) {
        return $_SESSION['d'][$k];
    }
    
    /**
     * Remove session data variable
     * @param mixed $k key to remove data
     */
    public static function x($k) {
        if(self::has($k)) {
            unset($_SESSION['d'][$k]);
        }
    }

    /**
     * Clear session data
     */
    public static function xAll() {
        $_SESSION['d'] = null;
    }
    
    /**
     * Get item if exists, or return default value.
     * Also data is removed from session and returned to user
     * @param mixed $k key to manipulate
     * @param mixed $def if no key exists this will be returned
     * @return mixed
    */
    public static function getBlindAndX($k, $def = null) {
        if(!self::has($k)) {
            return $def;
        }
        
        $tmp = self::get($k);
        self::x($k);
        return $tmp;
    }
    
    /**
     * Get all stored data by script
     * @return type
     */
    public static function getAll(){
        return $_SESSION['d'];
    }
    
}