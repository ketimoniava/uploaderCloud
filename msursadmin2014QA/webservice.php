<?php
if(isset($con))
{
	if(isset($pay))
	{
		if($pay == false)
		{
			$currentDate = date("Y-m-d H:i:s");
			$auction_states = mysql_query("SELECT id, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), prodID, reserve, state, top_bid, winner, payment FROM auction WHERE state<>'2'  ORDER BY id DESC");
			//echo mysql_num_rows($auction_states);
			$hasauction = 0;
			while($row_auction_states = mysql_fetch_array($auction_states))
			{
				//echo "auction ended";
				$auctionstate = 0;
				$published = date("Y-m-d H:i:s", $row_auction_states["UNIX_TIMESTAMP(published)"]);
				$startdate = date("Y-m-d H:i:s", $row_auction_states["UNIX_TIMESTAMP(startdate)"]);
				$tilldate = date("Y-m-d H:i:s", $row_auction_states["UNIX_TIMESTAMP(tilldate)"]);
				$prod = $row_auction_states["prodID"];
				$selectproducts = mysql_query("SELECT * FROM products WHERE id='".$prod."' AND state<>'6'  ");
				$row_products = mysql_fetch_array($selectproducts);
							
				$row_auction_states_id = $row_auction_states["id"];
				if($row_auction_states["state"]!=4 and $row_auction_states["state"]!=5 and $row_auction_states["state"]!=6)
				{   //echo "text";
					//AUQCIONI DAIWYO
					if($startdate<=$currentDate && $tilldate>=$currentDate)
					{
						$auctionstate = 1;
						$hasauction = 1;
						$sql_prod = mysql_query("UPDATE auction SET state='1' WHERE id='".$row_auction_states_id."' ");
					}
					//AUQCIONI GAMOQVEYNEBULIA DA JER DAWYEBULI AR ARIS
					if($startdate>$currentDate && $tilldate>$currentDate)
					{
						$auctionstate = 3;
						$hasauction = 1;
					}
						
					if($row_auction_states["state"]!=2 and $row_auction_states["state"]!=3 and $row_auction_states["state"]!=5 and $row_auction_states["state"]!=6)
					{
						$till_days = till_days($row_auction_states["UNIX_TIMESTAMP(tilldate)"]);
						if($till_days<=2)
						{
							$auctionstate = 8;
							$hasauction = 1;
							//$sql_prod = mysql_query("UPDATE auction SET state='8' WHERE id='".$row_auction_states_id."' ");
						}
						if($published < $currentDate && $startdate > $currentDate)
						{
							$date = $row_auction_states["UNIX_TIMESTAMP(startdate)"];
							$published_date = published_days($date);
							if($published_date<=2)
							{
								$auctionstate = 7;
								$hasauction = 1;
								$sql_prod = mysql_query("UPDATE auction SET state='7' WHERE id='".$row_auction_states_id."' ");
							}
						}
						//AUQCIONI DASRULDA
						if($startdate <= $currentDate &&  $tilldate<=$currentDate)
						{
							$auctionID = $row_auction_states["id"];
							$winner_user = mysql_query("SELECT * FROM bids WHERE auctionID='".$auctionID."' AND bid='".$row_auction_states["top_bid"]."' AND bid>'".$row_auction_states["reserve"]."' AND isMax='O' AND cancel='0' ORDER BY bid DESC LIMIT 1");
							if(mysql_num_rows($winner_user)>0)
							{ 
								$row_winner_user = mysql_fetch_array($winner_user);
								$winner = $row_winner_user["userID"];
								$sql_winner = mysql_query("UPDATE auction SET winner='".$winner."' WHERE id='".$auctionID."' ");
							} else { $winner = 0; }
							include "../mailer/send_notes_to_mail.php";
							//include "mailer_ended_auction.php";
							$auctionstate = 2;
							$sql_prod = mysql_query("UPDATE auction SET state='2' WHERE id='".$auctionID."' ");
							$hasauction = 0;
							$delete_views = mysql_query("DELETE FROM views WHERE auctionID='".$auctionID."' ");
							//$delete_products_in_bag("");
							$select_bids = mysql_query("SELECT * FROM bids WHERE auctionID='".$row_auction_states_id."' AND isMax='O' AND cancel='0' ORDER BY bid DESC LIMIT 1");
							if(mysql_num_rows($select_bids)>0)
							{
								$row_bids = mysql_fetch_array($select_bids);
								$prodID = $row_bids["prodID"];
								$topbid = $row_bids["bid"];
								if($row_auction_states["payment"] == 0)
								{
									$algo = 'sha256';
									$data = "usercheck".$row_bids["userID"];
									//bool $row_output
									$hashcode = hash($algo , $data[$raw_output = false]);
									$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$row_bids["userID"].'&hash='.$hashcode;
									$xml = simplexml_load_file($url);
									$resultcode = $xml->result;
									$u_id = (string)$xml->info->u_id;
									$mobile = (string)$xml->info->mobile;
									$email = (string)$xml->info->email;
									$winner = (string)$xml->info->username;
									$user_deposit = (string)$xml->info->deposit;
									$firstName = (string)$xml->info->first_name;

									if($user_deposit >= $topbid)
									{
										$new_deposit = ($user_deposit - $topbid);
										$amount = $topbid;
										$pay_auction_fee = mysql_query("INSERT INTO pays (row_auction_states_id, userID, amount) VALUES ('".$row_auction_states_id."','".$u_id."','".$amount."') ");
										$sql_user = mysql_query("UPDATE users SET deposit='".$new_deposit."' WHERE id='".$u_id."' ");
										if($sql_user)
										{
											$payment = 1;
											$notID = 7;
											//unda gaigzavnos shetyobineba rom tanxa gadasaxdelia
										}
										else
										{
											$payment = 0;
											$notID = 8;
										}										
									}
									else
									{
										$payment = 0;
										//unda gaigzavnos shetyobineba rom tanxa ar aris sakmarisi
									}
									include "../mailer/send_notes_to_mail.php";
									$sql_prod = mysql_query("UPDATE auction SET winner='".$u_id."', payment='".$payment."' WHERE id='".$row_auction_states["id"]."' ");
								}//payment==0
							}//if bids >0
						}//dasrulebulia auqcioni tarigebis mixedvit
					}//if($row_auction_states["state"]!=2 and $row_auction_states["state"]!=3 and $row_auction_states["state"]!=5 and $row_auction_states["state"]!=6)					
					//echo $hasauction;
					$update = mysql_query("UPDATE products SET hasauction='".$hasauction."' , state='".$auctionstate."' WHERE id='".$prod."' ");
				 }
				}//if auctions >0
			}//while
		}//pay=false
	if(isset($_GET["cat"]))
	{
		$cat = mysql_real_escape_string(stripslashes(trim(@$_GET["cat"])));
		if($cat!='login')
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$_SESSION["last_actual_link"]=$actual_link; 
			unset($_SESSION["unloading"]);
			unset($_SESSION["login"]);
			unset($_SESSION["newuser"]);
			//unset($_SESSION["oauth_uid"]);
		}
	}
	else
	{
		//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		//$_SESSION["last_actual_link"]=$actual_link; 
		unset($_SESSION["unloading"]);
		unset($_SESSION["login"]);
		unset($_SESSION["newuser"]);
		//unset($_SESSION["oauth_uid"]);
	}
}
else
{
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	echo '<html><head>
	<title>404 Not Found</title>
	</head>
	<body>
	<h1>Not Found</h1>
	<p>The requested URL'.$actual_link .' was not found on this server.</p>
	</body>
	</html>';
}

$auction_states = mysql_query("SELECT id, UNIX_TIMESTAMP(startdate), UNIX_TIMESTAMP(tilldate), prodID, reserve, state, top_bid, winner FROM auction WHERE state='2'  ORDER BY id DESC");
while($row_auction_states = mysql_fetch_array($auction_states))
{
	$auctionID = $row_auction_states["id"];
	$delete_views = mysql_query("DELETE FROM views WHERE auctionID='".$auctionID."' ");
}
?>