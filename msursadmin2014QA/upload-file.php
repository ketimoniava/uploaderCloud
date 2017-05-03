<?php
session_start();
include "../conns/connection.php";
include "imagesprocess/extend.php";
include "../functions/functions.php";
$clientip = showIP();
if(isset($_GET["upload"]))
{

	$uploaddir = './uploads/'; 
	$file = $uploaddir . basename($_FILES['uploadfile']['name']); 
	$file_type = $_FILES['uploadfile']['type']; 
	$file_size = $_FILES['uploadfile']['size'];
	$filename = basename($_FILES['uploadfile']['name']);	
	$imgtrue = false;

		/*echo "error file size > 5 MB";		
		$lastproid = mysql_query("SELECT * FROM products ORDER BY id DESC LIMIT 1");
		$rowlastproid = mysql_fetch_array($lastproid); 
		$lastproid = $rowlastproid["id"];
		$deleterandfile = mysql_query("DELETE FROM randphotos WHERE randid='".$lastproid."' ");
		unlink($_FILES['uploadfile']['tmp_name']);
		exit;*/

	    if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){
              $imgtrue = 1;
           }elseif($file_type == "image/x-png" || $file_type == "image/png"){
              $imgtrue = 1;
           }elseif($file_type == "image/gif"){
              $imgtrue = 1;
           }
		/*$fileInfo = extend($filename);
		$fileExt = $fileInfo[1];
		$rand_name = md5(time());
		$rand_name = rand(0,999999999);
		$phototitle = $rand_name;
		$randfilename = $phototitle.".".$fileExt;
		$uploadfile = $uploaddir."/".$phototitle.".".$fileExt;*/
		//if($imgtrue == 1)
		//{
		if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
			//echo "success"; 		
			$lastproid = mysql_query("SELECT * FROM products ORDER BY id DESC LIMIT 1");
			$rowlastproid = mysql_fetch_array($lastproid); 
			$lastproid = $rowlastproid["id"];
			$sql = "INSERT INTO randphotos (filename, randid, clientip) VALUES ('".$filename."','".$lastproid."', '".$clientip."')";
			mysql_query($sql, $con) or exit ('error'.mysql_error());
		} else {
			echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
		}
		//}//imgtrue
	//}
}

if(isset($_POST["removefile"]))
{
	$filename = stripslashes(trim($_POST["removefile"]));	
	$lastproid = mysql_query("SELECT * FROM products ORDER BY id DESC LIMIT 1");
	$rowlastproid = mysql_fetch_array($lastproid); 
	$proid = $rowlastproid["id"];
	$deleterandfile = mysql_query("DELETE FROM randphotos WHERE filename='".$filename."' AND randid='".$lastproid."' AND clientip='".$clientip."' ");
	if($deleterandfile)
	{
		if(file_exists('uploads/'.$filename)){
			unlink('uploads/'.$filename);
		}
	}	
}



?>