<?php
class AuthedPage extends Page {
    protected $requireAuth = true;
    protected $userData;
    
    function __construct() {
        if($this->requireAuth===true) {
            if(!User::isAuthed()) {
                $r = strtok($_SERVER['REQUEST_URI'],'?');
                PageFunctions::redirect(URL::getPath("login?r=".urlencode($r)));
            }
        }
        parent::__construct();        
        $this->userData = User::getUserData();//es unda gamovizaxo
    }
}