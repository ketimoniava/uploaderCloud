<?php
if(isset($_SESSION["isadmin"]))
{
	echo "<div class='bidding'>\n";
	echo "<h1>განაცხადები1</h1>\n";
	while($rowProducts=mysql_fetch_array($resultProducts))
	{
		$bid = $rowProducts["bid"];
		$auctionID = $rowProducts["auctionID"];
		$prodID = $rowProducts["prodID"];
		$userID  = $rowProducts["userID"];
		$algo = 'sha256';
		$data = "usercheck".$userID;
		$hashcode = hash($algo , $data[$raw_output = false]);
		$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$userID.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		$resultcode = $xml->result;
		$mobile = (string)$xml->info->mobile;
		$email =  (string)$xml->info->email;
		$u_id =  (string)$xml->info->u_id;
		$username=  (string)$xml->info->username;
		$bid_date=date("H:i d-m-Y ", $rowProducts["UNIX_TIMESTAMP(bid_date)"]);
		//$select_bids=mysql_query("SELECT * FROM bids WHERE prodID='".$rowProducts["prodID"]."' AND isMax='0' AND cancel='0' ");
		//$number_bids=mysql_num_rows($select_bids);
		//echo "<p class='bids'>".$number_bids." განაცხადი <span>მომხმარებელი: <a href='?admin=users&amp;user_id=".$row_user["id"]."'><strong>".$row_user["username"]." </strong></a></span></p>\n";
		echo "<div class='bid_notes'>\n";
		echo "<p>მომხმარებელმა <a href='?admin=users&amp;user_id=".$u_id."'><strong>".$username." </strong></a>  გააკეთა განაცხადი აუქციონზე , აუქციონის N: 
		<a href='?admin=products&amp;prod=".$prodID."&amp;auc=".$auctionID."'><strong>".$auctionID."</strong></a> განაცხადი: <strong>".$bid."L</strong>   თარ: ".$bid_date."</p>\n";
		echo "</div><!--bid_notes-->\n";
		/*if($rowProducts["state"]==0)
		{
		echo "<div class='auctionProducts' style='background: #ebebeb;'>\n";
		}
		else
		{
			echo "<div class='auctionProducts'>\n";
		}
		echo "\t<h3><a href='?admin=products&amp;state=update&amp;prod_cat=".$rowProducts["products_types"]."&amp;sub_cat=".$rowProducts["prod_sub_tp_id"]."&amp;prod=".$rowProducts["prodID"]."'>".$rowProducts["headline"]."</a></h3>\n";
		if($rowProducts["hasphoto"]=='1')
		{
			$productsPhotos=mysql_query("SELECT * FROM productsphotos WHERE relid='".$rowProducts["prodID"]."' ORDER BY id LIMIT 1");
			$rowProductsPhotos=mysql_fetch_array($productsPhotos);
			echo "\t<p class='shortsummary'><a href='?admin=products&amp;state=update&amp;prod_cat=".$rowProducts["products_types"]."&amp;sub_cat=".$rowProducts["prod_sub_tp_id"]."&amp;prod=".$rowProducts["prodID"]."'><img src='../photos/products/small/".$rowProductsPhotos["filename"]."' width='100px' alt='".$rowProducts["headline"]."' />".strip_tags($rowProducts["shortsummary"])." </a></p>\n";
		}
		else
		{
			//echo "\t<p class='shortsummary'>".strip_tags($rowProducts["start_price"])."</p>\n";
			echo "\t<p class='shortsummary'><a href='?admin=products&amp;state=update&amp;prod_cat=".$rowProducts["products_types"]."&amp;sub_cat=".$rowProducts["prod_sub_tp_id"]."&amp;prod=".$rowProducts["prodID"]."'>".strip_tags($rowProducts["shortsummary"])." </a></p>\n";
		}
		$select_auction = mysql_query("SELECT id, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), prodID, per_price, auct_start_price,	reserve,	quote FROM auction WHERE prodID='".$rowProducts["prodID"]."' ORDER BY tilldate DESC LIMIT 1");
		$row_auction=mysql_fetch_array($select_auction);
		$startdate=date("Y-m-d H:i:s",  $row_auction["UNIX_TIMESTAMP(startdate)"]);
		$tilldate=date("Y-m-d H:i:s", $row_auction["UNIX_TIMESTAMP(tilldate)"]);
		//echo $rowProducts[3];
		$select_user=mysql_query("SELECT * FROM users WHERE id='".$rowProducts["userID"]."' ");
		$row_user=mysql_fetch_array($select_user);
		$select_bids=mysql_query("SELECT * FROM bids WHERE prodID='".$rowProducts["prodID"]."' AND isMax='0' AND cancel='0' ");
		$number_bids=mysql_num_rows($select_bids);
		echo "<p class='bids'>".$number_bids." განაცხადი <span>მომხმარებელი: <a href='?admin=users&amp;user_id=".$row_user["id"]."'><strong>".$row_user["username"]." </strong></a></span></p>\n";
		$select_max_bid=mysql_query("SELECT * FROM bids WHERE prodID='".$rowProducts["prodID"]."' AND isMax='0' AND cancel='0' ORDER BY id DESC LIMIT 1");
		$number_max_bid=mysql_num_rows($select_max_bid);
		$max_bid=mysql_fetch_array($select_max_bid);
		if($number_max_bid>0)
		{
			$maxbid=$max_bid["bid"];
		}
		else
		{
			$maxbid='0';
		}

		echo "<p class='start_price'><span>საწყისი ფასი: <strong>".$row_auction["auct_start_price"]." </strong>ლარი</span><br /><span>მიმდინარე: <strong>".$rowProducts["bid"]." </strong>ლარი</span></p>\n";

		//&& $tilldate>$currentDate

		if($startdate>$currentDate )
		{
			echo "<p class='restdates'>\n";
			echo "<p>დაწყება: <span>".$startdate."</span></p>\n";
			//echo "<p>დასრულება:<br /> <span>".date("Y-m-d", $rowProducts["UNIX_TIMESTAMP(tilldate)"])."</span></p>\n";
			echo "</p>\n";
		}

		if($currentDate>$startdate&&$currentDate< $tilldate)
		{
			getRestedDateOfAuction($row_auction["UNIX_TIMESTAMP(tilldate)"]);
		}
		if($currentDate>$tilldate)
		{
			echo "<p class='restdates'>\n";
			echo "<p>დაწყება: <span>".$startdate."</span></p>\n";
			echo "<p>დასრულება:<br /> <span>".$tilldate."</span></p>\n";
			echo "</p>\n";
		}

		echo "<div><a href='?admin=products&amp;state=delete&amp;prod_cat=".$rowProducts["products_types"]."&amp;sub_cat=".$rowProducts["prod_sub_tp_id"]."&amp;prod=".$rowProducts["prodID"]."' class='deleteText'><abbr title='წაშლა'><img src='../images/delete.png' alt='წაშლა' />წაშლა</abbr></a></div>\n";
		echo "</div><!--auctionProducts-->\n";
		*/

	}

	echo "</div><!--bidding-->\n";

	if(isset($_GET["admin"]))
	{
	if(isset($_GET["prod_cat"]))
	{
		if(isset($_GET["sub_cat"]))
		{
			$productsNum=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.prodID, auction.top_bid, auction.state  FROM products, auction WHERE products.products_types='".$prod_cat."' AND products.prod_sub_tp_id='".$sub_cat."' AND auction.state LIKE '".$show."'  AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." ", $con);
		}
		else
		{
			//products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.prodID, auction.top_bid
			$productsNum=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.products_types='".$prod_cat."' AND auction.state LIKE '".$show."'  AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order."  ", $con);
		}
	}
	else
	{
		$productsNum=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE auction.state LIKE '".$show."'  AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." ", $con);
	}
	if(isset($_GET["show"]))
	{
		$show='&amp;show='.mysql_real_escape_string(stripslashes(trim(@$_GET["show"]))).'';
	}
	else
	{
		$show='';
	}
	}
	else
	{
		$show='5';
		$productsNum=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE auction.state LIKE '".$show."'  AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." ", $con);
	}
	$items = mysql_num_rows($productsNum);
	$pages = ceil($items / ($itemPerPage));
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$itemPerPage=1;
	if(isset($_GET["pg"]))
	{
		$pg = mysql_real_escape_string(stripslashes(trim(@$_GET["pg"])));
		$replaced_actual_link1 = str_replace("&pg=".$pg."",'',$actual_link);
		$replaced_actual_link = str_replace("&",'&amp;',$replaced_actual_link1);
	} 
	else { $pg=1; $replaced_actual_link=$actual_link; }
	if(isset($_GET["admin"]))
	{
		$replaced_actual_link = $replaced_actual_link."&amp;";
	}
	else
	{
		$replaced_actual_link1 = str_replace("?pg=".$pg."",'',$replaced_actual_link);
		$replaced_actual_link = $replaced_actual_link1."?";
	}
	if($pages>1)
	{
		echo "<ul class='navigate'>\n";
		if($activePage!=1)
			{
				echo "\t<li class='goto'><a href='".$replaced_actual_link."pg=".($pg-1)."'><img src='../images/prev.png' alt='preview'></a></li>\n"; 
			}//if
			for($i=1; $i<=$pages; $i++){
				if ($activePage==$i)
				{
					echo "\t<li class='active-page'>".$i."</li>\n";
				}
				else
				{
					if(($i<$activePage+10)&&($activePage-10<$i))
					{
						echo "\t<li><a href='".$replaced_actual_link."pg=".$i."'>".$i."</a></li>\n";
					}
					else
					{
						echo "\t<li><a href='".$replaced_actual_link."pg=".$i."'>".$i."</a></li>\n";
					}//else
				}//ELSE
			}//for
			if($activePage<$pages)
			{
				if($pages!=1)
				{
					echo "\t<li class='goto'><a href='".$replaced_actual_link."pg=".($pg+1)."'><img src='../images/next.png' alt='next'></a></li>\n";
				}
			}
		echo "</ul><!--navigate-->\n";
	}
}
else
{
	header("../login.php");
}
?>