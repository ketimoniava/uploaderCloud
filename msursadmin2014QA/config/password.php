<?php
if(isset($_GET["state"]))
{
	$state=mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	$result_get_site_info = mysql_query("SELECT * FROM `admin`",$con);
	$myrow_result_get_site_info = mysql_fetch_array($result_get_site_info);
	$user_password = $myrow_result_get_site_info['user_password'];        
	if($state=='pass')
	{
		if(isset($_GET["process"]))
		{
			$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
			if($process=='update')
			{
				$user_old_pass = mysql_real_escape_string(stripslashes(trim(@$_POST["old_password"])));
				$user_pass = mysql_real_escape_string(stripslashes(trim(@$_POST["user_password"])));
				$user_pass2 = mysql_real_escape_string(stripslashes(trim(@$_POST["user_password2"])));
				$md_pass = md5($user_pass);
				echo "<div class='error_list'>\n";
				$emptyValue=0;
				if(empty($user_old_pass)){ echo "<h2>თქვენ უნდა შეიყვანოთ <strong>მიმდინარე პაროლი</strong></h2>"; $emptyValue = 1; }
				if(empty($user_pass)){ echo "<h2>მონაცემის რედაქტირებისთვის, თქვენ უნდა შეიყვანოთ <strong>პაროლი</strong></h2>"; $emptyValue = 1; }
				if(empty($user_pass2)){ echo "<h2>მონაცემის რედაქტირებისთვის, თქვენ უნდა შეიყვანოთ <strong>პაროლი განმეორებით</strong></h2>"; $emptyValue = 1; }
				echo "</div><!--error_list-->\n";
				if($emptyValue==0)	{
					$old_pass=md5($user_old_pass);
					if(($user_password==$old_pass) && ($user_pass==$user_pass2))
					{
						echo "<div class='process_pass'>\n";
						echo "<h2><strong>პაროლი </strong> რედაქტირებულია</h2>\n";
						echo "<p class='backward'><a href=\"?admin=configuration\">უკან დაბრუნება</a></p>\n";
						echo "</div><!--process_pass-->\n";
						$result = "UPDATE admin SET user_password	='".$md_pass."' ";
						mysql_query($result, $con) or exit ('error'.mysql_error());
						exit("<meta http-equiv='refresh' content='0; url=?admin=configuration'>");
					}
					else
					{
						echo "<div class='error_list'>\n";
						echo "<h2>მონაცემის რედაქტირებისთვის, თქვენ უნდა შეიყვანოთ <strong>მიმდინარე და ახალი პაროლი</strong></h2>"; 
						echo "</div><!--error_list-->\n";
					}
				}
			}
		}
		echo "<form action='?admin=configuration&amp;state=".$state."&amp;process=update' method='post' name='forma' class='insert_update_data'>
			<fieldset>
				<legend>პაროლის რედაქტირება</legend>
				<label for='old_password'>მიმდინარე პაროლი</label>
				<input type='password' size='40' name='old_password' id='old_password' />
				<label for='password'>ახალი პაროლი</label>
				<input type='password' size='40' name='user_password' id='password' />
				<label for='password2'>გაიმეორეთ ახალი პაროლი</label>
				<input type='password' size='40' name='user_password2' id='password2' />
				<input type='hidden' name='key' value='control' />
				<div class='submit'><input type='reset' class='wymupdate' value='Reset data' /><input type='submit' class='wymupdate' value='Submit data' /></div>
			</fieldset>
		</form>\n";
	}//state==update
}//isset state

?>