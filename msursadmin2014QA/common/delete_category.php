<?php
	if(isset($_GET["state"])){
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	if($state=='delete_cat')
	{
		//echo "sadsad";
		include "../conns/connection.php";
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
			if($process=="delete_cat"){
			echo "<div class='process_pass'>\n";
			echo "<h3><strong>".$title."</strong> წაშლილია</h3>\n";
			echo "<p class='backward'><a href=\"?admin=common\">უკან დაბრუნება</a></p>\n";
			echo "</div><!--process_pass-->\n";
									
			$resultCommon =mysql_query("SELECT * FROM common WHERE categoryid=".$row["id"]." ");
			$rowCommon= mysql_fetch_array($resultCommon);
			if($rowCommon["hasphoto"]=='1')
				{
					$resultPhotos =mysql_query("SELECT * FROM commonphotos WHERE relid=".$rowCommon["id"]." ");
					while ($rowPhotos= mysql_fetch_array($resultPhotos))
					{
						if(file_exists("../photos/common/original/".$rowPhotos["filename"])){
							unlink("../photos/common/original/".$rowPhotos["filename"]);}
						if(file_exists("../photos/common/small/".$rowPhotos["filename"])){
						unlink("../photos/common/small/".$rowPhotos["filename"]);	}
						$sql=mysql_query("DELETE FROM commonphotos WHERE id='".$rowPhotos["id"]."'");
					}
					
			}
			$sql=mysql_query("DELETE FROM common WHERE id='".$rowCommon["id"]."'");
			$sql=mysql_query("DELETE FROM categories WHERE id='".$row["id"]."'");
			exit("<meta http-equiv='refresh' content='1; url=?admin=common'>");
			//echo "<div>".$rowCommon["title"]."</div> <p>have been <strong>deleted</strong>from data base</p>";
		}//process delete
	}//process
	else
	{
		echo "<div class='delete_data'>\n";
		echo "<h3>კატეგორიის <strong>".$title."</strong> წაშლა</h3>\n";
		echo "<p class='no'><a href=\"?admin=common&amp;catid=".$categoryid."\"><img src='images/no-botton.png' alt='არა' /></a></p>\n";
		echo "<p class='yes'><a href=\"?admin=common&amp;state=delete_cat&amp;process=delete_cat&amp;catid=".$catid."\"><img src='images/yes-botton.png' alt='დადასტურება' /></a></p>\n";
		echo "</div><!--delete_data-->\n";
	}// else isset process
}//result
}//catid
	}//deletcat
}//stae
?>