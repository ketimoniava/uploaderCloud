<?php
$user_id=@$_GET["user_id"];
echo "<div class='left'>\n";
	echo "<ul class='menu'>";
	//echo '<li><a href="?admin=stores_cat&amp;state=insert">კატეგორიის დამატება</a></li>';
	//&amp;cat_id=".$st_cat_id."&amp;sub_cat_id=".$sub_cat_id."'
	echo "<li><a href='?admin=users&amp;regist=users'>მომხმარებლის დამატება</a></li>";
	//echo '<li><a href="?admin=news&amp;state=delete">წაშლა</a></li>\n';
	//echo '<li><a href="?admin=news&amp;state=update">რედაქტირება</a></li>\n';
	echo "</ul><!--menu-->"; 
echo "</div><!--left-->\n";
echo "<div class='center'>\n";

if(isset($_GET["process"]))
{
	if($_GET["process"]=='delete')
	{
		$tableName=@$_GET["admin"];		
		$resultUser = mysql_query("SELECT id, username FROM users WHERE id='".$user_id."'");
		$rowUser=mysql_fetch_array($resultUser);
		echo "<h3>მომხმარებელი ".$rowUser["username"]." წაშლილია</h3>\n";
		echo "<p><a href='?admin=users'>მომხმარებლებში დაბრუნება</a></p>\n";
		$resultUserBids= mysql_query("SELECT id, bid, userID FROM bids WHERE userID='".$user_id."'");
		if(mysql_num_rows($resultUserBids)>0)
		{
			while($rowUserBids=mysql_fetch_array($resultUserBids))
			{
				$sql=mysql_query("DELETE FROM  bids WHERE id='".$rowUserBids["id"]."' ");
			}
		}
		$sql=mysql_query("DELETE FROM  ".$tableName." WHERE id='".$rowUser["id"]."' ");
		
	}
}
else
{
echo "<h3>დარწმუნებული ხართ რომ გსურთ მომხმარებლის წაშლა?</h3>\n";
echo "<p><a href='?admin=users&amp;state=delete&amp;process=delete&amp;user_id=".$user_id."' class='deleteText'><img src='../images/yes-botton.png' alt='YES' /></a> <a href='?admin=users' class='deleteText'><img src='../images/no-botton.png' alt='NO' /></a></p>\n";
}
echo "</div><!--center-->\n";
?>