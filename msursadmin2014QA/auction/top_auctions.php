<?php
if(isset($_SESSION["isadmin"]))
{
	include "../conns/connection.php";
	//echo "<p><a href=''>რეიტინგული პროდუქტები</a></p>\n";
	$itemPerPage=5;
	 if(isset($_GET["pg"]))
	 {
		$activePage = mysql_real_escape_string(stripslashes(trim(@$_GET["pg"])));
		$startFrom = ($activePage-1)*$itemPerPage;
		$limit = $startFrom.", ".$itemPerPage;
	 }
	else
	{ 
		$activePage=1;
		$limit = ($activePage-1).", ".$itemPerPage; 
	}

	$resultProducts = mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.id as auctionID, auction.prodID, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), auction.top_bid FROM products, auction WHERE auction.prodID=products.id AND auction.state='2' ORDER BY tilldate DESC LIMIT ".$limit." ", $con);
	if(mysql_num_rows($resultProducts)>0)
	{
		//echo mysql_num_rows($result_bids);
		echo "<div class='top_auctions'>\n";
		echo "<h2>დასრულებული აუქციონები</h2>\n";
		include "products/filter_info.php";
		//include "products/productsWhile.php";
		while($rowProducts = mysql_fetch_array($resultProducts))
		{
			$startdate = date("Y-m-d H:i:s",  $rowProducts["UNIX_TIMESTAMP(startdate)"]);
			$tilldate = date("Y-m-d H:i:s", $rowProducts["UNIX_TIMESTAMP(tilldate)"]);
			echo "<div class='auctionProducts'>\n";
			echo "\t<h3><a href='?admin=products&amp;prod=".$rowProducts["id"]."&amp;auc=".$rowProducts["auctionID"]."'>".$rowProducts["headline"]."</a></h3>\n";
			echo "<p class='dates'>\n";
			echo "<p>დაწყება: <span>".$startdate."</span></p>\n";
			echo "<p>დასრულება: <span>".$tilldate."</span></p>\n";
			echo "</p><!--restdates-->\n";
			echo "</div><!--auctionProducts-->\n";
		}
		echo "</div><!--top_auctions-->\n";
	}
}
else
{
	header("../login.php");
}
?>