<?php
/**
 * შეცდომების ჩვენება სრულად, როცა ტესტავ მხოლოდ მაშინ.
 */
error_reporting(E_ALL);
ini_set('display_errors', 9999);
date_default_timezone_set("Asia/Tbilisi");
session_start();
define('WEB_ROOT', dirname(__FILE__));
define('BASE_NAME','/');

/**
 * მიმდინარე გარემო STATE_PRODUCT = 0 ამ შემთხვევაში 
 * არ გამოიტანს შეცდომებს და სატესტო ინფორმაციას   
 * ავტომატურად არის STATE_DEBUG = 1 როცა ტესტავ
 */ 
define('CURRENT_STATE', 0);
/**
 * როცა სადმე გინდა აპლიკაციის ნაწილი ან მთლიანად გამოიყენო 
 * ამ ფაილს დააინკლუდებ WEB_ROOT და 
 * BASE_NAME უნდა იყოს განსაზღვრული, 
 * ფაილების შემოსატანად არის საჭირო
 */
include 'app/app.php';

/**
 * ანუ თუ ვთქვათ msurs/ ფოლდერში გექნება ეს აპლიკაცია გაშვებული
 * მაშინ REQUEST_URI-დან უნდა ამოვიღოთ რომ რაც დარჩება ის გავპარსოთ
 * ანუ BASE_NAME რაც იქნება იმას მოაშორებს დასაწყისში,
 * მაგ: msurs/profile/findfriends/ გახდება profile/findfriends/
 **/

$request = strtok($_SERVER['REQUEST_URI'],'?');
if(BASE_NAME && strpos($request, BASE_NAME)==0) :
	$request = substr($request, strlen(BASE_NAME));
endif;
    
  /**
  * მე URL Rewrite მაქვს გამოყენებული, და ეს გვერდი არის უბრალოდ მაგალითი
  * ეს როგორც საიტი მთლიანად ისეა, შენ შეგიძლია თითოეული 
  * გვერდის ობიექტი შენით შექმნა და გამოიძახო შესაბამისი ფუნქციები
  */  
   
// EXAMINE REQUEST_URI
$urldata = explode('/', trim($request,'/'));
// REMOVE EMPTY VALUES
$urldata = array_filter($urldata);    

// DETECT PAGE
if(isset($urldata[0]) and $urldata[0] !=$defaultPage){
    $tmpPage = ucfirst($urldata[0]);
    
    // IF NOT CLASS FOUND, $urldata[0] will be examined for action name
	if(file_exists(APP_PATH.DS."pages/{$tmpPage}Page.php")) {
	//if($tmpPage) {
        //PageFunctions::show404(); // Show page not found
        $page = $tmpPage;
        array_shift($urldata);
    } else {
        $page = $defaultPage;
    }
    unset($tmpPage);
} else {
    $page = $defaultPage;
}
// ADD NAME 'Page'
define('CURRENT_PAGE', $page);  // STORE FOR LATER USE
$page = ucfirst($page).'Page';
        
// CHECK IF PAGE EXISTS
//if(!file_exists("pages/$page.php")) {
// PageFunctions::show404(); // Show page not found
//}
/**
 * აქ განიხილება კლასის რომელი ფუნქციაა გამოძახებული
 */ 
// DETECT ACTION
if(isset($urldata[0]) and $urldata[0] !=$defaultAction){
    $action = $urldata[0];
    array_shift($urldata);
} else {
    $action = $defaultAction;
}

define('CURRENT_ACTION', $action); // STORE FOR LATER USE

// CHECK IF METHOD EXISTS
$action = "action".ucfirst($action);
/*if(!method_exists($pageObject,$action)) {
    PageFunctions::show404();
}*/

$params = null;
$ignore = false;

if(!is_callable(array($page, $action))) {
    if($ignore == false) {
    	//PageFunctions::show404();
    }
}

// CHECK IF ADDITIONAL, UNNESSESARY PARAMS ARE PROVIDED
if(count($urldata)>0) {
	/*foreach ($urldata as $urlinfo)
	{
		$urlinfo;
	}*/
    //PageFunctions::show404();
}
//echo $action;
unset($urldata, $request);
// CREATE PAGE OBJECT
$pageObject = new $page();
$pageObject->$action();

?>

      
