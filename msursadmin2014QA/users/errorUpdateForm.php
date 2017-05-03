<?
if(isset($_GET["regist"]))
			{
				$action='?admin='.$admin.'&amp;regist=true';
			}
			else
			{
				$action='?admin='.$admin.'&amp;process=update';
			}
		echo "<form action='".$action."' method='post' enctype='multipart/form-data' class='stand_form' >\n";
		echo "<span>სავალდებულო ველები აღნიშნულია * სიმბოლოთი</span>";
		echo "\t<fieldset>\n";
			echo "\t<legend>პირადი მონაცემები</legend>\n";
			echo "<div>";
			echo "<p class='fullName'>";
			echo "\t<label for='firstName'>სახელი</label>\n";							
			echo "\t<input type='text' name='firstName' value='".$_POST["firstName"]."' cols='40' id='firstName' />\n";
			echo "</p><!--fullName-->\n";
			echo "<p class='fullName'>";
			echo "\t<label for='lastName'>გვარი</label>\n";	
			echo "\t<input type='text' name='lastName' value='".$_POST["lastName"]."' cols='40' id='lastName' />\n";
			echo "</p><!--fullName-->\n";
			echo "</div>";
			echo "<div>";
			echo "\t<label for='lastName'>დაბადების თარიღი</label>\n";
			echo "<p class='birthDate'>";
			echo "\t<label for='lastName'>წელი</label>\n";	
			echo "<select name='year'>\n";
			echo "\t\t<option value='".$_POST["year"]."'>".$_POST["year"]."</option>\n";
			for($i=2000; $i>=1920; $i--)
			{
				$year=$i;
				echo "\t\t<option value='".$i."'>".$year."</option>\n";
			}
			echo "</select>\n";
			echo "</p><!--birthDate-->\n";
			echo "<p class='birthDate'>\n";
			echo "\t<label for='lastName'>თვე</label>\n";	
			
			echo "<select name='month'>\n";
			$resultMonthsPost = mysql_query("SELECT id, month FROM months WHERE id='".$_POST["month"]."' ");
			$rowPost = mysql_fetch_array($resultMonthsPost);
			echo "\t\t<option value='".$rowPost["id"]."'>".$rowPost["month"]."</option>\n";
			$resultMonths = mysql_query("SELECT id, month FROM months ORDER BY id ");
			while ($row = mysql_fetch_array($resultMonths))
			{
			echo "\t\t<option value='".$row["id"]."'>".$row["month"]."</option>\n";
			}
			echo "</select>";
			echo "</p><!--birthDate-->\n";
			echo "<p class='birthDate'>\n";
			echo "\t<label for='day'>რიცხვი</label>\n";	
			echo "<select name='day'>\n";
			echo "\t\t<option value='".$_POST["day"]."'>".$_POST["day"]."</option>\n";
			for($i=1; $i<=31; $i++)
			{
				$day=$i;
				echo "<option value='".$i."'>".$day."</option>\n";
			}
			echo "</select>\n";
			echo "</p><!--birthDate-->\n";
			echo "</div>";
			echo "<div>";
			//echo "\t<div>მიუთითეთ სქესი</div>\n";	
			echo "<p class='gender'>";
			echo "\t<label for='gender1'>მამრ</label>\n";			
			if($_POST["gender"]==1)
			{
				echo "\t<input type='radio' checked='checked' name='gender' value='1' id='gender1' />\n";
			}	else {
			echo "\t<input type='radio' name='gender' value='1' id='gender1' />\n"; }
			echo "</p>";
			echo "<p class='gender'>";
			echo "\t<label for='gender2'>მდედრ</label>\n";
			if($_POST["gender"]==2)
			{
				echo "\t<input type='radio' checked='checked' name='gender' value='2' id='gender2' />\n";
			}	else {
			echo "\t<input type='radio' name='gender' value='2' id='gender2' />\n"; }
			echo "</p>";
			echo "</div>";
			echo "\t</fieldset>\n";
			echo "\t<fieldset>\n";
			echo "\t<legend>საკონტაქტო მონაცემები</legend>\n";
			echo "<div>";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='phone'>ტელ: სახ/სამს</label>\n";			
			echo "\t<input type='text' name='phone' value='".$_POST["phone"]."' id='phone' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='phone'>მობილური</label>\n";			
			echo "\t<input type='text' name='mobile' value='".$_POST["mobile"]."' id='mobile' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='web'>ვებ-გვერდი</label>\n";			
			echo "\t<input type='text' name='web' value='".$_POST["web"]."' id='web' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "</div>";
			echo "\t</fieldset>\n";
		
			echo "\t<fieldset>\n";
			echo "\t<legend>მომხმარებლის მონაცემები</legend>\n";
			if(!isset($_GET["process"]))
			{
			echo "<div>";
			echo "\t\t<label for='nickName'>მომხმარებელი</label>\n";								
			echo "\t\t<input type='text' name='nickName' value='".$_POST["nickName"]."' cols='40' id='nickName' />\n";
			echo "</div>";
			echo "<div>";
			echo "\t<label for='e-mail'>მეილი</label>\n";							
			echo "\t\t<input type='text' name='email' value='".$_POST["email"]."' cols='40' id='email' />\n";
			echo "</div>";
			echo "<div>";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='password'>პაროლი</label>\n";							
			echo "\t\t<input type='password' name='password' cols='40' id='password' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='password2'>გაიმეორეთ პაროლი</label>\n";							
			echo "\t\t<input type='password' name='password2' cols='40' id='password2' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "</div>";
			}
			else
			{
			echo "<div>";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='oldPassword'>ძველი პაროლი</label>\n";							
			echo "\t\t<input type='password' name='oldPassword' cols='40' id='oldPassword' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='newPassword'>ახალი პაროლი</label>\n";							
			echo "\t\t<input type='password' name='newPassword' cols='40' id='newPassword' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='newPassword2'>გაიმეორეთ ახალი პაროლი</label>\n";							
			echo "\t\t<input type='password' name='newPassword2' cols='60' id='newPassword2' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "</div>";
			}
			echo "<div>";
			echo "\t\t<input type='image' src='images/registracia.png' name='submit_registration' value='submit_registration'' />\n";
			echo "</div>";
			echo "\t</fieldset>\n";

	echo "</form>\n";
?>