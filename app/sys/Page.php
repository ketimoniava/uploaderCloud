<?php
class Page {
    /**
     * Database communication 
     * @var object 
    */
    protected $model;
    /**
     * Layout name
     * @var string
    */
    protected $template = 'simple';
    /**
     * For storage page content data
     * @var array
    */
    protected $data;  
    /**
     * Initialize page object
    */
    function __construct() {
        // Add default params 
        $this->data = array(
            'title' => 'Msurs.ge'
        );
    }

    /**
     * Load layout + view
     * @param string $view view to load inside layout
    */
	// echo $view;
    protected function loadPage($view) {
	//echo $view;
       if($this->template == '') {
           $this->loadView($view);
           return;
       }		
       include APP_PATH.DS."views".DS.$this->template.".php";
    }
    
   /**
    * Load view 
    * @param stirng $view
   */
   protected function loadView($view) {
	   //echo $view;
		$view = str_replace('/', DS, $view);
        include APP_PATH.DS."views".DS.$view.".php";      
   }		
}