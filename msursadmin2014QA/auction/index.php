<?php
if(isset($_SESSION["isadmin"]))
{
	include "auction/products-left.php"; 
	echo "<div class='center'>\n";
	$itemPerPage = 20;
	if(isset($_GET["pg"]))
	{
		$activePage = mysql_real_escape_string(stripslashes(trim(@$_GET["pg"])));
		$startFrom = ($activePage-1)*$itemPerPage;
		$limit = $startFrom.", ".$itemPerPage;
	}
	else
	{ 
		$activePage = 1;
		$limit = ($activePage-1).", ".$itemPerPage; 
	}
	if(isset($_GET["prod_cat"]))
	{
	 $order;
		$prod_cat = mysql_real_escape_string(stripslashes(trim(@$_GET["prod_cat"])));
		if(isset($_GET["sub_cat"]))
		{	
			if(isset($_GET["auction"]))
			{
				$auction = mysql_real_escape_string(stripslashes(trim(@$_GET["auction"])));
				//$where1;
				$resultProducts=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, UNIX_TIMESTAMP(products.add_date) as add_date, products.products_types, products.prod_sub_tp_id, products.brandID, products.cond, products.hasphoto, products.hasauction, products.state as state, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.products_types='".$prod_cat."' AND products.prod_sub_tp_id='".$sub_cat."'  ".$where1." AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." LIMIT ".$limit." ", $con);
			}
			else
			{
				$resultProducts=mysql_query("SELECT id as prodID, headline, shortsummary, bodytext, UNIX_TIMESTAMP(add_date) as add_date, hasphoto, hasauction, state  FROM products WHERE products_types='".$prod_cat."' AND cond LIKE '".$condition."' AND prod_sub_tp_id='".$sub_cat."'   ".$where." ORDER BY id DESC LIMIT ".$limit." ", $con);
			}
			//$resultProducts = mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.products_types='".$prod_cat."' AND products.prod_sub_tp_id='".$sub_cat."'".$where."  AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." LIMIT ".$limit." ", $con);
			//$resultProducts=mysql_query("SELECT id, headline, shortsummary, products.bodytext, products_types, prod_sub_tp_id, brandID, hasphoto FROM products WHERE products_types='".$prod_cat."' AND prod_sub_tp_id='".$sub_cat."' ORDER BY id DESC LIMIT ".$limit." ", $con);
			echo "<h2>ლოტები</h2>\n";
		}
		else
		{
			if(isset($_GET["auction"]))
			{
				//$where1;
				$resultProducts=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, UNIX_TIMESTAMP(products.add_date) as add_date, products.products_types, products.prod_sub_tp_id, products.brandID, products.cond, products.hasphoto, products.hasauction, products.state as state, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.products_types='".$prod_cat."'  ".$where1." AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." LIMIT ".$limit." ", $con);
			}
			else
			{
				$resultProducts=mysql_query("SELECT id as prodID, headline, shortsummary, bodytext, UNIX_TIMESTAMP(add_date) as add_date, hasphoto, hasauction, state  FROM products WHERE products_types='".$prod_cat."' AND cond LIKE '".$condition."'  ".$where." ORDER BY id DESC LIMIT ".$limit." ", $con);
			}
			
			//$resultProducts = mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.products_types='".$prod_cat."' ".$where." AND products.cond LIKE '".$condition."' AND auction.prodID=products.id ORDER BY ".$order." LIMIT ".$limit." ", $con);
			//$resultProducts=mysql_query("SELECT id, headline, shortsummary, products.bodytext, products_types, prod_sub_tp_id, brandID, hasphoto FROM products WHERE products_types='".$prod_cat."' ORDER BY id DESC LIMIT ".$limit." ", $con);
			echo "<h2>ლოტები</h2>\n";
		}
	}
	else
	{				
		if(isset($_GET["auction"]))
		{
			//$where1;
			$resultProducts=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, UNIX_TIMESTAMP(products.add_date) as add_date, products.products_types, products.prod_sub_tp_id, products.brandID, products.cond, products.hasphoto, products.hasauction, products.state as state, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.cond LIKE '".$condition."' ".$where1."  AND auction.prodID=products.id ORDER BY ".$order." LIMIT ".$limit."   ", $con);
		}
		else
		{
			$resultProducts=mysql_query("SELECT id as prodID, headline, shortsummary, bodytext, UNIX_TIMESTAMP(add_date) as add_date, hasphoto, hasauction, state  FROM products WHERE cond LIKE '".$condition."'  ".$where." ORDER BY id DESC LIMIT ".$limit." ", $con);
		}

			//$resultProducts=mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, auction.id as auctionID, auction.prodID, auction.top_bid, auction.state FROM products, auction WHERE products.cond LIKE '".$condition."' AND auction.prodID=products.id  ".$where." ORDER BY ".$order." LIMIT ".$limit." ", $con);
		//$resultProducts=mysql_query("SELECT id, headline, shortsummary, products.bodytext, products_types, prod_sub_tp_id, brandID, hasphoto FROM products ORDER BY id DESC LIMIT ".$limit." ", $con);
		/*echo "<ul class='rel_nav'>\n";
		echo "<li><a href='?admin=prod_cat&amp;show=2'>დასრულებული</a></li>\n";
		echo "<li><a href='?admin=prod_cat&amp;show=1'>აუქციონზე</a></li>\n";
		echo "<li><a href='?admin=prod_cat&amp;show=3'>გამოქვეყნებული</a></li>\n";
		//echo "<li><a href='?admin=products&amp;show=other'>სხვა</a></li>\n";
		echo "<li><a href='?admin=prod_cat&amp;show=%'>ყველა</a></li>\n";
		echo "</ul><!--rel_nav-->\n";*/
	}
	$items = mysql_num_rows($resultProducts);
		if($items>0)
		{
			include "products/productswhile.php";
		}
		else
		{
			echo "<h3>სამწუხაროდ მონაცემი არ მოიძებნა</h3>";
		}
		echo "</div><!--center-->\n";
}
else
{
	header("../login.php");
}
?>