<?php
if(isset($_SESSION["isadmin"]))
{
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

if(isset($_GET["process"])&&!empty($_POST["category"])){
$process = mysql_real_escape_string(stripslashes(trim(@$_GET["process"])));
if($process == "insert"){

include "conns/connection.php";

// mimagrebuli suratistvis saxelis dasashvebi simboloebis shemocmeba da carieli sivrcis chanacvleba (-)

$pagetitle = mysql_real_escape_string(stripslashes(trim(@$_POST["pagetitle"])));
$bodytext1 = mysql_real_escape_string(stripslashes(trim(@$_POST["bodytext"])));
$bodytext2 = str_replace("\r","", $bodytext1);
$bodytext = str_replace("\n","", $bodytext2);
$categoryid = mysql_real_escape_string(stripslashes(trim(@$_POST["category"])));
	// cxrilis saxelis camogeba
//	include "../includes/categories.php";
$tableName = 'common';
$result = mysql_query("SELECT id, pagetitle, categoryid, hasphoto, UNIX_TIMESTAMP(published), sort FROM common WHERE categoryid='".$categoryid."' ORDER BY sort DESC LIMIT 1", $con);
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$sort=$row["sort"]+1;
}
else
{
	$sort=1;
}
$emptyValue = 0; 
echo "<div class='center'>\n";
if(empty($pagetitle)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>გვერდის სათაური</strong></h3>"; $emptyValue = 1; }
if(empty($bodytext)){ echo "<h3>თქვენ უნდა შეიყვანოთ <strong>გვერდის ტექსტი</strong></h3>"; $emptyValue = 1; }

if($emptyValue){ echo "<h3><strong>გვერდი არ დაემატა </strong></h3>\n"; }
else{ 
	
	echo "<h3>მონაცემები დამატებულია</h3>";
	
	$sql = "INSERT INTO ".$tableName." (pagetitle, bodytext, published, categoryid, sort) VALUES ('".$pagetitle."', '".$bodytext."', now(), '".$categoryid."', '".$sort."')";
	mysql_query($sql, $con) or exit('Error: ' . mysql_error());

	
}

/// START of uploading photos

include "imagesprocess/imageresize.php";
include "imagesprocess/extend.php";
	$result = "SELECT * FROM common ORDER BY id DESC LIMIT 1";
	$result = mysql_query($result) or exit('Error: '.mysql_error());
	$row=mysql_fetch_array($result);
for($i=0; $i<count($_FILES["photo"]["name"]); $i++){
	if(!empty($_FILES["photo"]["name"][$i])){
		$fileInfo = extend($_FILES["photo"]["name"][$i]);
		$fileExt = $fileInfo[1];
		$rand_name = md5(time());
		$rand_name= rand(0,999999999);
		$phototitle=$rand_name;
		$filename=$phototitle.".".$fileExt;
		resizeAndSave("../prv/photos/".$tableName."/small", "../prv/".$tableName."/original",100, $_FILES["photo"],$i,$phototitle, $fileExt);
		$sql="INSERT INTO ".$tableName."photos (filename,relid) VALUES ('".$phototitle.".".$fileExt."','".$row["id"]."')";
		mysql_query($sql,$con) or exit ('error'.mysql_error());
	}
}

if(in_array(!"", $_FILES["photo"]["name"])){ 
	$result = "UPDATE ".$tableName." SET hasphoto='1' WHERE id='".$row["id"]."' ";
	mysql_query($result,$con) or exit('Error: ' . mysql_error());
}
exit("<meta http-equiv='refresh' content='0; url=?admin=common&amp;catid=".$categoryid."'>");
/// END of uploading photos
mysql_close($con);
}
echo "</div>\n";
}else{

if(isset($_GET["state"])){
	$state = mysql_real_escape_string(stripslashes(trim(@$_GET["state"])));
	include "conns/connection.php";
	$result = "SELECT id, title FROM categories WHERE tablename='common' ";
	$result = mysql_query($result) or exit('Error: '.mysql_error());
?>

<form action="?admin=common&amp;state=<?php echo $state; ?>&amp;process=insert" method="post" enctype="multipart/form-data" class='insert_update_data'>
<fieldset>
<legend>სტატიკური გვერდის დამატება</legend>
	<label for="category"><strong>კატეგორია:</strong></label>
	<select name="category" id="category">
	<?php
		while($row = mysql_fetch_array($result)){
			echo "<option value=\"".$row["id"]."\">".$row["title"]."</option>\n";
		}
		mysql_close($con);
	?>
	</select>

<label for="pagetitle">გვერდის სათაური</label>
<input type="text" name="pagetitle" id="pagetitle" size="60" />
<label for="bodytext">ტექსტი</label>
<textarea cols="70" rows="10" name="bodytext" class="ckeditor" id="bodytext"></textarea>

<label for="photo1">ფოტო</label>
<input type="file" name="photo[]" id="photo1" />

<div class='submit'><input type="submit" value="update data" /></div><!--submit-->
</fieldset>
</form>

<?php }} 
}
?>