<?php

class AdminPage extends AuthedPage {

    function __construct() {
        
        $this->template = 'adminSimple';
        parent::__construct();
    }

}