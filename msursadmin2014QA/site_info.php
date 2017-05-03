<?php
include("../conns/connection.php");
$key = isset($_POST['key'])?$_POST['key']:"";
if($key != "")
{
	$user = isset($_POST['user1'])?$_POST['user1']:"";
	if($user != "")
	{
		$mail_address = isset($_POST['mail_address'])?$_POST['mail_address']:"";
	   $user_password = isset($_POST['user_password'])?$_POST['user_password']:"";
	   $user_password=md5($user_password);
		 $result_get_site_info = mysql_query("SELECT * FROM admin WHERE user_password= '".$user_password."'");
		 if(mysql_num_rows($result_get_site_info)>0)
		{
			$myrow_result_get_site_info = mysql_fetch_array($result_get_site_info);
			$myrow_result_get_site_info["user_password"];
			if(!empty($_POST["user_password_new"])&&(!empty($_POST["user_password_new1"])))
			{
				 if($_POST["user_password_new"]==$_POST["user_password_new1"])
				{
					if(strlen($_POST["user_password_new"])>6&&strlen($_POST["user_password_new"])<30)
					{
						$user_password_new=@md5($_POST["user_password_new"]);
						 $update_info = mysql_query("UPDATE admin SET  user_password = '".$user_password_new."' WHERE id=1", $con);
						 if(!empty($mail_address))
							{
							  $to          = $this->email;
							  $subject     = $_SERVER['SERVER_NAME'];
							  $body        = "მომხმარებელი: ".$user." თქვენი პაროლი: ".$user_password_new."";
							  $from        = $_SERVER['SERVER_NAME'];
							  mail($to, $subject, $body, $from);
							}
					}
				}
				$update_info = mysql_query("UPDATE `admin` SET `mail_address` = '$mail_address', `user` = '$user' WHERE `admin`.`id` =1", $con); 
				echo "<h2>ადმინის მონაცემები რედაქტირებულია</h2>\n";
			}
		}
		else
			{
				echo "<h1>მიუთითეთ პაროლი ადმინის მონაცემების შესაცვლელად</h1>\n";
			}
    }
}
else
{
    $result_get_site_info = mysql_query("SELECT * FROM `admin`",$con);
    $myrow_result_get_site_info = mysql_fetch_array($result_get_site_info);
    $user = $myrow_result_get_site_info['user'];                               
    $site_description = $myrow_result_get_site_info['site_description'];                      
    $keywords = $myrow_result_get_site_info['keywords'];                       
    $title_geo = $myrow_result_get_site_info['title_geo'];                       
    $title_eng = $myrow_result_get_site_info['title_eng'];                       
    $mail_address = $myrow_result_get_site_info['mail_address'];                 
    $video_name = $myrow_result_get_site_info['video_name'];     
    $language_visibility = $myrow_result_get_site_info['language_visibility'];     
}
?>
<?php if (isset($echo)) {if($echo != ""){ echo $echo; } }?>
<div class="center">
	<form action="?admin=configuration" method="post" name="forma">
	<fieldset>
	<legend>რედაქტირება</legend>
	<label>მომხმარებელი</label><br />
	<input type="text" size="40" name="user1" value="<?php echo $user?>" />
	<br /><br />
	<label>პაროლი</label><br />
	<input type="password" size="40" name="user_password" />
	<br /><br />
	<label>ახალი პაროლი</label><br />
	<input type="password" size="40" name="user_password_new" />
	<br /><br />
	<label>გაიმეორეთ პაროლი</label><br />
	<input type="password" size="40" name="user_password_new1" />
	<br /><br />
	<label>ელექტრონული მისამართი</label>
	 <br />
	<input type="text" size="40" name="mail_address" />
	<br /><br />
	<input type="hidden" name="key" value="control" />
	<input type="submit" name="submit" value="შეცვალე" />
	</fieldset>
	</form> 
<?php
echo "<p><a class='back' href='javascript:history.back(1);'>უკან დაბრუნება</a></p>\n";  
?> 
</div><!--center-->                                  