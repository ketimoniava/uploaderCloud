<?php
echo "<h2>რეკლამები</h2>\n";
$category=$_GET["admin"];
if(isset($_GET["state"])){
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	switch($state){
		case "insert":
			include "insert.php";
		break;
		case "delete":
			include "delete.php";
		break;
		case "update":
			include "update.php";
		break;
	}
}else{
	echo "<div class='reklama-content'>\n";
	echo "<div class='updatebannerlink'><span><a href='?admin=".$category."&amp;state=update&amp;block=1'>რედაქტირება</a></span></div><!--images1-->\n";
	$result = mysql_query("SELECT * FROM reklama WHERE block='1'  ORDER BY id DESC LIMIT 1");
	$imgRaod = mysql_num_rows($result);
	if($imgRaod>0)
	{
		$row = mysql_fetch_array($result);
		echo "<a href='".$row["link"]."'>\n";
		echo "<img src='../photos/reklama/original/".$row["filename"]."' width='750' height='280' alt='".strip_tags($row["description"])."'/>\n";
		echo "</a>\n";
	}
	/*
	$resultReklama = mysql_query("SELECT * FROM reklama WHERE block='1' ");
	if(mysql_num_rows($resultReklama)>0)
	{
		$row=mysql_fetch_array($resultReklama);
		
		echo "<div class='mainColumn'>\n";
		echo "<div class='heroGallery'  id='imageGallery2523'>\n";
		echo "<a href='".$row["link"]."'>";
		echo "<img src='../photos/reklama/small/".$row["filename"]."' width='750' height='350px' alt='".strip_tags($row["description"])."'/>\n";
		echo "</a>";
		while($row1=mysql_fetch_array($resultReklama))
		{
			echo "<a href='".$row["link"]."'  class='heroAlternate'>";
					echo "<img src='../photos/reklama/small/".$row1["filename"]."' width='750' height='350px' alt='".strip_tags($row1["description"])."'/>\n";
			echo "</a>";
		}
		echo "</div><!--heroGallery-->\n";
		echo "</div><!--mainColumn-->\n";
	}
	else
	{
		echo "<div class='images'><a href='?admin=".$category."&amp;state=insert&amp;block=1'>დამატება</a><img src='images/reklama1.png' width='760px' height='350px' alt='' /></div><!--images1-->\n";
	}
	*/
echo "</div><!--reklama-content-->\n";

echo "<p class='addUpdBanner'><a href='?admin=reklama&amp;state=insert&amp;block=4'>რეკლამის დამატება</a></p>\n";
$reklama=mysql_query("SELECT * FROM reklama WHERE block='4' ");
echo "<ul class='rightBanners'>\n";
	while($rowReklama = mysql_fetch_array($reklama))
	{
		echo "<li><img src='../photos/reklama/small/".$rowReklama["filename"]."' width='190px' alt='".strip_tags($rowReklama["description"])."'></li>\n";
	}
echo "</ul><!--rightBanners-->\n";
echo "<p class='addUpdBanner'><a href='?admin=reklama&amp;state=update&amp;block=4'>რეკლამის რედაქტირება</a></p>\n";

}
?>