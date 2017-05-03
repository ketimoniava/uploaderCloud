<?php
class URL extends Helper {    
    public static function getPath($page) {
        $page = ltrim($page, '/');
        $pre = BASE_NAME;
        if($pre == '/') {
            $pre = '';
        }
        return $pre."/".$page;
    }
    
    public static function buildQS($urlData, $generateHash = true) {
        if($generateHash == true) {
            $u_key = URL::generateKey($urlData);
            echo $urlData['u_key'] = $u_key;
        }
        return http_build_query($urlData);
    }
    
    
    /**
     * Generate hash from $params array values
    */
    public static function generateKey($params, $suffix = '_x!.9', $addSessionID = true) {
        if($addSessionID) {
            $params[] = session_id();
        }
        
        $params = array_map(function($value) use ($suffix) {
            return $value.$suffix;
        }, $params);
        return hash('md5', implode('-',$params));
    }
    
}