<?php
if(isset($_SESSION["isadmin"]))
{
	echo "<div class='center'>\n";
	if(isset($_GET["state"])){
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	if($state=='update_cat')
	{
	if(isset($_GET["catid"]))
	{
	$catid = mysql_real_escape_string(stripslashes(trim(@$_GET["catid"])));
	$result =mysql_query("SELECT id, title FROM categories WHERE id=".$catid." AND tablename='common'  ");
	if(mysql_num_rows($result)>0)
	{
		$row= mysql_fetch_array($result);
		$title=$row["title"];
		if(isset($_GET["process"]))
			{
				$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
				if($process=="update_cat"){
						include "../conns/connection.php";
						$title = mysql_real_escape_string(stripslashes(trim(@$_POST["title"])));
						$langID=2;
						$emptyValue = 0; 
						if(empty($title)&&empty($title_eng)){ echo "<h3>თქვენ უნდა მიუთითოთ კატეგორიის <strong>დასახელება</strong></h3>\n"; $emptyValue = 1; 
							?>
					<form action="?admin=common&amp;state=<?php echo $state; ?>&amp;process=update_cat&amp;catid=<?php echo $catid; ?>" method="post" enctype="multipart/form-data" class='insert_update_data'>
					<fieldset>
					<legend>კატეგორიის დამატება</legend>
					<label for="title">დასახელება</label>
					<input type="text" name="title"  value="<?php echo $title; ?>" id="title" size="50" />
					<div class='submit'><input type="submit" value="Insert data" /></div><!--submit-->
					</fieldset>
					</form>
			<?php 
						}
							if($emptyValue){ exit; }
							else{ 
									$tableName="common";
									$result = "UPDATE categories SET title='".$title."' WHERE id='".$catid."' AND tablename='common' ";
									mysql_query($result, $con) or exit ('error'.mysql_error());
									echo "<div class='process_pass'>\n";
									echo "<p><h3><strong>".$title." </strong></h3>რედაქტირებულია მონაცემთა ბაზაში</p>\n";
									echo "<p class='backward'><a href=\"?admin=common&amp;catid=".$catid."\">უკან</a></p>\n";
									exit("<meta http-equiv='refresh' content='1; url=?admin=common&amp;catid=".$catid."'>");
									echo "</div><!--process_pass-->\n";
									}
						mysql_close($con);
					} //process
			}//ori if-is daxurva tavshi rom uweria
			else
			{

					?>
					<form action="?admin=common&amp;state=<?php echo $state; ?>&amp;process=update_cat&amp;catid=<?php echo $catid; ?>" method="post" enctype="multipart/form-data" class='insert_update_data'>
					<fieldset>
					<legend>კატეგორიის რედაქტირება</legend>
					<label for="title">დასახელება</label>
					<input type="text" name="title"  value="<?php echo $title; ?>" id="title" size="50" />
					<div class='submit'><input type="submit" value="update data" /></div><!--submit-->
					</fieldset>
					</form>
			<?php 
		
		} 
		echo "</div><!--center-->\n";
		}//result
		else
		{
			
		}
	}
		}
			}
}
else
{
	header("../login.php");
}
?>
