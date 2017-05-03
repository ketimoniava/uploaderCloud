<?php 
if(isset($_SESSION["isadmin"]))
{
	include "../conns/connection.php";
	if (!isset($_GET["process"]))
	{
		echo "<div class='contact_adress'><a href='?admin=contacts&amp;process=update'>საკონტაქტო მონაცემების რედაქტირება</a></div>";
			/*echo "<table cellspacing='0px' cellpadding='0px' class='contact_table'>";
			$result = mysql_query("SELECT * FROM contacts ORDER BY id desc");
			echo "<tr class='head'> ";
					echo "<th>ID</th><th>სახელი</th><th>ორგანიზაცია</th><th>ელ-ფოსტა</th><th>შეტყობინება</th><th>გაგზავნის თარიღი</th>";
				echo  "</tr>";
			while ($row = mysql_fetch_array($result))
			{
				echo "<tr> ";
					echo "<td>".$row["id"]."</td><td>".$row["contact_name"]."</td><td>".$row["Organization"]."</td><td>".$row["mail"]."</td><td>".$row["message"]."</td><td>".$row["sendDate"]."</td>";
				echo  "</tr>";
			}
			echo "</table>";*/
	
	}
	else { 
		if ($_GET["process"]=="update")
		{
			$contact=mysql_query("SELECT id, contact FROM cont order by id limit 1");
			$contacts=mysql_fetch_array($contact);
			//echo "<div class=contact>".$contacts["contact"]."</div>";
			echo "<form action='?admin=contacts&amp;process=update&amp;state=update' method=post enctype='multipart/form-data' class='insert_update_data'>";
			echo "<fieldset>\n";
			echo "<label>კონტაქტი</label><br />";
			echo '<textarea name="contact" id="contact" cols="69" rows="6" class="wymeditor">'.$contacts['contact'].'</textarea><br />';
			echo '<p class="submit">
				<input type="reset" />
				<input type="submit" class="wymupdate" />
				</p>';
			echo "</fieldset>\n";
			echo "</form>";
		}
	
	}
	if (isset($_GET["state"]))
	{
		if($_GET["state"]=="update")
		{
			$contact = mysql_real_escape_string(stripslashes(trim(@$_POST["contact"])));
			echo "<p>საკონტაქტო მონაცემები რედაქტირებულია</p>\n";
			//echo $contact;
			$result = "UPDATE cont SET contact='".$contact."' WHERE id=1";
			mysql_query($result, $con) or exit ('error'.mysql_error());
		}
	}
}
else
{
	header("../login.php");
}
?>
