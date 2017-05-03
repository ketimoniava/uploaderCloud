<?php
echo "<div class='center'>\n";
//echo "<h3>რეკლამის დამატება</h3>";
// chech is file exist and is writable
$filename = "../upload/";
if(file_exists($filename)){
if(is_writable($filename)) {
//echo 'The file is writable';
} else {
//echo 'The file is not writable';
}
}
else{ //echo "The file does not exist";
}
if(isset($_GET["process"])){
$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
if($process == "update"){
include "../conns/connection.php";
// mimagrebuli suratistvis saxelis dasashvebi simboloebis shemocmeba da carieli sivrcis chanacvleba (-)
$tableName = mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
$blockid = mysql_real_escape_string(stripslashes(trim(@$_GET["block"])));
// cxrilis saxelis camogeba
	//include "../includes/categories.php";
}
//echo "sssssadad";
/// START of uploading photos

include "imagesprocess/imageresize.php";
include "imagesprocess/extend.php";

//ARSEBULI SURATEBIS MODIFICIREBA
if(isset($_POST["reklamaIndex"])) { $reklamaIds = $_POST["reklamaIndex"]; } else { $reklamaIds = array(); }

if(isset($_POST["delet"])) { $delet = $_POST["delet"]; }
if($blockid==1) { $imgSize=750; }
if($blockid==2) { $imgSize=490; }
if($blockid==3) { $imgSize=245; }
if($blockid==4) { $imgSize=195; }
if($blockid==5) { $imgSize=245; }
if($blockid==6) { $imgSize=245; }
$isText=0;
$emptyValue=0;
echo "aaaaaaaa";
for($i=0; $i<count($reklamaIds); $i++){ 
		echo "ssssss";
//IM REKLAMIS CHASLA ROMELSAC CHECKBOX MONISHNULI AQVS
$deletedPhotos = array();
	if(isset($delet[$i])){ // SURATIS CASHLA (tu monishnulia cashlis gilaki)
		$filenameResult = mysql_query("SELECT filename FROM ".$tableName." WHERE id='".$delet[$i]."'");
		while($filenameRow = mysql_fetch_array($filenameResult)){
			$sql = mysql_query("DELETE FROM ".$tableName." WHERE id='".$delet[$i]."'");
			if(file_exists("../photos/".$tableName."/original/".$filenameRow["filename"])){
				unlink("../photos/".$tableName."/original/".$filenameRow["filename"]);
			}
			if(file_exists("../photos/".$tableName."/small/".$filenameRow["filename"])){
				unlink("../photos/".$tableName."/small/".$filenameRow["filename"]);
			}
			$isText = 1;
			array_push($deletedPhotos,$delet[$i]);
		}//while
	}

if(count($deletedPhotos))
	{ 
		if(in_array($reklamaIds[$i],$deletedPhotos))
		{$allow = false; }else{ 
			$allow = true; }
			}else{ $allow = true; }
if($allow){
		$resultReklama = mysql_query("SELECT * FROM reklama WHERE id='".$reklamaIds[$i]."' ");
		$rowReklama = mysql_fetch_array($resultReklama);
		$link = mysql_real_escape_string(stripslashes(trim(@$_POST["link"][$i])));
		$link = str_replace("&","&amp;", $link);
		$bodytext = @$_POST["bodytext"][$i];
		//$published = @$_POST["published"][$i];
		//$tilldate = @$_POST["tilldate"][$i];
		$emptyValue = 0; 
		if(empty($link)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>ბმული/ლინკი</strong></h3>"; $emptyValue = 1; }
		//if(empty($tilldate)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>თარიღიდან</strong></h3>"; $emptyValue = 1; }
		//if(empty($published)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>თარიღამდე</strong></h3>"; $emptyValue = 1; }
		if($emptyValue){ echo "<h4>რეკლამა ".$i." ის რედაქტირება არ შესრულდა</h4>\n";  }
		else{
		if(!empty($_FILES["photo"]["name"][$i])){
		$fileInfo = extend($_FILES["photo"]["name"][$i]);
		$fileExt = $fileInfo[1];
		$isText = 1;
		$getExt = explode ('.', $_FILES["photo"]["name"][$i]);
		$fileExt = $getExt[count($getExt)-1];
		$rand_name= rand(0,999999999);
		$phototitle=$rand_name;
		$userfilename=$phototitle.".".$fileExt;
		$tableName='reklama';
		if(in_array(!"",$getExt)){ // SURATI AXLIT CHANACVLEBA
			if(file_exists("../photos/".$tableName."/original/".$rowReklama["filename"])){
				unlink("../photos/".$tableName."/original/".$rowReklama["filename"]); 	}
			if(file_exists("../photos/".$tableName."/small/".$rowReklama["filename"])){
				unlink("../photos/".$tableName."/small/".$rowReklama["filename"]); 	}
				resizeAndSave("../photos/".$tableName."/small/", "../photos/".$tableName."/original/",$imgSize, $_FILES["photo"],$i,$phototitle, $fileExt);
		}
		else{ // ASATVIRTI FAILIS SAXELIS GADARQMEVISTVIS SAXELIS GANSAZGVRA (SHESABAMISI TIPIT)
			$pathParts = pathinfo("../photos/".$tableName."/original/".$rowReklama["filename"]);
			$fileExt = $pathParts['extension'];
			$userfilename=$phototitle.".".$fileExt;
		}
		$result = "UPDATE ".$tableName." SET filename='".$userfilename."' WHERE  id='".$reklamaIds[$i]."' ";
		mysql_query($result, $con) or exit ('error'.mysql_error());
		}
		$result = "UPDATE ".$tableName." SET description='".$bodytext."', link='".$link."', block='".$blockid."' WHERE  id='".$reklamaIds[$i]."' ";
		mysql_query($result, $con) or exit ('error'.mysql_error());
		}
	}

echo $formsToCheck = count($_FILES["photo"]["name"])-count($reklamaIds);
//if(count($reklamaIds)==0) { $j=1; } else { $j=count($reklamaIds); }
	for($j=count($reklamaIds); $j<=count($_FILES["photo"]["name"]); $j++){
		echo $j;
		if(!empty($_FILES["photo"]["name"][$j])){
		$fileInfo = extend($_FILES["photo"]["name"][$j]);
		$fileExt = $fileInfo[1];
		$link = @$_POST["link"][$j];
		$bodytext = @$_POST["bodytext"][$j];
		$emptyValue = 0; 
		$rand_name = md5(time());
		$rand_name= rand(0,999999999);
		$phototitle = $rand_name;
		$filename = $phototitle.".".$fileExt;
		if(empty($link)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>ბმული/ლინკი</strong></h3>\n"; $emptyValue = 1; }
		if($emptyValue){ echo "<h4>რეკლამა ".$i." -ის დამატება არ შესრულდა შეავსეთ სავალდებულო ველები</h4>\n";  }
		else
		   {
				//echo "atvirtva";
				resizeAndSave("../photos/".$tableName."/small/", "../photos/".$tableName."/original", $imgSize, $_FILES["photo"],$i,$phototitle, $fileExt);
				$sql = "INSERT INTO ".$tableName." (filename, description, link, published, tilldate, block) VALUES ('".$phototitle.".".$fileExt."','".$bodytext."', '".$link."', '".$blockid."')";
				mysql_query($sql,$con) or exit('Error: ' . mysql_error());
			}
		}//if(!empty($_FILES["photo"]["name"][$i]))
	}//for($i=count($reklamaIds); $i<=$formsToCheck; $i++)
}
	if($emptyValue){   }
		else
		   {
				echo "<h3>რეკლამა რედაქტირებულია11</strong></h3>\n"; 
				echo "<p><a href='?admin=reklama'>უკან</a></p>\n";
				exit("<meta http-equiv='refresh' content='0; url=?admin=reklama'>");
		   }
		  
//IM REKLAMIS CHASLA ROMELSAC CHECKBOX MONISHNULI AQVS
}else{
if(isset($_GET["state"])){
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	$block = mysql_real_escape_string(stripslashes(trim(@$_GET["block"])));
	include "../conns/connection.php";
	?>
	<form action="?admin=<?php echo $category; ?>&amp;block=<?php echo $block; ?>&amp;state=<?php echo $state; ?>&amp;process=update" method="post" enctype="multipart/form-data" class='insert_update_data'>
	<fieldset>
	<legend>რეკლამის/ბანერის რედაქტირება</legend>
		<?php
			switch($_GET["block"]){
				case "5":
					$images = 1;
				break;
				case "4":
					$images = 6;
				break;
				case "3":
					$images = 3;
				break;
				case "2":
					$images = 1;
				break;
				case "1":
					$images = 4;
				break;
			}
			$block = mysql_real_escape_string(stripslashes(trim(@$_GET["block"])));
			$resultReklama = mysql_query("SELECT id, filename, description, UNIX_TIMESTAMP(published), UNIX_TIMESTAMP(tilldate), link, block FROM reklama WHERE block='".$block."' ");
			$fullimages = mysql_num_rows($resultReklama);
			$j = 0;
			while($rowReklama = mysql_fetch_array($resultReklama))
			{
				echo "<fieldset>\n";
				echo "<legend>რეკლამა/ბანერი</legend>\n";
				echo "<input type='hidden' name='reklamaIndex[]' value='".$rowReklama["id"]."' />\n";
				echo "<label for='headline".$j."'>ბმული/ლინკი</label>\n";
				echo "<input type='text' name='link[]' id='link".$j."' value='".$rowReklama["link"]."' size='35' />\n";
				echo "<label for='bodytext".$j."'>აღწერა</label>\n";
				echo "<textarea name='bodytext[]' class='wymeditor' id='bodytext".$j."' cols='69' rows='5' >".$rowReklama["description"]."</textarea>\n";
				if($block==1)
				{
					echo "<br /><p><img src='../photos/reklama/small/".$rowReklama["filename"]."' width='490px' alt='".$rowReklama["description"]."' /></p>\n";
				}
				else
				{
					echo "<br /><p><img src='../photos/reklama/original/".$rowReklama["filename"]."' alt='".$rowReklama["description"]."' /></p>\n";
				}
				$getExt = explode ('.', $rowReklama["filename"]);
				$fileExt = $getExt[count($getExt)-1];
				$filename = "";
				for($i=0; $i<count($getExt)-1; $i++){
					if($i){ $fileChar = "."; } else { $fileChar = ""; }
					$filename = $filename.$fileChar.$getExt[$i];
					// echo $filename;
				}	
				echo "<div class='bannerblock'><label for='delet".$i."'>რეკლამის წაშლა</label><input type=\"checkbox\" name=\"delet[]\" value=\"".$rowReklama["id"]."\" /><input type='file' name='photo[]' id='photo".$i."' />\</div>\n";
				//echo "n";
				echo "</fieldset>\n";
				$j++;
			}
			$fullimages = 4;
			$emptyImages = $images-$j;
			for($i=0; $i<$emptyImages; $i++)
			{
				echo "<fieldset>\n";
				echo "<legend>რეკლამა/ბანერი</legend>\n";
				echo "<label for='headline".$i."'>ბმული/ლინკი</label>\n";
				echo "<input type='text' name='link[]' id='link".$i."' size='35' />\n";
				echo "<label for='bodytext".$i."'>აღწერა</label>\n";
				echo "<textarea name='bodytext[]' class='wymeditor' id='bodytext".$i."' cols='15' rows='15' ></textarea>\n";
				echo "<label for='title".$i."'>ფოტო ".$i."</label>\n";
				echo "<input type='file' name='photo[]' id='photo".$i."' />\n";
				echo "</fieldset>\n";
			}
		?>
	
    <p class="submit">
    <input type="reset" />
    <input type="submit" class="wymupdate" />
    </p>
	</fieldset>
	</form>
    <?php } }
echo "</div><!--center-->\n";
?>