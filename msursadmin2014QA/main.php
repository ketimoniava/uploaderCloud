<?php 
$currentDate=date("Y-m-d H:i:s");
if(isset($_SESSION["isadmin"]))
{
	if($_SESSION["isadmin"]==true)
	{
	include "conns/connection.php";
	echo "<ul class='config'>\n";
	//echo "<li><a href='?admin=menu'>მენიუ</a></li>\n";
	echo "<li><a href='index.php'>მთავარი</a></li>\n";
	echo "<li><a href='?admin=configuration'>პარამეტრები</a></li>\n";
	echo "<li><a href='?sign=1'>გასვლა</a></li>\n";
	echo "</ul><!--config-->\n";
	echo "<div class='site_title'><h1><a href='index.php'><img src='images/logo.png' alt='auction'/></a></h1></div>\n";
	/*$result_reklama = mysql_query("SELECT * FROM reklama WHERE block='2' ORDER BY id LIMIT 1 ");
	if(mysql_num_rows($result_reklama)>0)
	{
		$row_reklama = mysql_fetch_array($result_reklama);
		echo " <div class='top_advertise'>
			   <a href='?admin=reklama&amp;state=update&amp;block=2'><img src='../photos/reklama/original/".$row_reklama["filename"]."' alt='".strip_tags($row_reklama["description"])."' /></a>
		</div><!--top_advertise-->\n";
	}
	else
	{
		echo " <div class='top_advertise'>
			   <a href='?admin=reklama&amp;state=update&amp;block=2'><img src='../images/top_banner.jpg' alt='თქვენი რეკლამის ადგილი'/></a>
		</div><!--top_advertise-->\n";
	}*/
	echo "<ul class='categories'>\n";
	//echo "<li><a href='?admin=products'>კატეგორიები</a></li>\n";
	echo "<li><a href='?admin=users'>მომხმარებლები</a></li>\n";
	//echo "<li><a href='?admin=pays'>გადახდები</a></li>\n";
	echo "<li><a href='?admin=common'>სტატიკური გვერდები</a></li>\n";
	//echo "<li><a href='?admin=reklama'>რეკლამები</a></li>\n";
	echo "<li><a href='?admin=contacts'>კონტაქტი</a></li>\n";
	echo "</ul><!--categories-->\n";
	echo "<div class='content'>\n";
	if(isset($_GET["admin"]))
	{
		$admin_cat = mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
		switch($admin_cat){
			case "news":
				include ("media/index.php");
			break;
			case "common":
				include ("common/index.php");
			break;
			case "contacts":
				include ("contacts/index.php");
			break;
			case "fp":
				include ("fp/index.php");
			break;
			case "users":
				include ("users/index.php");
			break;
			case "reklama":
				include ("reklama/index.php");
			break;
			case "configuration":
				include ("config/site_info.php");
			break;
			default:
				exit("<meta http-equiv='refresh' content='0; url=?admin=prod_cat'>");
				//include ("products/index.php");
			//break;
		}
	}
	echo "</div><!--content-->\n";
}//session
else
{
	echo "<h1>ავტორიზაციის გარეშე სისტემაში შესვლა აკრძალულია</h1>\n";
	exit("<meta http-equiv='refresh' content='0; url=index.php'>");
}
}
else
{
	echo "<h1>ავტორიზაციის გარეშე სისტემაში შესვლა აკრძალულია</h1>\n";
	exit("<meta http-equiv='refresh' content='0; url=index.php'>");
}



if(isset($_SESSION["last_actual_link"]))
{
	if(isset($_GET["admin"]))
	{
		$admincat = @$_GET["admin"];		
		$changelink = 1;
	} else { $changelink = 1; }
	if($changelink == 1)
	{
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$_SESSION["last_actual_link"] = $actual_link; 
	}
}
else
{
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$_SESSION["last_actual_link"] = $actual_link; 
}
?>