<?php
echo "<div class='center'>";
//echo "<h3>რეკლამის დამატება</h3>";

// chech is file exist and is writable
$filename = "../upload/";
if(file_exists($filename)){
if (is_writable($filename)) {
//echo 'The file is writable';
} else {
//echo 'The file is not writable';
}
}else{ //echo "The file does not exist";
}

if(isset($_GET["process"])){
$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
if($process=="insert"){
include "../conns/connection.php";
// mimagrebuli suratistvis saxelis dasashvebi simboloebis shemocmeba da carieli sivrcis chanacvleba (-)
$tableName=mysql_real_escape_string(stripslashes(trim(@$_GET["admin"])));
$blockid = mysql_real_escape_string(stripslashes(trim(@$_GET["block"])));
//cxrilis saxelis camogeba
	//include "../includes/categories.php";
}
//echo "sssssadad";
/// START of uploading photos
include "imagesprocess/imageresize.php";
include "imagesprocess/extend.php";
if($blockid==1){ $imgSize=600; }
if($blockid==2){ $imgSize=600; }
if($blockid==3){ $imgSize=372; }
if($blockid==4){ $imgSize=190; }
if($blockid==5){ $imgSize=246; }
if($blockid==6){ $imgSize=243; }
for($i=0; $i<count($_FILES["photo"]["name"]); $i++){
	if(!empty($_FILES["photo"]["name"][$i])){
		$fileInfo = extend($_FILES["photo"]["name"][$i]);
		$fileExt = $fileInfo[1];
		$link =@ $_POST["link"][$i];
		$bodytext = @$_POST["bodytext"][$i];
		//$published = @$_POST["published"][$i];
		//$tilldate = @$_POST["tilldate"][$i];
		$rand_name = md5(time());
		$rand_name= rand(0,999999999);
		$phototitle=$rand_name;
		$filename=$phototitle.".".$fileExt;
		resizeAndSave("../photos/".$tableName."/small", "../photos/".$tableName."/original", $imgSize, $_FILES["photo"],$i,$phototitle, $fileExt);
		$emptyValue = 0; 
		if (!empty($_FILES["photo"]["name"]))
		{
			if(empty($link)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>ბმული/ლინკი</strong></h3>"; $emptyValue = 1; }
			//if(empty($tilldate)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>თარიღიდან</strong></h3>"; $emptyValue = 1; }
			//if(empty($published)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>თარიღამდე</strong></h3>"; $emptyValue = 1; }
			if($emptyValue){ echo "<h4>რეკლამა ".$i." არ დაემატა</h4>"; } else { 
			echo "<h3>რეკლამა ".$i." დამატებულია</h3>";
			$sql = "INSERT INTO ".$tableName." (filename, description, link, block) VALUES ('".$phototitle.".".$fileExt."','".$bodytext."', '".$link."','".$blockid."')";
			mysql_query($sql,$con) or exit('Error: ' . mysql_error());
			}
		}
	}
} //ELSE EMPTYVALUE
}else{
if(isset($_GET["state"])){
	include "../conns/connection.php";
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	$block = mysql_real_escape_string(stripslashes(trim(@$_GET["block"])));
?>
<form action="?admin=<?php echo $category; ?>&amp;block=<?php echo $block; ?>&amp;state=<?php echo $state; ?>&amp;process=insert" method="post" enctype="multipart/form-data" class='insert_update_data'>
<fieldset>
<legend>რეკლამის დამატება</legend>
	<?php
mysql_close($con);
switch($_GET["block"]){
		case "5":
			$imgRaod = 1;
		break;
		case "4":
			$imgRaod = 6;
		break;
		case "3":
			$imgRaod = 3;
		break;
		case "2":
			$imgRaod = 1;
		break;
		case "1":
			$imgRaod = 4;
		break;
	}
//$imgRaod=4;
for($i=0; $i<$imgRaod; $i++)
	{
		echo "<fieldset>";
		echo "<legend>ქართულად</legend>";
		echo "<label for='headline".$i."'>ბმული/ლინკი</label>\n";
		echo "<input type='text' name='link[]' id='link".$i."' size='35' />\n";
		echo "<label for='bodytext".$i."'>აღწერა</label>\n";
		echo "<textarea name='bodytext[]' class='wymeditor' id='bodytext".$i."' cols='15' rows='15' ></textarea>\n";
		echo "<label for='title".$i."'>ფოტო ".$i."</label>\n";
		echo "<input type='file' name='photo[]' id='photo".$i."' />\n";
		echo "</fieldset>\n";
	}
?>
<input type="submit" value="Insert data" />
</fieldset>
</form>

<?php }} 
echo "</div><!--center-->\n";
?>