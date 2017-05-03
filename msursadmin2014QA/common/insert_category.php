<?php
if(isset($_SESSION["isadmin"]))
{
	echo "<div class='center'>\n";
	if(isset($_GET["process"]))
		{
			$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
			if($process=="insert_cat"){
					include "../conns/connection.php";
					$title = mysql_real_escape_string(stripslashes(trim(@$_POST["title"])));
					$langID=2;
					$emptyValue = 0; 
					if(empty($title)&&empty($title_eng)){ echo "<h3>თქვენ უნდა მიუთითოთ კატეგორიის <strong>დასახელება</strong></h3>\n"; $emptyValue = 1; 
								?>
				<form action="?admin=common&amp;state=<?php echo $state; ?>&amp;process=insert_cat" method="post" enctype="multipart/form-data" class='insert_update_data'>
				<fieldset>
				<legend>კატეგორიის დამატება</legend>
				<label for="title">დასახელება</label>
				<input type="text" name="title" id="title" size="50" />
				<div class='submit'><input type="submit" value="Insert data" /></div><!--submit-->
				</fieldset>
				</form>
		<?php 
					}
						if($emptyValue){ exit; }
						else{ 
								$tableName="common";
								$sql = "INSERT INTO categories (title, tablename) VALUES ('".$title."', '".$tableName."')";
								mysql_query($sql,$con) or exit('Error: ' . mysql_error());
								echo "<div class='process_pass'>\n";
								echo "<p><h3><strong>".$title." </strong></h3>კატეგორია დამატებულია მონაცემთა ბაზაში</p>\n";
								echo "<p class='backward'><a href=\"?admin=common\">უკან</a></p>\n";
								exit("<meta http-equiv='refresh' content='1; url=?admin=common'>");
								echo "</div><!--process_pass-->\n";
								}
					mysql_close($con);
				} //process
		}//ori if-is daxurva tavshi rom uweria
		else
		{
			if(isset($_GET["state"])){
				$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
				if($state=='insert_cat')
				{
				?>
				<form action="?admin=common&amp;state=<?php echo $state; ?>&amp;process=insert_cat" method="post" enctype="multipart/form-data" class='insert_update_data'>
				<fieldset>
				<legend>კატეგორიის დამატება</legend>
				<label for="title">დასახელება</label>
				<input type="text" name="title" id="title" size="50" />
				<div class='submit'><input type="submit" value="Insert data" /></div><!--submit-->
				</fieldset>
				</form>
		<?php 
		}
		}
	} 
	echo "</div><!--center-->\n";
}
else
{
	header("../login.php");
}
?>
