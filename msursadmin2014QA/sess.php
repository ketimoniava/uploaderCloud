<?php
session_start();
//$_SESSION['lang'] = "ge";
include("conns/connection.php");  
if(isset($_REQUEST["login"]))
{
	$result_get_site_info = mysql_query("SELECT * FROM `admin`",$con);
	if($result_get_site_info){ $myrow_result_get_site_info = mysql_fetch_array($result_get_site_info); }
   $user = $myrow_result_get_site_info['user'];                      
	$user_password = $myrow_result_get_site_info['user_password'];  
	$pass=md5(mysql_real_escape_string(stripslashes(trim(@$_POST['password']))));
	//echo  $_POST['password']; 
	if($_REQUEST['admin'] == $user && $pass== $user_password)
	{
		//echo "aasda";
		$_SESSION["isadmin"]=true;    
	}        
}
//if(isset($_REQUEST["logoff"])) $_SESSION["isadmin"]=false;
if(!$_SESSION["isadmin"])
{
	header("location:login.php");
	exit();
} 
?>