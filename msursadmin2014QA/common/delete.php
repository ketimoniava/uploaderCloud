<?php
if(isset($_SESSION["isadmin"]))
{
	$admin_cat=mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
	if($admin_cat=='common')
	{
		if(isset($_GET["catid"]))
		{
			$categoryid = mysql_real_escape_string(stripslashes(trim(@$_GET["catid"])));
			if(isset($_GET["item"]))
			{
				include "conns/connection.php";
				$tableName = 'common';
				$itemId = mysql_real_escape_string(stripslashes(trim(@$_GET["item"])));
				$result = mysql_query("SELECT * FROM common WHERE id='".$itemId."' ");
				if(mysql_num_rows($result)>0)
				{
					$row = mysql_fetch_array($result);
					if(isset($_GET["state"])){
						$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
						if($state == 'delete')
							{
								if(isset($_GET["process"]))
								{
									$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
									if($process == 'delete')
									{
										$result = mysql_query("SELECT id, pagetitle, bodytext FROM ".$tableName." WHERE id='".$itemId."'");
										$row = mysql_fetch_array($result);
										$filenameResult = mysql_query("SELECT filename FROM ".$tableName."photos WHERE relId='".$itemId."'");
										while (	$filenameRow = mysql_fetch_array($filenameResult)){
											if(file_exists("../prv/".$tableName."/original/".$filenameRow["filename"])){
												unlink("../prv/".$tableName."/original/".$filenameRow["filename"]);
											}
											if(file_exists("../prv/".$tableName."/small/".$filenameRow["filename"])){
												unlink("../prv/".$tableName."/small/".$filenameRow["filename"]);
											}
										}
										$pagetitle = $row["pagetitle"];
										echo "<div class='process_pass'>\n";
										echo "<h3><strong>".$pagetitle."</strong> წაშლილია</h3>\n";
										echo "<p class='backward'><a href=\"?admin=common&amp;catid=".$categoryid."\">უკან დაბრუნება</a></p>\n";
										echo "</div><!--process_pass-->\n";
										$sql = mysql_query("DELETE FROM ".$tableName."photos WHERE relId='".$row["id"]."'");
										$sql = mysql_query("DELETE FROM ".$tableName." WHERE id='".$itemId."'");
										exit("<meta http-equiv='refresh' content='0; url=?admin=common&amp;catid=".$categoryid."'>");
									}//process==delete
								}//isset process
								else
								{
									echo "<div class='delete_data'>\n";
									echo "<h3><strong>".$row["pagetitle"]."</strong> წაშლა</h3>\n";
									echo "<p class='no'><a href=\"?admin=common&amp;catid=".$categoryid."\"><img src='images/no-botton.png' alt='არა' /></a></p>\n";
									echo "<p class='yes'><a href=\"?admin=common&amp;state=delete&amp;process=delete&amp;catid=".$categoryid."&amp;item=".$row["id"]."\"><img src='images/yes-botton.png' alt='დადასტურება' /></a></p>\n";
									echo "</div><!--delete_data-->\n";
								}// else isset process
						}//state==delete
					}//isset state
				}//num rows>0
			}//isset cid
		}//isset catid
	}//admin==common
}//isset isadmin
else
{
	header("../login.php");
}
?>