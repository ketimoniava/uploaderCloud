<?php
session_start();
include "../conns/connection.php";
include "imagesprocess/extend.php";
include "../functions/functions.php";
$clientip = showIP();

if(isset($_POST["fid"])&&isset($_POST["prod"]))
{
	$fid = stripslashes(trim($_POST["fid"]));	
	$prod = stripslashes(trim($_POST["prod"]));	
	$prodphotos = mysql_query("SELECT * FROM productsphotos WHERE id='".$fid."' ");
	$rowprodphotos = mysql_fetch_array($prodphotos); 
	$filename = $rowprodphotos["filename"];
	$deleterandfile = mysql_query("DELETE FROM productsphotos WHERE id='".$fid."' ");
	if($deleterandfile)
	{
		if(file_exists('../photos/products/small/'.$filename)){
			unlink('../photos/products/small/'.$filename);
		}
		if(file_exists('../photos/products/original/'.$filename)){
			unlink('../photos/products/original/'.$filename);
		}
		if(file_exists('../photos/products/medium/'.$filename)){
			unlink('../photos/products/medium/'.$filename);
		}
		$prodphotos = mysql_query("SELECT * FROM productsphotos WHERE prodID='".$prod."' ");
		if(mysql_num_rows($prodphotos)==0)
		{
			$result = "UPDATE products SET hasphoto='0' WHERE id='".$prod."' ";
			mysql_query($result,$con) or exit('Error: ' . mysql_error());
			echo "delete";
		}
	}//deleterandfile	
}//removefile
else
{
	$fid = stripslashes(trim($_POST["fid"]));	
	$prodphotos = mysql_query("SELECT * FROM randphotos WHERE id='".$fid."' ");
	$rowprodphotos = mysql_fetch_array($prodphotos); 
	$filename = $rowprodphotos["filename"];
	$deleterandfile = mysql_query("DELETE FROM randphotos WHERE id='".$fid."' ");
	if($deleterandfile)
	{
		if(file_exists('uploads/'.$filename)){
			unlink('uploads/'.$filename);
		}
	}
}

?>