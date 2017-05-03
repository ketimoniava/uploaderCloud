<?php
/**
 * Create PDO object with connection string
 */
class DB {
    private static $lastConnection = null;
    
    private function __construct() {
        // no direct instance from here
    }
    
    /**
     * Get instance of db connection
     * @return \PDO
     */
    public static function getInstance() {
        if(!self::$lastConnection instanceof PDO) {
            self::$lastConnection = new PDO(MAIN_DB_DSN,MAIN_DB_USER,MAIN_DB_PASS);
        }
        
        return self::$lastConnection;
    }
    
}