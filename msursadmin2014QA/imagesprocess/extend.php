<?php

function extend ($file_name){
	$getExt = explode ('.',$file_name); 
	$fileExt = $getExt[count($getExt)-1];
	$fileName = "";
	for($i=0; $i<count($getExt)-1; $i++){
		if($i){ $fileChar = "."; }else{ $fileChar = ""; }
		$fileName = $fileName.$fileChar.$getExt[$i]; 
	}
	return array ($fileName,$getExt[count($getExt)-1]);
}

?>