<?php
echo  "<div class='site_params'>\n";
include("../conns/connection.php");
echo "<h1>უსაფრთხოების პარამეტრები</h1>\n";
if(isset($_GET["state"]))
{
	$state=mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	switch($state){
		case "username":
			include "username.php";
		break;
		case "pass":
			include "password.php";
		break;
		case "desc":
			include "desc.php";
		break;	
		case "keys":
			include "keys.php";
		break;
	}
}
else
{
	echo "<ul class='update_list'>\n";
	echo "<li><h2><a href='?admin=configuration&amp;state=username'>username</a></h2><span> <a href='?admin=configuration&amp;state=username'>[update]</a></span></li>\n";
	echo "<li><h2><a href='?admin=configuration&amp;state=pass'>password</a></h2><span><a href='?admin=configuration&amp;state=pass'>[update]</a></span></li>\n";
	echo "<li><h2><a href='?admin=configuration&amp;state=desc'>site description</a></h2><span><a href='?admin=configuration&amp;state=desc'>[update]</a></span></li>\n";
	echo "<li><h2><a href='?admin=configuration&amp;state=keys'>key words</a></h2><span><a href='?admin=configuration&amp;state=keys'>[update]</a></span></li>\n";
	echo "</ul><!--update_list-->\n";
	$result_get_site_info = mysql_query("SELECT * FROM `admin`",$con);
	$myrow_result_get_site_info = mysql_fetch_array($result_get_site_info);
	$user = $myrow_result_get_site_info['user'];                      
	$user_password = $myrow_result_get_site_info['user_password'];                                     
	$site_description = $myrow_result_get_site_info['site_description'];                      
	$keywords = $myrow_result_get_site_info['keywords'];                       
	$mail_address = $myrow_result_get_site_info['mail_address'];                 
	 if(isset($echo)) {if($echo != ""){ echo $echo; } }?>                                     
	<?php
}	 
echo  "</div><!--site_params-->\n";
 ?>

                                     
                                 