<?php

class AjaxResponse {

    public static $RESULT_SUCCESS  = 'success';
    public static $RESULT_FAILED   = 'failed';
    public static $RESULT_ERROR    = 'error';
    
    public static $DATA_TYPE_JSON  = 'JSON';
    public static $DATA_TYPE_HTML  = 'HTML';
    public static $DATA_TYPE_DEBUG = 'DEBUG';


    public $result;
    public $message;
    public $data;
    public $code;
            
    function __construct() {
        
    }
    
    /**
     * Print result to user
     * @param type $dataType
     * @return type
     * @throws Exception
     */
    public function printResult($dataType='JSON') {
        switch ($dataType) {
            case self::$DATA_TYPE_JSON:
                echo $this->getJSON();
                break;
            case self::$DATA_TYPE_HTML:
                echo $this->getHTML();
                break;
            case self::$DATA_TYPE_DEBUG: 
                echo $this->debug();
                break;
            default :
                throw new Exception('Invalid dataType: '.$dataType);
        }
    }
    
    /**
     * Get JSON string
     * @return string
     */
    public function getJSON() {
        return json_encode(array(
            'result' => $this->result,
            'message'=> $this->message,
            'data'   => $this->data,
            'code'   => $this->code
        ));
    }

    /**
     * Wrap data into div, ignore rest vars
     * @return type
     */
    public function getHTML() {
        return "<div class='ajaxResponseWrapper'>"
             .$this->data
             . "</div>";
    }
    
    /**
     * Get response wrapped into pre tag
     * @return string
     */
    public function debug() {
        return '<pre>'
            .var_export(array(
                'result' => $this->result,
                'message'=> $this->message,
                'data'   => $this->data,
                'code'   => $this->code
            ), TRUE)
        .'</pre>';
    }
    
}
