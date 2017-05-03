<?php
$sign = isset($_GET['sign'])?$_GET['sign']:"";
if($sign == "1")
{
    session_start(); 
    session_destroy();
    //unset($_SESSION["isadmin"]);
    header("Location: login.php"); 
    exit();  
}                     
include("sess.php");
//include "../mailer/mail_logger.php";
//include "../mailer/class.phpmailer.php";
//include("webservice.php");
//include "../functions/functions.php";
//$clientip = showIP();
//echo "index.php hehehehe";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">                    
      td#is {background-color: #f2f3f3;}
      table#t1{border: 10px solid #DFEAEA;} 
</style>
<link type="text/css" media="all" rel="stylesheet" href="styles/layout.css" />
<script type="text/javascript" src="jquery/jquery-1.10.2.js"></script>
<script type="text/javascript" src="jquery/jquery-1.10.2.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
</head>

<body>
<div class='page-wrapper'>	
	<?php 
	include "conns/connection.php";
	if($_SESSION["isadmin"]==true)
	{
		include("main.php");
	}
	?>
	<div class="footer">
	<p class='rights'>&copy; Quantum group</p>
	</div><!--footer-->
</div>

</body>
</html>