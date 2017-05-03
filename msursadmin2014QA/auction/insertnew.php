<?php
include "../../conns/connection.php";
$currentDate=date("Y-m-d");
$currentTime=date("H:i:s"); 
$showform = false;
if(isset($_POST["auction"]) &&isset($_POST["startdate1"]) &&isset($_POST["tilldate1"]) &&isset($_POST["price"])&&isset($_POST["start_price"])&&isset($_POST["reserve"]) &&isset($_POST["quote"])&&isset($_POST["currency"]))
{
	$prod = mysql_real_escape_string(stripslashes(trim(@$_POST["auction"])));
	$result = mysql_query("SELECT products.id, products.headline, products.shortsummary, products.bodytext, products.products_types, products.prod_sub_tp_id, products.brandID, products.hasphoto, products.userID, products.cond, auction.id as auctionID, auction.prodID, auction.main, auction.top_bid, auction.state FROM products, auction WHERE auction.prodID=products.id AND products.id='".$prod."' AND (auction.state='1' or auction.state='3' or auction.state='7' or auction.state='8') ", $con);
	if(mysql_num_rows($result)>0)
	{
		$auctionadd = false;
	} else { $auctionadd = true; }
		if($auctionadd == true){
		$row = mysql_fetch_array($result);
		$startdate = mysql_real_escape_string(stripslashes(trim(@$_POST["startdate1"])));				
		$tilldate = mysql_real_escape_string(stripslashes(trim(@$_POST["tilldate1"])));
		$price = mysql_real_escape_string(stripslashes(trim(@$_POST["price"])));
		$start_price = mysql_real_escape_string(stripslashes(trim(@$_POST["start_price"])));
		$reserve = mysql_real_escape_string(stripslashes(trim(@$_POST["reserve"])));
		$quote = mysql_real_escape_string(stripslashes(trim(@$_POST["quote"])));
		$currency = mysql_real_escape_string(stripslashes(trim(@$_POST["currency"])));
		$starttimestamp = strtotime($startdate);
		$tilltimestamp = strtotime($tilldate);
		//strtotime($startdate)
		$startdate = date('Y-m-d H:i:s', $starttimestamp);
		$tilldate = date('Y-m-d H:i:s', $tilltimestamp);
		if(!empty($startdate)&&!empty($tilldate)&&!empty($price)&&!empty($start_price)&&!empty($quote))
		{
			//echo "<p class='error_text'>სამწუხაროდ, აუქციონი არ დაემატა, აუქციონის ვადები არასწორად არის მითითებული</p>\n";
			if(($startdate<$tilldate) && ($startdate>=$currentDate))
			{
				$sql_auction = mysql_query("INSERT INTO auction (startdate, tilldate, prodID, per_price, auct_start_price, reserve, quote, currency) VALUES ('".$startdate."','".$tilldate."','".$prod."','".$price."','".$start_price."','".$reserve."','".$quote."','".$currency."') ");
				if($sql_auction)
				{
					$sql_auction_add = mysql_insert_id();
					$auctionID = $sql_auction_add;
					echo "<p class='auction_add'>აუქციონი დამატებულია</p>\n";
					if($startdate <= $currentDate && $tilldate>=$currentDate)
					{
						$sql_prod = mysql_query("UPDATE auction SET state='1' WHERE id='".$auctionID."' ");
					}
					if($startdate<$currentDate && $tilldate<$currentDate)
					{
						$sql_prod = mysql_query("UPDATE auction SET state='2' WHERE id='".$auctionID."' ");
					}
					if($startdate>$currentDate && $tilldate>$currentDate)
					{
						$sql_prod = mysql_query("UPDATE auction SET state='3' WHERE id='".$auctionID."' ");
					}
					include "../../mailer/mail_logger.php";
					include "../../mailer/class.phpmailer.php";
					include "../webservice.php";
				}
				else
				{
					echo "<p class='error_text'>სამწუხაროდ, აუქციონი არ დაემატა კიდევ სცადეთ</p>\n";
					//include "auction_form.php";	
					$showform = true;
				}
			}
			else
			{
				echo "<p class='error_text'>სამწუხაროდ, აუქციონი არ დაემატა, აუქციონის ვადები არასწორად არის მითითებული</p>\n";
				//include "auction_form.php";	
				$showform = true;
			}
		}
		else
		{
			echo "<p class='error_text'>შეავსეთ ყველა ველი</p>\n";
			echo "<p class='error_text'>სავალდებულო ველები აღნიშნულია სიმბოლოთი *</p>\n";
			//include "auction_form.php";
			$showform = true;
		}
	}//auctionadd
	else
	{
		echo "<p class='error_text'>სამწუხაროდ, აუქციონი არ დაემატა, რადგან ლოტზე ნებადართული არ არის აუქციონის დამატება</p>\n";
		//include "auction_form.php";
		$showform = true;
	}
}//info get
else
{
	$showform = true;
	//include "auction_form.php";	
}
?>