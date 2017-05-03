<?php
echo "<div class='main-content'>\n";
echo "<h3>რეგისტრაციის ფორმა</h3>\n";
//include "languages/ge.php";
include "../includes/users/user.class.php";
//include "users/errorUpdateForm.php";

$admin=$_GET["admin"];
 if ($_GET["regist"]=='true')
	 {
		$user = new user();
		$register = $user->registration($_POST);
		if($register)
		{
		   echo "<ul>\n";
		   foreach($register as $error)
		   {
			 echo "<li>".$error."</li>\n";
		   }
		   echo "</ul>\n";
		  // echo "<h3>რეგისტრაციის ფორმა</h3>\n";
		  include "users/errorUpdateForm.php";
	   }
		else
		{
		   echo "<p style='color: #000;' align='left'>".$scs[0]."</p>"; 
		   echo "<p style='color: #000;' align='left'>".$scs[1]."</p>";
		}
		echo "<br />";
		echo "<br />";
		echo "<br />";
		unset($user);
	 }
else
 {
	echo "<form action='?admin=".$admin."&amp;regist=true' method='post' enctype='multipart/form-data' class='stand_form'>\n";
		echo "<span>სავალდებულო ველები აღნიშნულია * სიმბოლოთი</span>";
		echo "\t<fieldset>\n";
		echo "\t<legend>პირადი მონაცემები</legend>\n";
		echo "<div>";
		echo "<p class='fullName'>\n";
		echo "\t<label for='firstName'>სახელი *</label>\n";							
		echo "\t<input type='text' name='firstName' cols='40' id='firstName' />\n";
		echo "</p><!--fullName-->\n";
		echo "<p class='fullName'>";
		echo "\t<label for='lastName'>გვარი *</label>\n";	
		echo "\t<input type='text' name='lastName' cols='40' id='lastName' />\n";
		echo "</p><!--fullName-->\n";
		echo "</div>";
		echo "<div>";
		echo "\t<label for='lastName'>დაბადების თარიღი</label>\n";
		echo "<p class='birthDate'>";
		echo "\t<label for='lastName'>წელი</label>\n";	
		echo "<select name='year'>\n";
		echo "<option value=''>-</option>\n";
		for($i=2000; $i>=1920; $i--)
		{
			$year=$i;
			echo "\t\t<option value='".$i."'>".$year."</option>\n";
		}
		echo "</select>\n";
		echo "</p><!--birthDate-->\n";
		echo "<p class='birthDate'>\n";
		echo "\t<label for='month'>თვე</label>\n";	
		echo "<select name='month'>\n";
		echo "<option value=''>-</option>\n";
		$resultMonths = mysql_query("SELECT id, month FROM months ORDER BY id  ");
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
		echo "<option value=''>-</option>\n";
		for($i=1; $i<=31; $i++)
		{
			$day=$i;
			echo "<option value='".$i."'>".$day."</option>\n";
		}
		echo "</select>\n";
		echo "</p><!--birthDate-->\n";
		echo "</div>";
		//echo "<div>";
		//echo "\t<div>მიუთითეთ სქესი</div>\n";	
		//echo "<p class='gender'>";
		//echo "\t<label for='gender1'>მამრ</label>\n";	
		//echo "\t<input type='radio' checked='checked' name='gender' value='1' id='gender1' />\n";
		//echo "</p>";
		//echo "<p class='gender'>";
		//echo "\t<label for='gender2'>მდედრ</label>\n";
		//echo "\t<input type='radio' name='gender' value='2' id='gender1' />\n";
		//echo "</p>";
		//echo "</div>";
		echo "\t</fieldset>\n";
		echo "\t<fieldset>\n";
		echo "\t<legend>საკონტაქტო მონაცემები</legend>\n";
		echo "<div>";
		echo "<p class='contactsInfo'>";
		echo "\t<label for='phone'>ტელ: სახ/სამს</label>\n";			
		echo "\t<input type='text' name='phone' id='phone' />\n";
		echo "</p><!--contactsInfo-->\n";
		echo "<p class='contactsInfo'>";
		echo "\t<label for='phone'>მობილური *</label>\n";			
		echo "\t<input type='text' name='mobile' id='mobile' />\n";
		echo "</p><!--contactsInfo-->\n";
		echo "<p class='contactsInfo'>";
		echo "\t<label for='web'>ვებ-გვერდი</label>\n";			
		echo "\t<input type='text' name='web' id='web' />\n";
		echo "</p><!--contactsInfo-->\n";
		echo "</div>";
		echo "\t</fieldset>\n";
		echo "\t<fieldset>\n";
		echo "\t<legend>მომხმარებლის მონაცემები</legend>\n";
		echo "<div>";
		echo "<p class='fullName'>";
		echo "\t\t<label for='nickName'>მომხმარებელი *</label>\n";								
		echo "\t\t<input type='text' name='nickName' cols='40' id='nickName' />\n";
		echo "</p><!--fullName-->\n";
		echo "</div>";
		echo "<div>\n";
		echo "<p class='fullName'>\n";
		echo "\t<label for='e-mail'>მეილი *</label>\n";							
		echo "\t\t<input type='text' name='email' cols='40' id='email' />\n";
		echo "</p><!--fullName-->\n";
		echo "</div>\n";
		echo "<div>";
		echo "<p class='contactsInfo'>";
		echo "\t<label for='password'>პაროლი *</label>\n";							
		echo "\t\t<input type='password' name='password' cols='40' id='password' />\n";
		echo "</p><!--contactsInfo-->\n";
		echo "<p class='contactsInfo'>";
		echo "\t<label for='password2'>გაიმეორეთ პაროლი *</label>\n";							
		echo "\t\t<input type='password' name='password2' cols='40' id='password2' />\n";
		echo "</p><!--contactsInfo-->\n";
		echo "</div>";
		echo "<div>";
		echo "\t\t<input type='image' src='../images/registracia.png' name='submit_registration' value='submit_registration'' />\n";
		echo "</div>";
		echo "\t</fieldset>\n";
	echo "</form>\n";
	}
echo "</div><!--main-content-->\n";

?>