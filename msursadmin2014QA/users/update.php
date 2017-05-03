	<?
	if(isset($_GET["state"]))
	 {
		$state=$_GET["state"];
		if($state='update')
		 {
			if(isset($_GET["process"]))
				 {
				$process=$_GET["process"];
					if($process='update')
					 {
							$user = new user();
							$update = $user->update($_POST,$userID);
							if($update)
							{
								    echo "<ul>\n";
									   foreach($update as $error)
									   {
										 echo "<li>".$error."</li>\n";
									   }
									   echo "</ul>\n";
										echo "<h3>მონაცემები რედაქტირება ვერ შესრულდა</h3>";
										include ("includes/users/errorUpdateForm.php");
							}
							else
							{
								
								echo "<h3>მონაცემები რედაქტირებულია</h3>";
							}
					 }//process update
				 }//update state
				else
					 {

			$sqlUser   =mysql_query("SELECT id, nickName, email, web, firstName, lastName, birthDay, birthMonth, birthYear, gender, phone, mobile, regist_date, blocked, password FROM users WHERE id = '".$userID."' ");
			//$login_result = array();
			//echo "asdasd";
		   if (mysql_num_rows($sqlUser)>0)
			{
			   $rowUser=mysql_fetch_array($sqlUser);
				$email=$rowUser["email"];
				$web=$rowUser["web"];
				$firstName=$rowUser["firstName"];
				$lastName=$rowUser["lastName"];
				$gender=$rowUser["gender"];
				$phone=$rowUser["phone"];
				$mobile=$rowUser["mobile"];
				$regist_date=$rowUser["regist_date"];
				$nickName=$rowUser["nickName"];
				$birthDay=$rowUser["birthDay"];
				$birthMonth=$rowUser["birthMonth"];
				$birthYear=$rowUser["birthYear"];
			}
			echo "<h3>რეგისტრაციის ფორმა</h3>\n";
			echo "<form action='?admin=".$admin."&amp;state=".$state."&amp;process=update' method='post' enctype='multipart/form-data' class='stand_form' >\n";
			echo "<span>სავალდებულო ველები აღნიშნულია * სიმბოლოთი</span>";
			echo "\t<fieldset>\n";
			echo "\t<legend>პირადი მონაცემები</legend>\n";
			echo "<div>";
			echo "<p class='fullName'>";
			echo "\t<label for='firstName'>სახელი *</label>\n";							
			echo "\t<input type='text' name='firstName' value='".$firstName."' cols='40' id='firstName' />\n";
			echo "</p><!--fullName-->\n";
			echo "<p class='fullName'>";
			echo "\t<label for='lastName'>გვარი *</label>\n";	
			echo "\t<input type='text' name='lastName' value='".$lastName."' cols='40' id='lastName' />\n";
			echo "</p><!--fullName-->\n";
			echo "</div>";
			echo "<div>";
			echo "\t<label for='lastName'>დაბადების თარიღი</label>\n";
			echo "<p class='birthDate'>";
			echo "\t<label for='lastName'>წელი</label>\n";	
			echo "<select name='year'>\n";
			echo "\t\t<option value='".$birthYear."'>".$birthYear."</option>\n";
			for($i=2000; $i>=1920; $i--)
			{
				$year=$i;
				if($year!=$birthYear)
				{
				echo "\t\t<option value='".$i."'>".$year."</option>\n";
				}
			}
			echo "</select>\n";
			echo "</p><!--birthDate-->\n";
			echo "<p class='birthDate'>\n";
			echo "\t<label for='month'>თვე</label>\n";	
			echo "<select name='month'>\n";
			$resultMonths = mysql_query("SELECT id, month FROM months WHERE id='".$birthMonth."' ");
			$row = mysql_fetch_array($resultMonths);
			echo "\t\t<option value='".$row["id"]."'>".$row["month"]."</option>\n";
			$resultMonths = mysql_query("SELECT id, month FROM months WHERE id<>'".$birthMonth."' ");
			//$row = mysql_fetch_array($resultMonths);
			while ($row = mysql_fetch_array($resultMonths))
			{
			echo "\t\t<option value='".$row["id"]."'>".$row["month"]."</option>\n";
			}
			echo "</select>";
			echo "</p><!--birthDate-->\n";
			echo "<p class='birthDate'>\n";
			echo "\t<label for='day'>რიცხვი</label>\n";	
			echo "<select name='day'>\n";
			echo "\t\t<option value='".$birthDay."'>".$birthDay."</option>\n";
			for($i=1; $i<=31; $i++)
			{
				$day=$i;
				if($day!=$birthDay)
				{
				echo "<option value='".$i."'>".$day."</option>\n";
				}
			}
			echo "</select>\n";
			echo "</p><!--birthDate-->\n";
			echo "</div>";
			echo "<div>";
			//echo "\t<div>მიუთითეთ სქესი</div>\n";	
			echo "<p class='gender'>";
			echo "\t<label for='gender1'>მამრ</label>\n";	
			if($gender==1)
			 {
				echo "\t<input type='radio' checked='checked' name='gender' value='1' id='gender1' />\n";
			 }
			 else
			 {
			 echo "\t<input type='radio' name='gender' value='1' id='gender1' />\n";
			 }
			echo "</p>";
			echo "<p class='gender'>";
			echo "\t<label for='gender2'>მდედრ</label>\n";
			if($gender==2)
			 {
				echo "\t<input type='radio' checked='checked' name='gender' value='2' id='gender1' />\n";
			 }
			 else
			 {
			 echo "\t<input type='radio' radio='radio' name='gender' value='2' id='gender1' />\n";
			 }
			echo "</p>";
			echo "</div>";
			echo "\t</fieldset>\n";
			echo "\t<fieldset>\n";
			echo "\t<legend>საკონტაქტო მონაცემები</legend>\n";
			echo "<div>";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='phone'>ტელ: სახ/სამს</label>\n";			
			echo "\t<input type='text' name='phone' value='".$phone."' id='phone' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='phone'>მობილური *</label>\n";			
			echo "\t<input type='text' name='mobile' value='".$mobile."' id='mobile' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "<p class='contactsInfo'>";
			echo "\t<label for='web'>ვებ-გვერდი</label>\n";			
			echo "\t<input type='text' name='web' value='".$web."' id='web' />\n";
			echo "</p><!--contactsInfo-->\n";
			echo "</div>";
			echo "\t</fieldset>\n";
			echo "\t<fieldset>\n";
			echo "\t<legend>მომხმარებლის მონაცემები</legend>\n";
			/*echo "<div>";
			echo "\t\t<label for='nickName'>მომხმარებელი *</label>\n";								
			echo "\t\t<input type='text' name='nickName' value='".$nickName."' cols='40' id='nickName' />\n";
			echo "</div>";
			
			echo "<div>";
			echo "\t<label for='e-mail'>მეილი *</label>\n";							
			echo "\t\t<input type='text' name='email' value='".$email."' cols='40' id='email' />\n";
			echo "</div>";
		*/
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
			echo "<div>";
			echo "\t\t<input type='image' src='images/redaktireba.png' name='submit_registration' value='submit_registration'' />\n";
			echo "</div>";
			echo "\t</fieldset>\n";
	echo "</form>\n";
					 }
		 }
	?>