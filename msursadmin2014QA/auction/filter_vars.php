<?php
//echo""
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
	$sort = mysql_real_escape_string(stripslashes(trim(@$_GET["sort"])));
	if($sort=='1')
	{
		$order='UNIX_TIMESTAMP(tilldate)';
		$desc=' DESC';
	}
	if($sort=='2')
	{
		$order='UNIX_TIMESTAMP(startdate)';
		$desc='';
	}
	if($sort == 5 or $sort==6)
	{
		$order = 'auction.rating';
		$desc='';
	}
	if($sort == 3 or $sort==4)
	{
		$order = 'auction.top_bid';
		$desc='';
	}
	if($sort == 4 or $sort==6)
	{
		$desc = ' DESC';
	}
	if($sort>6 or $sort<1)
	{
		$order='UNIX_TIMESTAMP(tilldate)';
		$desc=' DESC';
	}
	$order = $order.$desc;

}

if(isset($_GET["auction"]))
{
	$auction = mysql_real_escape_string(stripslashes(trim(@$_GET["auction"])));
	if($auction == 1)
	{
		$where= "AND (state='1' OR state='7' OR state='8')";
	}
	if($auction == 2)
	{
		$where = 'AND state=7';
	}
	if($auction ==3)
	{
		$where = 'AND state=8';
	}
	if($auction ==4)
	{
		$where1 = 'AND products.state=2';
	}
	if($auction!=1 and $auction!=2 and $auction!=3 and $auction!=4)
	{
		unset($auction);
		//$where="AND (auction.state='1' OR auction.state='3' OR auction.state='7' OR auction.state='8')";
		$where="AND (state='1' OR state='3' OR state='7' OR state='8')";
	}
}
else
{
	//$where="AND (auction.state='1' OR auction.state='3' OR auction.state='7' OR auction.state='8')";
	$where="AND (state='1' OR state='3' OR state='7' OR state='8')";
}


if(isset($_GET["auction"]))
{
	$auction = mysql_real_escape_string(stripslashes(trim(@$_GET["auction"])));
	if($auction == 1)
	{
		$where1 = "AND (products.state='1' OR products.state='7' OR products.state='8')";
	}
	if($auction == 2)
	{
		$where1 = 'AND products.state=7';
	}
	if($auction ==3)
	{
		$where1 = 'AND products.state=8';
	}
	if($auction ==4)
	{
		//echo "text";
		$where1 = 'AND products.state=2';
	}
	if($auction!=1 and $auction!=2 and $auction!=3 and $auction!=4)
	{
		unset($auction);
		//$where="AND (auction.state='1' OR auction.state='3' OR auction.state='7' OR auction.state='8')";
		$where1="AND (products.state='1' OR products.state='3' OR products.state='7' OR products.state='8')";
	}
}
else
{
	//$where="AND (auction.state='1' OR auction.state='3' OR auction.state='7' OR auction.state='8')";
	$where1="AND (products.state='1' OR products.state='3' OR products.state='7' OR products.state='8')";
}
?>