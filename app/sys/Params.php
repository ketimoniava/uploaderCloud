<?php

/**
 * Description of Params
 *
 * @author George Garchagudashvili 
 */
class Params {
    private $data;    
    /**
    * Initialize params object with data (string or array)
    * @param type $params
    * @return type
    */
    public function __construct($params=null) {
        if($params===null) :
            return;
        endif;
        if (!is_array($params)) :
            return $this->parseFromQS($params);
        endif;
        $this->data = $params;
    }
    
    /**
     * Parse from QUERY_STRING
     * @param string $str
    */
    public function parseFromQS($str) {
        $this->data = parse_str($str);
    }

    /**
     * Get parameter
     * @param string $name
     * @return object
    */
    public function __get($name) {
        if(isset( $this->data[$name])) : 
            return $this->data[$name];
        endif;
        return null;
    }
    
    /**
     * Set the value of parameter
     * @param string $name parameter name
     * @param object $value parameter value
    */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    
   /**
     * Get element by numeric key, or index
     * @param int $i index of element
     * @return object
   */
   public function getItemByIndex($i) {
        if(isset($this->data[$i])) :
            return $this->data[$i];
        elseif($i<$this->count()) : 
            $keys = array_keys($this->data);
            if(isset($keys[$i])) :
                return $this->data[$keys[$i]];
            endif;
        endif; 
        return null;
   }
    
   /**
     * Get parameter by key
     * @param object $key
     * @return object
   */

    public function getItemByKey($key) {
        return isset($this->data[$key])?$this->data[$key]:null;
    }

    /**
     * Count data items
     * @param mixed $mode int 0,1 or string: COUNT_NORMAL, COUNT_RECURSIVE
     * @return int
    */

    public function count($mode=0) {
        return count($this->data, $mode);
    }
    
}
