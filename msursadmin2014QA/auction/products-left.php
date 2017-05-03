<?php
if(isset($_GET["admin"]))
{
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$admin = mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
if($admin=='auctions')
	{
		echo "<div class='left'>\n";
		$top_categories = mysql_query("SELECT * FROM products_types ORDER BY headline LIMIT 5");
		if(mysql_num_rows($top_categories)>0)
		{
			//echo "<div class='prod_cat'>კატეგორიები</div><!--prod_cat-->\n";
			if(isset($_GET["prod_cat"]))
			{
				$prod_cat = mysql_real_escape_string(stripslashes(trim(@$_GET["prod_cat"])));
				$top_active_categories = mysql_query("SELECT * FROM products_types WHERE id='".$prod_cat."' ORDER BY headline LIMIT 5");
				if(mysql_num_rows($top_active_categories)>0)
				{
				$row_active_categories = mysql_fetch_array($top_active_categories);
				if($prod_cat==$row_active_categories["id"])
						{
							//echo "<li class='active_cat'><a href='?admin=products&amp;pr_cat=".$row_active_categories["id"]."'>".$row_active_categories["headline"]."</a>";
						}
						else
						{
							//echo "<li><a href='?admin=products&amp;pr_cat=".$row_active_categories["id"]."'>".$row_active_categories["headline"]."</a></li>\n";
						}
				}
			}
			if(mysql_num_rows($top_categories)>0)
			{
				echo "\t<ul class='left_categories'>\n";
				while($row_categories = mysql_fetch_array($top_categories))
				{
					if(isset($_GET["prod_cat"]))
					{
						$prod_cat = mysql_real_escape_string(stripslashes(trim(@$_GET["prod_cat"])));
						if($prod_cat==$row_categories["id"])
						{
							//echo "<li class='active_cat'><a href='?admin=auctions&amp;prod_cat=".$row_categories["id"]."'>".$row_categories["headline"]."</a>";
						}
						else
						{
							echo "<li><a href='?admin=auctions&amp;prod_cat=".$row_categories["id"]."'>".$row_categories["headline"]."</a>";
						}
					}
					else
						{
							echo "<li><a href='?admin=auctions&amp;prod_cat=".$row_categories["id"]."'>".$row_categories["headline"]."</a>";
						}
					if(isset($_GET["prod_cat"]))
					{
						$prod_cat=mysql_real_escape_string(stripslashes(trim(@$_GET["prod_cat"])));
						if($prod_cat==$row_categories["id"])
						{
							echo "<li class='active_cat'><a href='".$actual_link."' >".$row_categories["headline"]."</a>";
							$top_sub_categories=mysql_query("SELECT * FROM products_sub_types WHERE prod_tp_id='".$prod_cat."' ORDER BY headline");
							if(mysql_num_rows($top_sub_categories)>0)
							{
								echo "<ul>\n";
								while($row_sub_categories=mysql_fetch_array($top_sub_categories))
								{
									if(isset($_GET["sub_cat"]))
									{
									$sub_cat=mysql_real_escape_string(stripslashes(trim(@$_GET["sub_cat"])));
									$get_sb_cat='&sub_cat='.$sub_cat;
									$row_sb_cat='&sub_cat='.$row_sub_categories["id"];
									$actual_link_cat=str_replace($get_sb_cat, $row_sb_cat, $actual_link);
									$actual_link_cat=str_replace("&", "&amp;", $actual_link_cat);
									if($row_sub_categories["id"]==$sub_cat)
										{
											//href='?admin=products&amp;pr_cat=".$row_categories["id"]."'
											//'?admin=products&amp;pr_cat=".$row_categories["id"]."'
											echo "<li class='active_cat'><a href='".$actual_link_cat."'>".$row_sub_categories["headline"]."</a></li>\n";
										}
										else
										{
											//'?admin=products&amp;pr_cat=".$row_categories["id"]."&amp;sb=".$row_sub_categories["id"]."'
											echo "<li><a href='".$actual_link_cat."'>".$row_sub_categories["headline"]."</a></li>\n";
										}
									}
									else
									{
										$row_pr_cat='&prod_cat='.$prod_cat;
										$row_sb_cat=$row_pr_cat.'&sub_cat='.$row_sub_categories["id"];
										$actual_link_cat=str_replace($row_pr_cat, $row_sb_cat, $actual_link);
										$actual_link_cat=str_replace("&", "&amp;", $actual_link_cat);
										//href='?admin=products&amp;pr_cat=".$row_categories["id"]."&amp;sb=".$row_sub_categories["id"]."'
										//'?admin=products&amp;pr_cat=".$row_categories["id"]."&amp;sb=".$row_sub_categories["id"]."'
										echo "<li><a href='".$actual_link_cat."'>".$row_sub_categories["headline"]."</a></li>\n";
									}
								}//while
								echo "</ul>\n";
							}//if num rows>0
							echo "</li>\n";
						}//if prod_cat==row_categories
					}//if isset pr_cat
				}//while
				echo "\t</ul><!--left_categories-->\n";
			}}
			else
			{
			//echo "text";
			}
			include "auction/filter_list.php";
		echo "</div><!--left-->\n";
	}
}



?>
