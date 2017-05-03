<?php
if(isset($_GET["state"]))
{
	$state=mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	$result_get_site_info = mysql_query("SELECT * FROM `admin`",$con);
	$myrow_result_get_site_info = mysql_fetch_array($result_get_site_info);
	$desc = $myrow_result_get_site_info['site_description'];     
	$user_password = $myrow_result_get_site_info['user_password'];        
	if($state=='desc')
	{
		if(isset($_GET["process"]))
		{
			$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
			if($process=='update')
			{
				$desc = mysql_real_escape_string(stripslashes(trim(@$_POST["desc"])));
				$user_pass = mysql_real_escape_string(stripslashes(trim(@$_POST["user_password"])));
				$md_pass = md5($user_pass);
				echo "<div class='error_list'>\n";
				$emptyValue=0;
				if(empty($desc)){ echo "<h2>თქვენ უნდა შეიყვანოთ <strong>საიტის აღწერა</strong></h2>"; $emptyValue = 1; }
				if(empty($user_pass)){ echo "<h2>მონაცემის რედაქტირებისთვის, თქვენ უნდა შეიყვანოთ <strong>პაროლი</strong></h2>"; $emptyValue = 1; }
				echo "</div><!--error_list-->\n";
				if($emptyValue==0)	{
					if($user_password==$md_pass)
					{
						echo "<div class='process_pass'>\n";
						echo "<h2><strong>".$desc."</strong> რედაქტირებულია</h2>\n";
						echo "<p class='backward'><a href=\"?admin=configuration\">უკან დაბრუნება</a></p>\n";
						echo "</div><!--process_pass-->\n";
						$result = "UPDATE admin SET site_description='".$desc."' ";
						mysql_query($result, $con) or exit ('error'.mysql_error());
						exit("<meta http-equiv='refresh' content='0; url=?admin=configuration'>");
					}
					else
					{
						echo "<div class='error_list'>\n";
						echo "<h2>მონაცემის რედაქტირებისთვის, თქვენ უნდა შეიყვანოთ <strong>პაროლი</strong></h2>"; 
						echo "</div><!--error_list-->\n";
					}
				}
			}
		}
		echo "<form action='?admin=configuration&amp;state=".$state."&amp;process=update' method='post' name='forma' class='insert_update_data'>
			<fieldset>
				<legend>საიტის აღწერის რედაქტირება</legend>
				<label for='desc'>საიტის აღწერა</label>
				<input type='text' size='40' name='desc' value='".$desc."' id='desc' />
				<label for='password'>პაროლი</label>
				<input type='password' size='40' name='user_password' id='password' />
				<input type='hidden' name='key' value='control' />
				<div class='submit'><input type='reset' class='wymupdate' value='Reset data' /><input type='submit' class='wymupdate' value='Submit data' /></div>
			</fieldset>
		</form>\n";
	}//state==update
}//isset state

?>