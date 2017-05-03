<?php
/**
 * Here to limit acces for only ajax calls
 */
class AjaxPageBase extends AuthedPage {

    function __construct() {
        
        //echo $_SERVER['HTTP_REFERER'];
        
        // INSTEAD OF REDIRECT TO LOGIN PAGE, SHOW 404
        if(!User::isAuthed()) {
            PageFunctions::show404();
        }
        
        // SHOW 404 IF NOT AJAX CALL
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
            || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) 
            !== 'xmlhttprequest') {
            PageFunctions::show404();
        }
        
        parent::__construct();
    }

}