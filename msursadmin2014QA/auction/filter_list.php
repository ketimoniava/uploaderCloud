<?php
if(isset($con))
{
	if(isset($_GET["admin"]))
		{
			$admin=  mysql_real_escape_string(stripslashes(trim(@$_GET['admin'])));
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			if($admin=='auctions')
			{
			include "auction/filter_vars.php";
			echo  "<div class='filters'>\n";
			echo "<span>აუქციონი</span>\n";
			echo "<ul class='filter_list'>\n";
			if(isset($_GET["auction"]))
			{
				$auction=mysql_real_escape_string(stripslashes(trim(@$_GET["auction"])));
				$url="&auction=".$auction;
				//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
				$actual_get_link1 = str_replace($url, "", $actual_link);
				$actual_link_auction = str_replace("&", "&amp;", $actual_get_link1);
				if($auction==1)
				{
					echo "<li class='active_filter'><a href='".$actual_link_auction."'>ამჟამად აუქციონზე არსებული ლოტები</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_auction."&amp;auction=1'>ამჟამად აუქციონზე არსებული ლოტები</a></li>\n";
				}
				if($auction==2)
				{
					echo "<li class='active_filter'><a href='".$actual_link_auction."'>გამოქვეყნებულია 1-2 დღის წინ</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_auction."&amp;auction=2'>გამოქვეყნებულია 1-2 დღის წინ</a></li>\n";
				}
				if($auction==3)
				{
					echo "<li class='active_filter'><a href='".$actual_link_auction."'>აუქციონის დასრულებამდე დარჩენილია 1-2 დღე</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_auction."&amp;auction=3'>აუქციონის დასრულებამდე დარჩენილია 1-2 დღე</a></li>\n";
				}
				if($auction==4)
				{
					echo "<li class='active_filter'><a href='".$actual_link_auction."'>აუქციონი დასრულებულია</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_auction."&amp;auction=4'>აუქციონი დასრულებულია</a></li>\n";
				}
			}
			else
			{
				echo "<li><a href='".$actual_link."&amp;auction=1'>ამჟამად აუქციონზე არსებული ლოტები</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;auction=2'>გამოქვეყნებულია 1-2 დღის წინ</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;auction=3'>აუქციონის დასრულებამდე დარჩენილია 1-2 დღე</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;auction=4'>აუქციონი დასრულებულია</a></li>\n";
			}
			echo "</ul>\n";
			echo "<span>ლოტის მდგომარეობა</span>\n";
			echo "<ul class='filter_list'>\n";
			if(isset($_GET["condition"]))
			{
				$condition = mysql_real_escape_string(stripslashes(trim(@$_GET["condition"])));
				$url="&condition=".$condition;
				//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
				$actual_get_link2 = str_replace($url, "", $actual_link);
				$actual_link_cond = str_replace("&", "&amp;", $actual_get_link2);
				if($condition==1)
				{
					echo "<li class='active_filter'><a href='".$actual_link_cond."'>ახალი</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_cond."&amp;condition=1'>ახალი</a></li>\n";
				}
				if($condition==2)
				{
					echo "<li class='active_filter'><a href='".$actual_link_cond."'>მეორადი</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_cond."&amp;condition=2'>მეორადი</a></li>\n";
				}
			}
			else
			{
				echo "<li><a href='".$actual_link."&amp;condition=1'>ახალი</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;condition=2'>მეორადი</a></li>\n";
			}
			echo "</ul>\n";
			echo "<span>სორტირება</span>\n";
			echo "<ul class='filter_list'>\n";
			if(isset($_GET["sort"]))
			{
				$sort=mysql_real_escape_string(stripslashes(trim(@$_GET["sort"])));
				$url="&sort=".$sort;
				//$bodytag = str_replace("%body%", "black", "<body text='%body%'>");
				$actual_get_link3 = str_replace($url, "", $actual_link);
				$actual_link_sort = str_replace("&", "&amp;", $actual_get_link3);
				//$actual_link2=str_replace("&", "&amp;", $actual_get_link);
				if($sort==1)
				{
					//echo $actual_link;
					echo "<li class='active_filter'><a href='".$actual_link_sort."'>აუქციონის დასრულების თარიღის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=1'>აუქციონის დასრულების თარიღის მიხედვით</a></li>\n";
				}
				if($sort==2)
				{
					//echo $actual_link;
					echo "<li class='active_filter'><a href='".$actual_link_sort."'>აუქციონის დაწყების თარიღის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=2'>აუქციონის დაწყების თარიღის მიხედვით</a></li>\n";
				}
				if($sort==3)
				{
					echo "<li class='active_filter'><a href='".$actual_link_sort."'>ფასის ზრდადობის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=3'>ფასის ზრდადობის მიხედვით</a></li>\n";
				}
				if($sort==4)
				{
					echo "<li class='active_filter'><a href='".$actual_link_sort."'> ფასის კლებადობის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=4'> ფასის კლებადობის მიხედვით</a></li>\n";
				}
				if($sort==5)
				{
					echo "<li class='active_filter'><a href='".$actual_link_sort."'>რეიტინგის ზრდადობის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=5'>რეიტინგის ზრდადობის მიხედვით</a></li>\n";
				}
				if($sort==6)
				{
					//echo $actual_link;
					echo "<li class='active_filter'><a href='".$actual_link_sort."'>რეიტინგის კლებადობის მიხედვით</a></li>\n";
				}
				else
				{
					echo "<li><a href='".$actual_link_sort."&amp;sort=6'>რეიტინგის კლებადობის მიხედვით</a></li>\n";
				}
			}
			else
			{
				$sort='date';
				echo "<li><a href='".$actual_link."&amp;sort=1'>აუქციონის დასრულების თარიღის მიხედვით</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;sort=2'>აუქციონის დაწყების თარიღის მიხედვით</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;sort=3'>ფასის ზრდადობის მიხედვით</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;sort=4'> ფასის კლებადობის მიხედვით</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;sort=5'>რეიტინგის ზრდადობის მიხედვით</a></li>\n";
				echo "<li><a href='".$actual_link."&amp;sort=6'>რეიტინგის კლებადობის მიხედვით</a></li>\n";
			}
			echo "</ul>\n";
			echo  "</div>\n";
			echo "<div class='show_all_products'><a href='?cat=products&amp;show_all'>იხილეთ ყველა ლოტი</a></div>\n";
			}//cat==products
		}//isset cat
	/*
	$select=mysql_query("SELECT * FROM reklama WHERE block='4' ", $con);
	$select or exit("Error".mysql_error());
	if(mysql_num_rows($select)>0)
	{
		echo "<ul class='banners'>\n";
		while($row_reklama=mysql_fetch_array($select))
		{
			echo "<li><a href='".$row_reklama["link"]."' target='_blank'><img src='photos/reklama/small/".$row_reklama["filename"]."' width='200px' alt='' /></a></li>\n";
		}
		 echo "</ul><!--banners-->\n";
	}
	*/
}//isset con
?>