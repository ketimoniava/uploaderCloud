<?php

/**
 * Data container
 */
class SimpleObject {
    private $data;
    
    /**
     * Initialize object
     * @param array $data
     */
    function __construct($data=array()) {
        $this->data = $data;
    }

    /**
     * Store data
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $this->data[$key] = $value;
    }
 
    /**
     * Get data
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if(isset($this->data[$name])) :
            return $this->data[$name];
        endif;
        return NULL;
    }

    /**
     * Get all data
     * @return array
     */
    public function getAll() {
        return $this->data;
    }
    
}