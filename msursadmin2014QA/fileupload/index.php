<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ka" lang="ka">
<head>
	<meta name="language" content="ka" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> PHP lesson </title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link type="text/css" media="all" rel="stylesheet" href="styles/layout.css" />
 <script type="text/javascript">
	 function countLeft(field, count, max) {
		field = document.getElementById(field); 
		count = document.getElementById(count); 
		 if (field.value.length > max) { field.value = field.value.substring(0, max); }
		 else { count.value = max - field.value.length; }
	 }
 </script>
</head>

 <body>

<?php 
	if(!empty($_POST["filetype"])) { $fileType = $_POST["filetype"]; }else{ 
		if(isset($_GET["filetype"])) { $fileType = $_GET["filetype"]; }else{ $fileType = false; } }
?>

<form action="index.php" method="post" enctype="multipart/form-data">
<fieldset>
<legend>File upload</legend><br />
	<label for="filetype">Choose <strong>file type</strong> to upload: </label>
	<select name="filetype" id="filetype">
	<?php
			echo "<option value=\"docs\"".(($fileType=="doc") ? " selected=\"selected\"" : "").">Document</option>\n";
			echo "<option value=\"photos\"".(($fileType=="photos") ? " selected=\"selected\"" : "").">Photo</option>\n";
	?>
	</select><br /><br />

<input type="submit" value="Preceed &gt;" />
</fieldset>
</form>

<?php  if($fileType){ 

if($fileType=="docs"){
	$typeTitle = "Document";
	$allowedExtTxt = "txt, docx, doc, xls, xlsx, ppt, pptx, pps, rtf, pdf";
	$allowedExtensions = array("txt","docx","doc","xls","xlsx","ppt","pptx","pps","rtf","pdf");
	$uploadDir = "docs/";
}else{
	$typeTitle = "Image";
	$allowedExtTxt = "jpg, png, gif";
	$allowedExtensions = array("jpg","png","gif");
	$uploadDir = "photos/";
}
	
?>

<h1>[ <?php echo $typeTitle; ?> type ] file upload </h1>
<p>Allowed file types: <em><?php echo $allowedExtTxt; ?></em></p>
<h2> Show <em>list</em> of <a href="./?action=filelist<?php echo ($fileType ? "&amp;filetype=".$fileType : ""); ?>">uploaded files</a> &raquo;</h2>

<?php
if(isset($_FILES['fileUpload']) && !empty($_FILES['fileUpload']['name'])) { 
  foreach ($_FILES as $file) {
    if ($file['tmp_name'] > '') {
      if (!in_array(end(explode(".", strtolower($file['name']))), $allowedExtensions)) {
       die("<em>".$file['name'].'</em> <strong>type</strong> is <strong>not allowed</strong>!<br/>'.
        '<a href="javascript:history.go(-1);">'.
        '&lt;&lt Go Back</a>');
      }
    }
  }

/// START of uploading files

$fileName = $_FILES['fileUpload']['name'];

// mimagrebuli failistvis saxelis dasashvebi simboloebis shemocmeba da carieli sivrcis chanacvleba (-)
$uploadedFileName = str_replace(" ","-",$_POST["filename"]);
echo "<h1>".$uploadedFileName."</h1>";

function checkFileName($uploadedFileName){
  return preg_match('/^[a-z][-\w]*$/i', $uploadedFileName);
 }

if(!empty($uploadedFileName)){ if(!checkFileName($uploadedFileName)){ echo "<h1>wrong file-name: ".$uploadedFileName."</h1>"; echo "<p>Correct <a href=\"./\">file name</a> &raquo;</p>"; exit; } }

include "../imagesprocess/extend.php";
if(!empty($fileName)){ $fileInfo = extend($fileName); $fileExt = $fileInfo[1]; }
$uploadedFileName = $uploadedFileName.".".$fileExt;


$filePlace = "../../uploadedfiles/".$uploadDir;
$filePlace = $filePlace . $uploadedFileName; 
$locationPrint = "../uploadedfiles/".$uploadDir . $uploadedFileName;

	if(!file_exists($filePlace)) { 
		if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $filePlace)) {
			echo "The file <strong>". $uploadedFileName. "</strong> has been uploaded <br /><br />";
			echo " <input type=\"text\" name=\"address\" id=\"address\" value=\"".$locationPrint."\" size=\"50\" onclick=\"javascript:select()\" /><br /><br />";
			echo "<p>Upload <a href=\"./\">anoher file</a> &raquo;</p>";
		} else{
			echo "There was an error uploading the file, please try again!";
		} 
	}else { echo "File with the name of <strong>".$uploadedFileName." already exists</strong>. Choose <a href=\"./\">different file name</a> &raquo;"; }
}

if(empty($_FILES['fileUpload']['name'])){

?>
<form action="index.php" method="post" enctype="multipart/form-data">
	<fieldset>
		<legend>Select file to upload</legend><br />
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		<label for="fileNameField">Type file name here (max.: 25 characters)</label><br />
		<input type="text" name="filename" id="fileNameField" size="35" onkeydown="countLeft('fileNameField','charsLeft',25);" onkeyup="countLeft('fileNameField','charsLeft',25);" />
		<input type="file" name="fileUpload" id="fileUpload" size="25" /><br />
		<input readonly="readonly" type="text" id="charsLeft" size="3" maxlength="3" value="25" /> characters left<br /><br />
		<input type="hidden" name="filetype" value="<?php echo $fileType; ?>" />
		<input type="submit" value="Upload" />
	</fieldset>
</form>

<?php } 

// $lookInDirectory = "."; // currect directory
$lookInDirectory = "../../uploadedfiles/".$uploadDir;

if(isset($_GET["action"])){
	switch($_GET["action"]){
		case "filelist": 
			if ($handle = opendir($lookInDirectory)) {
				echo "<p>List of uploaded files</p>";
				echo "<dl>\n";
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$filePlace = "../../uploadedfiles/".$uploadDir; $fileName = $file; $locationPrint = "../uploadedfiles/".$uploadDir.$fileName;
						echo "<dt><strong>".$file."</strong></dt>";
						echo " <dd><input type=\"text\" name=\"address\" value=\"".$locationPrint."\" size=\"50\" onclick=\"javascript:select()\" /> &lt; <em>path for url [href]</em> \n</dd> ";

					}
				}
				echo "</dl>\n";
				closedir($handle);
			}
		break;
	}
}

// end of checking file type variable ($_POST["filetype"])
}

?>

 </body>
</html>