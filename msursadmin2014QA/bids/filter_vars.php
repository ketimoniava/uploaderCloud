<?php
$prod_cat=mysql_real_escape_string(stripslashes(trim(@$_GET["pr_cat"])));
if(isset($_GET["condition"]))
{
	$condition=mysql_real_escape_string(stripslashes(trim(@$_GET["condition"])));
}
else
{
	$condition='%';
}
$order='auction.published DESC';
if(isset($_GET["sort"]))
{
$sort=mysql_real_escape_string(stripslashes(trim(@$_GET["sort"])));
if($sort==3 or $sort==4)
{
	$order='auction.rating';
}
if($sort==1 or $sort==2)
{
	$order='auction.top_bid';
}
if($sort==2 or $sort==4)
{
	$desc=' DESC';
}
else
{
	$desc='';
}
$order=$order.$desc;
}
if(isset($_GET["auction"]))
{
	$auction=mysql_real_escape_string(stripslashes(trim(@$_GET["auction"])));
	if($auction==1)
	{
		$where="AND (auction.state='1' OR auction.state='8')";
	}
	if($auction==2)
	{
		$where='AND auction.state=7';
	}
	if($auction==3)
	{
		$where='AND auction.state=8';
	}
}
else
{
	$where="AND (auction.state='1' OR auction.state='3' OR auction.state='7' OR auction.state='8')";
}

?>