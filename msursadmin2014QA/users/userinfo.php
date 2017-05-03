<?php
if(isset($_SESSION["isadmin"]))
{
	if(isset($_GET["user_id"]))
	{
		$userid = mysql_real_escape_string(stripslashes(trim(@$_GET["user_id"])));
		$algo = 'sha256';
		$data = "usercheck".$userid;
		$hashcode = hash($algo, $data, false);	
		$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$userid.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		//print_r($url);
		$resultcode = $xml->result;
		if($resultcode==0)
		{
			$userid = (string)$xml->info->u_id;
			$mobile = (string)$xml->info->mobile;
			$phone = (string)$xml->info->phone;
			$email =  (string)$xml->info->email;
			$first_name =  (string)$xml->info->first_name;
			$last_name =  (string)$xml->info->last_name;
			$username =  (string)$xml->info->username;
			$regist_date =  (string)$xml->info->regist_date;
			$birthDay =  (string)$xml->info->birthday;
			$birthMonth =  (string)$xml->info->birthmonth;
			$birthYear =  (string)$xml->info->birthyear;
			$blocked =  (string)$xml->info->blocked;
			$oauth_provider =  (string)$xml->info->oauth_provider;
			$deposit =  (string)$xml->info->deposit;
			echo "<div class='user_detailed_page'>\n";
			if($blocked==1)
			{
				$user_status='დაბლოკილი';
			}
			if($blocked==0)
			{
				$user_status='აქტიური';
			}
			echo "<h3>მომხმარებლის პირადი მონაცემები</h3>\n";
			echo "<table class='user_personal_info'>\n";
			echo "<tr>\n";
			echo "<th>მომხმარებელი</th><td>".$username."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>სახელი</th><td>".$first_name."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>გვარი</th><td>".$last_name."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>მეილი</th><td>".$email."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>ფიქს. ტელ.</th><td>".$phone."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>მობილური</th><td>".$mobile."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>დეპოზიტი</th><td>".$deposit." ლარი</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>დაბადების თარიღი</th><td>".$birthDay."/".$birthMonth."/".$birthYear."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>სტატუსი</th><td>".$user_status."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>პროვაიდერი</th><td>".$oauth_provider."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<th>რეგისტ. თარიღი</th><td>".$regist_date."</td>";
			echo "</tr>\n";
			echo "<tr>\n";
			//echo "<td colspan='2'><a href='?admin=users&amp;user_id=".$userid."&amp;activity=activity'>აქტივობები</a> / <a href='?admin=users&amp;user_id=".$userid."&amp;activity=lots'>ლოტები</a></td>";
			echo "</tr>\n";
			echo "</table>\n";

			echo "<p class='backward'><a href='javascript:history.back(1);'>უკან დაბრუნება</a></p>\n";
			echo "</div><!--user_personal_info-->\n";
			echo "<div class='user_info'>\n";
			echo "<p class='backward'><a href='javascript:history.back(1);'><img src='../images/backward.png' alt='უკან' /> </a></p>\n";
			echo "</div><!--user_detailed_page-->\n";
		}
		else
		{

		}
	}
}
else
{
	header("../login.php");
}
?>