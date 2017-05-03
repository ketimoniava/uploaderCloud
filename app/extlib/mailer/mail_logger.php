<?php
function logger($message){
//echo '<pre>';    
if(is_object($message)):
$message = get_object_vars($message);
endif;
if(is_array($message)):
//print_r($message);
else:
$message;
endif;
//echo '<pre>';
}
			
?>