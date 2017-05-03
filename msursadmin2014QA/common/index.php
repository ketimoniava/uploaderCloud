<?php
if(isset($_SESSION["isadmin"]))
{
	echo "<h2>სტატიკური გვერდები</h2>\n
	<div class='left_block'>";

	$result = "SELECT id, title FROM categories WHERE tablename='common' ";
	$result = mysql_query($result) or exit('Error: '.mysql_error());
	echo "<ul class='menu'>\n";
	while($row = mysql_fetch_array($result))
	{
		echo "<li><a href=\"?admin=common&amp;catid=".$row['id']."\">".$row["title"]."</a> <a href=\"?admin=common&amp;state=update_cat&amp;catid=".$row['id']."\"><em>[რედაქტირება]</em></a> <a href=\"?admin=common&amp;state=delete_cat&amp;catid=".$row['id']."\"><em>[წაშლა]</em></a></li>\n";
	}
	echo "</ul>\n";
?>
<p class='insert_page'><a href="?admin=common&amp;state=insert_cat">კატეგორიის დამატება</a></p>
</div><!--left_block-->
<div class='center'>
<?php
if(isset($_GET["state"])){
	$state=mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	switch($state){
		case "insert":
			include "insert.php";
		break;
		case "delete":
			include "delete.php";
		break;
		case "update":
			include "update.php";
		break;
		case "insert_cat":
			include "insert_category.php";
		break;
		case "delete_cat":
			include "delete_category.php";
		break;
		case "update_cat":
			include "update_category.php";
		break;
		case "next":
			include "prev.php";
		break;
		case "prev":
			include "prev.php";
		break;
	}
}
else
{
	if(isset($_GET["catid"])&&!isset($_GET["state"]))
	{
		echo "<p class='insert_page'><a href='?admin=common&amp;state=insert'>გვერდის დამატება</a></p>\n";
		$categoryid = mysql_real_escape_string(stripslashes(trim(@$_GET["catid"])));
		$result = mysql_query("SELECT id, pagetitle, categoryid, hasphoto, UNIX_TIMESTAMP(published) FROM common WHERE categoryid='".$categoryid."' ORDER BY sort", $con);
		if(mysql_num_rows($result)>0)
		{
			$commonnumber=mysql_num_rows($result);
			echo "<ul class='update_list'>\n";
			echo "<table class='category' cellpadding='0px' cellspacing='0px'>\n";
			/*echo "<tr>";
			echo "<th>სათაური</th><th><img src='../images/update.png' alt='რედაქტირება' /></th><th><img src='../images/delete.png' alt='წაშლა' /></th>\n";
			echo "</tr>";*/
			$i=1;
			while($row = mysql_fetch_array($result))
			{
				if($i==$commonnumber)
				{
					echo "<tr>\n";
					echo "<td><a href='?admin=common&amp;state=update&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'>".$row["pagetitle"]."</a></td><td  class='redaqtText'>&nbsp;</td><td>&nbsp;</td><td  class='redaqtText'>&nbsp;</td><td class='redaqtText'><a href='?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><abbr title='შეცვლა'><img src='images/update.png' alt='რედაქტირება' /></abbr></a></td><td class='redaqtText'><a href='?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."' ><abbr title='წაშლა'><img src='images/delete.png' alt='წაშლა' /></abbr></a></td>\n";
					echo "</tr>\n";
				}
				else
				{				
					if($i == 1)
					{
						echo "<tr>\n";
						echo "<td><a href='?admin=common&amp;state=update&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'>".$row["pagetitle"]."</a></td><td  class='redaqtText'>&nbsp;</td><td class='redaqtText'><abbr title='მარჯვნივ'><a href='?admin=common&amp;state=next&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'><img src='images/next.png' alt='მარჯვნივ' /></a></abbr></td><td></td><td class='redaqtText'><a href='?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><abbr title='შეცვლა'><img src='images/update.png' alt='რედაქტირება' /></abbr></a></td><td class='redaqtText'><a href='?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."' ><abbr title='წაშლა'><img src='images/delete.png' alt='წაშლა' /></abbr></a></td>\n";
						echo "</tr>\n";
					}
					if($i == $commonnumber)
					{
						echo "<tr>\n";
						echo "<td><a href='?admin=common&amp;state=update&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'>".$row["pagetitle"]."</a></td><td  class='redaqtText'>&nbsp;</td><td>&nbsp;</td><td  class='redaqtText'><abbr title='მარცხნივ'><a href='?admin=common&amp;state=prev&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><img src='images/prev.png' alt='მარცხნივ' /></a></abbr></td><td class='redaqtText'><a href='?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><abbr title='შეცვლა'><img src='images/update.png' alt='რედაქტირება' /></abbr></a></td><td class='redaqtText'><a href='?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."' ><abbr title='წაშლა'><img src='.images/delete.png' alt='წაშლა' /></abbr></a></td>\n";
						echo "</tr>\n";
					}
					if($i!=1 && $i!=$commonnumber)
					{
						echo "<tr>\n";
						echo "<td><a href='?admin=common&amp;state=update&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'>".$row["pagetitle"]."</a></td><td  class='redaqtText'>&nbsp;</td><td class='redaqtText'><abbr title='მარჯვნივ'><a href='?admin=common&amp;state=next&amp;catid=".$row["categoryid"]."&amp;item=".$row["id"]."'><img src='images/next.png' alt='მარჯვნივ' /></a></abbr></td><td  class='redaqtText'><abbr title='მარცხნივ'><a href='?admin=common&amp;state=prev&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><img src='images/prev.png' alt='მარცხნივ' /></a></abbr></td><td class='redaqtText'><a href='?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><abbr title='შეცვლა'><img src='images/update.png' alt='რედაქტირება' /></abbr></a></td><td class='redaqtText'><a href='?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."' ><abbr title='წაშლა'><img src='images/delete.png' alt='წაშლა' /></abbr></a></td>\n";
						echo "</tr>\n";
					}
				}
				/*echo "<tr>\n";
				echo "<td><a href='?admin=prodcats&amp;prod_cat=".$row["id"]."'>".$row["pagetitle"]."</a></td><td  class='redaqtText'>&nbsp;</td><td  class='redaqtText'><abbr title='მარცხნივ'><a href='?admin=common&amp;state=prev&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><img src='images/prev.png' alt='მარცხნივ' /></a></abbr></td><td class='redaqtText'><a href='?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."'><abbr title='შეცვლა'><img src='images/update.png' alt='რედაქტირება' /></abbr></a></td><td class='redaqtText'><a href='?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."' ><abbr title='წაშლა'><img src='images/delete.png' alt='წაშლა' /></abbr></a></td>\n";
				echo "</tr>\n";*/
				/*if($row['hasphoto']){ $hasphoto = " (<strong>with photo</strong>)"; }else{ $hasphoto = ""; }
				echo "<li>".$row["pagetitle"]." ".date("F j, Y, g:i a", $row['UNIX_TIMESTAMP(published)'])." <a href=\"?admin=common&amp;state=update&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."\"><em>[რედაქტირება]</em></a> <a href=\"?admin=common&amp;state=delete&amp;catid=".$row['categoryid']."&amp;item=".$row['id']."\"><em>[წაშლა]</em></a>".$hasphoto."</li>\n";*/
				$i++;
			}
			echo "</table><!--update_list-->\n";
		}
		mysql_close($con);
	}
}
//echo "<div class='backward'><a href='javascript:history.back(1);'>უკან</a></div>\n";
echo "</div><!--center-->\n";
}
else
{
	header("login.php");
}
?>
