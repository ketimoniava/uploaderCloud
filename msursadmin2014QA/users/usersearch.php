<?php
if(isset($_SESSION["isadmin"]))
{
echo "<div class='search_block'>\n";
if(isset($_GET["state"]))
{
$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
if($state=='search')
{
	if(isset($_POST["search"]))
	{
		$toFindText = @$_POST["search"];
		$_SESSION["findText"] = $toFindText;
	}
	$itemPerPage=20;
	if(isset($_GET["active_page"]))
	 {
		$activePage=@$_GET["active_page"];
		$startFrom=($activePage-1)*$itemPerPage;
		$limit = $startFrom.", ".$itemPerPage;
	 }
	else
		{ 
			$activePage=1;
			$limit = ($activePage-1).", ".$itemPerPage; 
		}
	if(!empty($_SESSION["findText"]))
	{
		$algo = 'sha256';
		$data = "usercheck".$_SESSION["findText"];
		$hashcode = hash($algo, $data, false);
		$url = 'http://service.ge/xml_moduls/usercheck1.php?cat=usercheck&fuser='.$_SESSION["findText"].'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		$resultcode = $xml->result;
		if($resultcode == 0)
		{
			echo "<table class='category' cellpadding='0px' cellspacing='0px'>\n";
			echo "<tr>\n";
			echo "<th>იდ</th><th>მომხმარებელი</th><th>ელფოსტა</th><th>სახელი გვარი</th><th>მობილური</th><th>დაბლოკვა</th><th>წაშლა</th>\n";
			echo "</tr>\n";
			foreach($xml->info as $userinfo)			
			{
				$u_id = (string)$xml->info->u_id;
				$mobile = (string)$xml->info->mobile;
				$email = (string)$xml->info->email;
				$username = (string)$xml->info->username;
				$firstName = (string)$xml->info->first_name;
				$lastName = (string)$xml->info->last_name;
				$mobile = (string)$xml->info->mobile;
				$birthDay = (string)$xml->info->birthday;
				$birthMonth = (string)$xml->info->birthmonth;
				$birthYear = (string)$xml->info->birthyear;
				$regist_date = (string)$xml->info->regist_date;
				$ublocked = (string)$xml->info->blocked;
				echo "<tr>\n";
				echo "<td>".$u_id."</td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$username."</a></td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$email."</a></td><td>".$firstName." ".$lastName."</td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$mobile."</a></td>";
				if($ublocked == 0)
					{
						echo "<td><a href='?admin=users&amp;blocked=process&amp;user_id=".$u_id."'>დაბლოკვა</a></td>";
					}
					else
					{
						echo "<td>დაბლოკილი<a href='?admin=users&amp;unblocked=process&amp;user_id=".$u_id."'>ბლოკის მოხსნა</a></td>";
					}
				echo "<td><a href='?admin=users&amp;state=delete&amp;user_id=".$u_id."'>წაშლა</a></td>";
				//echo "<td><a href='?admin=users&amp;user_id=".$u_id."'>ნახვა</a></td>";
				echo "</tr>\n";
			}//foearch
			echo "</table>\n";
			echo "<h3>მომხმარებელი ".$username." </h3>\n";
		}
		else
		{
			echo "<h3>მონაცემი არ მოიძებნა</h3>\n";	
		}
		/*$users=mysql_query("SELECT * FROM users WHERE (username LIKE '%".$_SESSION["findText"]."%' OR email LIKE '%".$_SESSION["findText"]."%' OR (firstName LIKE '%".$_SESSION["findText"]."%' AND lastName LIKE '%".$_SESSION["findText"]."%') ) GROUP BY username LIMIT ".$limit." ");
		$items = mysql_num_rows($users);
		if($items>0)
		{
			echo "<div class='result'>შედეგი ".$items."</div><!--result-->\n";
			echo "<table class='category' cellpadding='0px' cellspacing='0px'>\n";
			echo "<tr>\n";
			echo "<th>იდ</th><th>მომხმარებელი</th><th>მეილი</th><th>სახელი გვარი</th><th>მობილური</th><th>დაბადების თარიღი</th><th>რეგისტრაციის თარიღი</th><th>დაბლოკვა</th><th>წაშლა</th>\n";
			echo "</tr>\n";
			while($userRow=mysql_fetch_array($users))
			{
			echo "<tr>\n";
			echo "<td>".$userRow["id"]."</td><td>".$userRow["username"]."</td><td>".$userRow["email"]."</td><td>".$userRow["firstName"]." ".$userRow["lastName"]."</td><td>".$userRow["mobile"]."</td><td>".$userRow["birthDay"]."/".$userRow["birthMonth"]."/".$userRow["birthYear"]."</td><td>".$userRow["regist_date"]."</td>";
			if($userRow["blocked"]==0)
				{
					echo "<td><a href='?admin=users&amp;blocked=process&amp;user_id=".$userRow["id"]."'>დაბლოკვა</a></td>";
				}
				else
				{
					echo "<td>დაბლოკილი<a href='?admin=users&amp;unblocked=process&amp;user_id=".$userRow["id"]."'>ბლოკის მოხსნა</a></td>";
				}
			echo "<td><a href='?admin=users&amp;state=delete&amp;user_id=".$userRow["id"]."'>წაშლა</a></td>";
			echo "</tr>\n";
			}
			echo "</table>\n";
			echo "<div><a href='?admin=users'>იხილეთ ყველა</a></div>\n";
		}//if items >0
		else
		{
			echo "<h1>შედეგი: 0</h1>\n";
		}*/
		}//not empty
	}//search
}//state
echo "</div><!--search_block-->\n";
}else
{
	header("../login.php");
}
?>