<?php
if(isset($_SESSION["isadmin"]))
{
	if(isset($_GET["admin"]))
	{
		$admin = mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
		if($admin == 'common')
		{
			if(isset($_GET["item"]) AND isset($_GET["catid"]))
			{
			$item=mysql_real_escape_string(stripslashes(trim(@$_GET["item"])));
			$catid=mysql_real_escape_string(stripslashes(trim(@$_GET["catid"])));
			//$prod = mysql_real_escape_string(stripslashes(trim(@$_GET["prod"])));
			$currentDate = date("Y-m-d H:i:s");
			$result = mysql_query("SELECT * FROM common WHERE id='".$item."' AND categoryid='".$catid."' ");
			if(mysql_num_rows($result)>0)
			{
				$row_common = mysql_fetch_array($result);
				$order = $row_common["sort"];
				$prevorder = $order-1;
				$nextorder = $order+1;
				if(isset($_GET["state"]))
				{
					$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
					if($state == 'prev')
					{
						/*echo $prevorder;
						echo "<br />";
						echo $order;*/
						$result1 = mysql_query("UPDATE common SET sort='".$order."' WHERE sort='".$prevorder."' ");
						$result2 = mysql_query("UPDATE common SET sort='".$prevorder."' WHERE id='".$item."' ");
						exit("<meta http-equiv='refresh' content='0; url=?admin=common&amp;catid=".$catid."'>");
					}//
					if($state == 'next')
					{
						/*echo $nextorder;
						echo "<br />";
						echo $order;*/
						$result1 = mysql_query("UPDATE common SET sort='".$order."' WHERE sort='".$nextorder."' ");
						$result2 = mysql_query("UPDATE common SET sort='".$nextorder."' WHERE id='".$item."' ");
						exit("<meta http-equiv='refresh' content='0; url=?admin=common&amp;catid=".$catid."'>");
					}//
				}//
			}//
			}
		}//
	}//
}//	
else
{
	header("../login.php");
}
?>