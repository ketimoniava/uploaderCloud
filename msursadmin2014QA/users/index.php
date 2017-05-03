<?php
if(isset($_SESSION["isadmin"]))
{
echo "<h2>მომხმარებლები</h2>\n";
echo "<div class='content'>\n";
if(isset($_GET["regist"]))
{
	//include"users/users.php";
}
elseif(!isset($_GET["blocked"])&&(!isset($_GET["unblocked"]))&&(!isset($_GET["user_id"])))
{

/*echo "<div class='left'>\n";
echo "<ul class='menu'>\n";
echo "<li><a href='?admin=users&amp;regist=users'>მომხმარებლის დამატება</a></li>\n";
echo "</ul><!--menu-->\n";
echo "</div><!--left-->\n";
*/
//echo "<div class='wide-content'>\n";

echo "<form action='?admin=users&amp;state=search' method='post' class='smallsearch'>
	<fieldset>
		<legend>მომხმარებლის ძებნა</legend>
		<span class='inserttext'><input type='text' name='search' id='search' onclick='f()' size='40' /></span>
		<span class='findtext'><input type='submit' name='search_bottom' value='search' /></span>
	</fieldset>
</form>\n";

}
//მომხმარებლის წაშლა
if(isset($_GET["state"]))
{
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET['state'])));
	if($state == 'delete')
	{
		include "users/delete.php";
	}
	if($state == 'search')
	{
		include "users/usersearch.php";
	}
}
else
	{
	//momxmareblis blokis dadeba
	if(isset($_GET["blocked"]))
	{
		$blocked = mysql_real_escape_string(stripslashes(trim(@$_GET['blocked'])));
		$user_id = mysql_real_escape_string(stripslashes(trim(@$_GET['user_id'])));
		echo "<div class='center'>";
		if($blocked  == 'process')
		{
			echo "<h3>ღილაკზე დადებითი პასუხის შემთხვევაში მომხმარებელი დაიბლოკება</h3>\n";
			echo "<p><a href='?admin=users&amp;blocked=true&amp;user_id=".$user_id."'><img src='../images/yes-botton.png' alt='დიახ'/></a><a href='?admin=users'><img src='../images/no-botton.png' alt='არა'/></a></p>\n";
		}
		elseif($blocked =='true')
		{
			$algo = 'sha256';
			$data = "usercheck".$user_id.$blocked;
			$hashcode = hash($algo, $data, false);	
			$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$user_id.'&blocked=1&hash='.$hashcode;
			$xml = simplexml_load_file($url);
			$resultcode = $xml->result;
			if($resultcode==0)
			{
				$mobile = (string)$xml->info->mobile;
				$email =  (string)$xml->info->email;
				$username =  (string)$xml->info->username;
				echo "<h3>მომხმარებელი ".$username." დაბლოკილია</h3>\n";
			}
			else
			{
				echo "<h3>მონაცემი არ მოიძებნა</h3>\n";	
			}
		}
	echo "</div><!--center-->\n";
	}	
	echo "</div><!--wideContent-->\n";
	}

//momxmareblis blokis moxsna
if(isset($_GET["unblocked"]))
{
	$unblocked = mysql_real_escape_string(stripslashes(trim(@$_GET['unblocked'])));
	$user_id = mysql_real_escape_string(stripslashes(trim(@$_GET['user_id'])));
	echo "<div class='center'>\n";
	if($unblocked=='process')
	{
	echo "<h3>ღილაკზე დადებითი პასუხის შემთხვევაში მომხმარებელს დაბლოკვა მოეხსნება</h3>\n";
	echo "<p><a href='?admin=users&amp;unblocked=true&amp;user_id=".$user_id."'>diax</a></p>\n";
	echo "<p><a href='?admin=user'>ara</a></p>\n";
	}
	elseif($unblocked=='true')
	{
		$block=0;
		/*$user=mysql_query("SELECT * FROM users WHERE  id='".$user_id."'");
		$userRow=mysql_fetch_array($user);
		echo "<h3>მომხმარებელი ".$userRow["username"]." აღარ არის დაბლოკილი</h3>\n";
		$result = "UPDATE users SET blocked='".$block."' WHERE  id='".$user_id."' ";
		mysql_query($result, $con) or exit ('error'.mysql_error());*/
		$algo = 'sha256';
		$data = "usercheck".$user_id.$block;
		$hashcode = hash($algo, $data, false);	
		$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$user_id.'&blocked=0&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		$resultcode = $xml->result;
		if($resultcode == 0)
		{
			$mobile = (string)$xml->info->mobile;
			$email =  (string)$xml->info->email;
			$username =  (string)$xml->info->username;
			echo "<h3>მომხმარებელი ".$username." გააქტიურებულია</h3>\n";
		}
		else
		{
			echo "<h3>მონაცემი არ მოიძებნა</h3>\n";	
		}
  }
echo "</div><!--center-->\n";
}
if(isset($_GET["user_id"])&&(!isset($_GET["blocked"])&&!isset($_GET["unblocked"])&&!isset($_GET["state"])))
{
	include "users/userinfo.php";
}
else
{
	$algo = 'sha256';
	$data = "usercheck";
	$hashcode = hash($algo, $data, false);	
	$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode==0)
	{
		echo  "<div class='wideContent'>\n";
		echo "<table class='category' cellpadding='0px' cellspacing='0px'>\n";
		echo "<tr>\n";
		echo "<th>იდ</th><th>მომხმარებელი</th><th>ელფოსტა</th><th>სახელი გვარი</th><th>მობილური</th><th>დაბლოკვა</th><th>წაშლა</th>\n";
		echo "</tr>\n";
		foreach ($xml->info as $w)
		{
		$username = (string)$w->username;
		$u_id = (string)$w->u_id;
		$regist_date = (string) $w->regist_date;
		$first_name = (string)$w->first_name;
		$last_name =  (string)$w->last_name;
		$mobile = (string)$w->mobile;
		$email = (string)$w->email;
		$blocked = (string)$w->blocked;
		echo "<tr>\n";
		echo "<td>".$u_id."</td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$username."</a></td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$email."</a></td><td>".$first_name." ".$last_name."</td><td><a href='?admin=users&amp;user_id=".$u_id."'>".$mobile."</a></td>";
		if($blocked == 0)
			{
				echo "<td><a href='?admin=users&amp;blocked=process&amp;user_id=".$u_id."'>დაბლოკვა</a></td>\n";
			}
			else
			{
				echo "<td>დაბლოკილი<a href='?admin=users&amp;unblocked=process&amp;user_id=".$u_id."'>ბლოკის მოხსნა</a></td>\n";
			}
		//echo "<td><a href='?admin=users&amp;user_id=".$u_id."'>ნახვა</a></td>";
		echo "<td><a href='?admin=users&amp;state=delete&amp;user_id=".$u_id."'>წაშლა</a></td>";
		echo "</tr>\n";
		}//foreach

		echo "</table>\n";
		echo "</div><!--wideContent-->\n";
	}	
	/*$users = mysql_query("SELECT * FROM users ORDER BY regist_date DESC");
	if(mysql_num_rows($users)>0)
	{
		echo "<div class='wideContent'>\n";
		echo "<table class='category' cellpadding='0px' cellspacing='0px'>\n";
		echo "<tr>\n";
		echo "<th>იდ</th><th>მომხმარებელი</th><th>ელ-ფოსტა</th><th>სახელი გვარი</th><th>რეგისტ თარიღი</th><th>დაბლოკვა</th><th>დეტალურად </th><th>წაშლა</th>\n";
		echo "</tr>\n";
		while($userRow=mysql_fetch_array($users))
		{
		echo "<tr>\n";
		echo "<td>".$userRow["id"]."</td><td>".$userRow["username"]."</td><td>".$userRow["email"]."</td><td>".$userRow["firstName"]." ".$userRow["lastName"]."</td><td>".$userRow["regist_date"]."</td>";
		if($userRow["blocked"]==0)
			{
				echo "<td><a href='?admin=users&amp;blocked=process&amp;user_id=".$userRow["id"]."'>დაბლოკვა</a></td>\n";
			}
			else
			{
				echo "<td>დაბლოკილი<a href='?admin=users&amp;unblocked=process&amp;user_id=".$userRow["id"]."'>ბლოკის მოხსნა</a></td>\n";
			}
		echo "<td><a href='?admin=users&amp;user_id=".$userRow["id"]."'>ნახვა</a></td>";
		echo "<td><a href='?admin=users&amp;state=delete&amp;user_id=".$userRow["id"]."'>წაშლა</a></td>";
		echo "</tr>\n";
		}
		echo "</table>\n";
		echo "</div><!--wideContent-->\n";
	}*/
}
echo "</div><!--content-->\n";
}
else
{
	header("../login.php");
}
?>