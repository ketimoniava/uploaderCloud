<?php
// WEB_ROOT უნდა იყოს განსაზღვრული
if(!defined('WEB_ROOT')) { 
	throw new Exception('WEB_ROOT not defined');
}
// BASE_NAME უნდა იყოს განსაზღვრული
if(!defined('BASE_NAME')) { 
	throw new Exception('BASE_NAME not defined');
}

define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', dirname(__FILE__));

define('STATE_PRODUCT', 0);
define('STATE_DEBUG', 1);

if(!defined('CURRENT_STATE')) {
	define('CURRENT_STATE',STATE_DEBUG);
}

include 'AutoLoader.php';

/**
 * ავტო-ჩამომტვირთველისთვის კლასების საძიებო ფოლდერების მითითება,
 * ანუ სად შეიძლება იყოს მოთხოვნილი კლასი შენახული, რომელ საქაღალდეში
 */ 

AutoLoader::addPath(APP_PATH.DS."sys".DS);
AutoLoader::addPath(APP_PATH.DS."models".DS);
AutoLoader::addPath(APP_PATH.DS."pages". DS);
AutoLoader::addPath(APP_PATH.DS."extlib".DS);
AutoLoader::addPath(APP_PATH.DS."helper".DS);

// კონფიგურაფიის ფაილი, ამ ფოლდერს ავტოლოადერში არ ვამატებთ
include 'config/main.php'; 