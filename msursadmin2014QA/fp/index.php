<h2>მთავარი გვერდის რედაქტირება</h2>
<div class='center'>
<?php
//echo "text";
if(isset($_GET["state"])){
	switch($_GET["state"]){
		case "insert":
			//include "insert.php";
		break;
		case "delete":
			include "delete.php";
		break;
		case "update":
			//include "update.php";
		break;
	}
}
	include "update.php";
?>
</div><!--center-->