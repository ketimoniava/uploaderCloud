<?php
if(isset($_SESSION["isadmin"]))
{
include "conns/connection.php";

include "imagesprocess/imageresize.php";
include "imagesprocess/extend.php";


if(isset($_GET["catid"])&&$_GET["item"]){
	$categoryid =mysql_real_escape_string(stripslashes(trim(@ $_GET["catid"])));
	$itemId = mysql_real_escape_string(stripslashes(trim(@$_GET["item"])));
	// cxrilis saxelis camogeba
	//include "../includes/categories.php";
	//$tableName = getCategoryTable($categoryid, $con);
	$tableName = 'common';
	if(isset($_GET["process"]))
	{
		$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
		if($process == "update"){
		$pagetitle = mysql_real_escape_string(stripslashes(trim(@$_POST["pagetitle"])));
		$bodytext1 = mysql_real_escape_string(stripslashes(trim(@$_POST["bodytext"])));
		$bodytext2 = str_replace("\r","", $bodytext1);
		$bodytext = str_replace("\n","", $bodytext2);
		$itemId = mysql_real_escape_string(stripslashes(trim(@$_GET["item"])));
		// cxrilis saxelis camogeba
		//include "../includes/categories.php";
		//$tableName = getCategoryTable($categoryid, $con);
		if(isset($_POST["imgindex"])){ $photoIds = $_POST["imgindex"]; }else{ $photoIds = array(); }
		if(isset($_POST["delet"])){ $delet =@ $_POST["delet"]; }
		
		// siaxleebis ids shemocmeba suratebis bazashi (anu surati aris tu ara agnishnuli siaxlistvis)
		function checkhasphoto($itemId, $tableName, $con){
			$relids = mysql_query("SELECT relid FROM ".$tableName."photos WHERE relid='".$itemId."'", $con);
			return mysql_num_rows($relids);
		}
		
		// ## ARSEBULI SURATEBIS MODIFICIREBA ##
		
		$deletedPhotos = array();
		for($i=0; $i<count($photoIds); $i++){ 
			if(isset($delet[$i])){ // SURATIS CASHLA (tu monishnulia cashlis gilaki)
				$filenameResult = mysql_query("SELECT filename FROM ".$tableName."photos WHERE id='".$delet[$i]."'");
				while($filenameRow = mysql_fetch_array($filenameResult)){
					$sql = mysql_query("DELETE FROM ".$tableName."photos WHERE id='".$delet[$i]."'");
						if(file_exists("../photos/".$tableName."/original/".$filenameRow["filename"])){
							unlink("../photos/".$tableName."/original/".$filenameRow["filename"]);
						}
						if(file_exists("../photos/".$tableName."/small/".$filenameRow["filename"])){
							unlink("../photos/".$tableName."/small/".$filenameRow["filename"]);
						}
					array_push($deletedPhotos,$delet[$i]);
				}
		// siaxleebshi hasphoto = 0;
				if(!checkhasphoto($itemId, $tableName, $con)){ $result = mysql_query("UPDATE ".$tableName." SET hasphoto='0' WHERE id='".$itemId."' "); }
			}else{
		
		if(count($deletedPhotos)){ if(in_array($photoIds[$i],$deletedPhotos)){ $allow = false; }else{ $allow = true; } }else{ $allow = true; }
		if($allow){
		
			// get file name from mysql table
			$filenameResult = mysql_query("SELECT filename FROM ".$tableName."photos WHERE id='".$photoIds[$i]."'");
			$filenameRow = mysql_fetch_array($filenameResult);
			// get file extension
			$getExt = explode ('.', $_FILES["photo"]["name"][$i]);
			$fileExt = $getExt[count($getExt)-1];
			$rand_name = md5(time());
			$rand_name= rand(0,999999999);
			$phototitle=$rand_name;
			$userfilename=$phototitle.".".$fileExt;
			// define user file name
		
			if(in_array(!"",$getExt)){ // SURATI AXLIT CHANACVLEBA
				if(file_exists("../photos/".$tableName."/original/".$filenameRow["filename"])){
					unlink("../photos/".$tableName."/original/".$filenameRow["filename"]); 	}
				if(file_exists("../photos/".$tableName."/small/".$filenameRow["filename"])){
					unlink("../photos/".$tableName."/small/".$filenameRow["filename"]); 	}
				resizeAndSave("../prv/".$tableName."/small/", "../prv/".$tableName."/original/",180, $_FILES["photo"],$i,$phototitle, $fileExt);
				$result = mysql_query("UPDATE commonphotos SET filename='".$userfilename."' WHERE id='".$photoIds[$i]."' ");
			}else{ // ASATVIRTI FAILIS SAXELIS GADARQMEVISTVIS SAXELIS GANSAZGVRA (SHESABAMISI TIPIT)
				$pathParts = pathinfo("../prv/".$tableName."/original/".$filenameRow["filename"]);
				$fileExt = $pathParts['extension'];
			}
			//$result = mysql_query("UPDATE ".$tableName."photos SET filename='".$userfilename."' WHERE id='".$_POST["imgindex"][$i]."' ");
			}
		 }
		}
		
		// ## AXALI SURATEBIS CHAMATEBA ##
		if(isset($_FILES["photo"]["name"]))
		{
		$formsToCheck = count($_FILES["photo"]["name"])-count($photoIds);
		for($i=count($photoIds); $i<=$formsToCheck; $i++){
			if(!empty($_FILES["photo"]["name"][$i])){
			$fileInfo = extend($_FILES["photo"]["name"][$i]);
			$fileExt = $fileInfo[1];
			$rand_name = md5(time());
			$rand_name= rand(0,999999999);
			$phototitle=$rand_name;
			$filename=$phototitle.".".$fileExt;
			resizeAndSave("../prv/".$tableName."/small/","../prv/".$tableName."/original/", 180, $_FILES["photo"],$i,$phototitle, $fileExt);
			$sql="INSERT INTO ".$tableName."photos (filename,relid) VALUES ('".$phototitle.".".$fileExt."','".$itemId."')";
			mysql_query($sql,$con) or exit ('error'.mysql_error());
		// siaxleebshi hasphoto = 1;
			if(checkhasphoto($itemId, $tableName, $con)){ $result = mysql_query("UPDATE ".$tableName." SET hasphoto='1' WHERE id='".$itemId."' "); }
			}
		}
		}
		// //## TEQSTURI MOMACEMEBIS MODIFICIREBA ##
		//echo $itemId;
			$result = "UPDATE common SET pagetitle='".$pagetitle."', bodytext='".$bodytext."', published=now() WHERE id='".$itemId."' ";
			mysql_query($result, $con) or exit ('error'.mysql_error());
			if($result)
			{
				$result = mysql_query("SELECT id, pagetitle FROM common WHERE id='".$itemId."'");
				$row = mysql_fetch_array($result);
				echo "<p><h3><strong>".$row["pagetitle"]." </strong></h3>რედაქტირებულია მონაცემთა ბაზაში</p>\n";
				echo "<p class='backward'><a href=\"?admin=common&amp;catid=".$categoryid."\">უკან</a></p>\n";
				exit("<meta http-equiv='refresh' content='0; url=?admin=common&amp;catid=".$categoryid."'>");
			}
			}
		}
		
		else
		{
			$result = mysql_query("SELECT pagetitle, bodytext, hasphoto FROM ".$tableName." WHERE id='".$itemId."'");
			$row = mysql_fetch_array($result);
			$pagetitle = mysql_real_escape_string(stripslashes(trim(@$row["pagetitle"])));
			$bodytext1 = mysql_real_escape_string(stripslashes(trim(@$row["bodytext"])));
			$bodytext2 = str_replace("\r"," ", $bodytext1);
			$bodytext = str_replace("\n"," ", $bodytext2);
		?>
		<form action="?admin=common&amp;state=update&amp;process=update&amp;item=<?php echo $itemId; ?>&amp;catid=<?php echo $categoryid; ?>" method="post" enctype="multipart/form-data" class='insert_update_data'>
		<fieldset>
		<legend>სტატიკური გვერდის რედაქტირება</legend>
		<label for="pagetitle">სათაური</label>
		<input type="text" name="pagetitle" id="pagetitle" value="<?php echo $pagetitle; ?>" size="52" /><br />
		<label for="bodytext">ტექსტი</label>
		<textarea cols="50" rows="10" name="bodytext" class="ckeditor" id="bodytext"><?php echo $bodytext; ?></textarea><br /><br />
		<?php
			$result = mysql_query("SELECT id, filename FROM ".$tableName."photos WHERE relid='".$itemId."'");
			$imgIndex = 0;
			while($row = mysql_fetch_array($result))
			{	
				list($width, $height) = getimagesize("../prv/".$tableName."/small/".$row["filename"]);
				echo "<label for=\"title".$imgIndex."\"><img src=\"../prv/".$tableName."/small/".$row["filename"]."\" width=\"".$width."\" height=\"".$height."\" /></label>";
				echo "<input type=\"hidden\" name=\"imgindex[]\" value=\"".$row["id"]."\" />";
				$getExt = explode ('.', $row["filename"]);
				$fileExt = $getExt[count($getExt)-1];
				$filename = "";
				for($i=0; $i<count($getExt)-1; $i++){
					if($i){ $fileChar = "."; }else{ $fileChar = ""; }
					$filename = $filename.$fileChar.$getExt[$i];
				}
				echo "<input type=\"checkbox\" name=\"delet[]\" value=\"".$row["id"]."\" />";
				echo " <input type=\"file\" name=\"photo[]\" /><br />";
				$imgIndex++;
			}
		$inputraod=1;
		$inputraod=$inputraod-$imgIndex;
		
		if($inputraod){
			for($i=0; $i<$inputraod; $i++){
				echo " <input type=\"file\" name=\"photo[]\" /><br />";	
				$imgIndex++;
			}
		}
		?>
		<div class='submit'><input type="submit" value="update data"  class='wymupdate' /></div><!--submit-->
		</fieldset>
		</form>
		<?php
		}

}

}
else
{
	header("../login.php");
}
?>