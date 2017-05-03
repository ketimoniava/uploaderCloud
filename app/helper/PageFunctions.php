<?php

class PageFunctions {

    public static function show404() {
        include APP_PATH.DS."errors/404.php";
        die;
    }
    
    public static function redirect404() {
        header("Location:".BASE_NAME."/errors/404.php");
        die;
    }
    
    public static function redirect($path='/') {
        header("Location:$path");
        die;
    }
    
    /**
     * Check if current state equals debug state
     * @return type
     */
    public static function isDebug() {
        return CURRENT_STATE === STATE_DEBUG;
    }
    
    /**
     * Debug objects
     * @param mixed $data
     * @param boolean $return
     * @return string or void
     */
    public static function debug($data,$return=false) {
        $str = '<pre>'.var_export($data,true).'</pre>';
        if ($return) { 
            return $str; 
        }
        echo $str;
    }

    
    
}