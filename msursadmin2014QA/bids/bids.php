<?php
include "bids/filter_vars.php";


$select_bids_number = mysql_query("SELECT bids.prodID, auction.id, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), auction.prodID, auction.state, bids.auctionID, UNIX_TIMESTAMP(bid_date), products.id, products.headline, products.shortsummary, products.products_types, products.prod_sub_tp_id,  products.hasphoto FROM auction, bids, products WHERE auction.id=bids.auctionID AND auction.prodID=products.id AND bids.prodID=auction.prodID AND products.id=bids.prodID ORDER BY bids.bid_date DESC  ");

$resultProducts = mysql_query("SELECT bids.prodID, bids.bid, auction.id, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), auction.prodID, auction.state, bids.auctionID, UNIX_TIMESTAMP(bid_date), bids.userID as userID, products.id, products.headline, products.shortsummary, products.products_types, products.prod_sub_tp_id,  products.hasphoto FROM auction, bids, products WHERE auction.id=bids.auctionID AND auction.prodID=products.id AND bids.prodID=auction.prodID AND products.id=bids.prodID  ORDER BY bids.bid_date DESC LIMIT ".$limit." ");

$items = mysql_num_rows($select_bids_number);
if($items>0)
{
	include "bids/bids_prods.php";
}

?>