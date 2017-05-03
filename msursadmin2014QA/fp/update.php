<?php
include "../conns/connection.php";
if(isset($_GET["process"])&&isset($_GET["state"])){
	if($_GET["process"]=="update_form"){
	// ## TEQSTURI MOMACEMEBIS MODIFICIREBA ##
		$categoryResult = mysql_query("SELECT id FROM fp_categories");
		while($categoryResultData = mysql_fetch_array($categoryResult)){
			$fpcategoryid = $categoryResultData["id"];
			$itemid = $_POST["category_".$fpcategoryid];
			$result = "UPDATE fp SET itemid='".$itemid."', hascategoryphoto='".isset($_POST["hascategoryphoto_".$fpcategoryid])."', haseditorphoto='".isset($_POST["haseditorphoto_".$fpcategoryid])."' WHERE fpcategoryid='".$fpcategoryid."' ";
			mysql_query($result, $con) or exit ('error'.mysql_error());
			}
			echo "<p>პირველი გვერდი <strong>რედაქტირებულია</strong></p>\n";
	}
}
if(isset($_GET["state"])){
	$state = $_GET["state"];
	$categoryid = "";
	if(!empty($_POST["category"])){ $categoryid = $_POST["category"]; }
?>
<form action="?admin=fp&amp;state=<?php echo $state; ?>&amp;process=update_form" method="post" enctype="multipart/form-data">
<fieldset>

<?php
	// cxrilis saxelis camogeba
	//include "../includes/categories.php";
	$categoryResult = mysql_query("SELECT categoryid FROM fp_categories GROUP BY categoryid ");

	while($categoryResultData = mysql_fetch_array($categoryResult)){

		$tableName = getCategoryTable($categoryResultData["categoryid"], $con);

		$result = "SELECT id, title FROM fp_categories WHERE categoryid='".$categoryResultData["categoryid"]."' ";
		$result = mysql_query($result) or exit('Error: '.mysql_error());

		for($a=0; $a<mysql_num_rows($result); $a++){
			$row = mysql_fetch_array($result);
			$fpResult = "SELECT itemid, hascategoryphoto, haseditorphoto FROM fp WHERE fpcategoryid='".$row["id"]."' ";
			$fpResult = mysql_query($fpResult) or exit('Error: '.mysql_error());
			$fpResultData = mysql_fetch_array($fpResult);
			echo "<div class='fpblock'>";
			echo "<h3>".$row["title"]."</h3>\n";
			echo "<label>აირჩიეთ<strong>კატეგორია </strong> რედაქტირებისთვის  </label>\n";
			echo "<select name=\"category_".$row["id"]."\">\n";
			$titleCollumn = "";
			$collumns_common = array("id", "pagetitle");
			$collumns_media = array("id", "headline");
			$collumns_products= array("id", "headline");

			$collumnsData = ${"collumns_".$tableName};
			$collumns = "";
			for($j=0; $j<count($collumnsData); $j++){
				$comma = count($collumnsData)-1 == $j ? "" : ", ";
				$collumns .= $collumnsData[$j].$comma;
			}

			$itemResult = mysql_query("SELECT id, ".$collumns." FROM ".$tableName." ORDER BY published desc ");
			$itemResult or exit('Error: '.mysql_error());
			
				while($itemResultData = mysql_fetch_array($itemResult)){
					$selected = ($itemResultData["id"] == $fpResultData["itemid"]) ? " selected=\"selected\"" : "";
					echo "<option value=\"".$itemResultData[$collumnsData[0]]."\"".$selected.">".$itemResultData[$collumnsData[1]]."</option>\n";
				}
			echo "</select><br />\n";
					$categoryPhotoChecked = $fpResultData["hascategoryphoto"] ? " checked=\"checked\"" : "";
					$editorPhotoChecked = $fpResultData["haseditorphoto"] ? " checked=\"checked\"" : "";
			echo "<ul>\n";
				echo "<li>";
					echo "<label>Show <em>Category</em> photo</label>";
					echo "<input type=\"checkbox\" name=\"hascategoryphoto_".$row["id"]."\"".$categoryPhotoChecked." value=\"\" />";
				echo "</li>";
				echo "<li>";
					echo "<label>Show <em>Text Editor</em> photo</label>";
					echo "<input type=\"checkbox\" name=\"haseditorphoto_".$row["id"]."\"".$editorPhotoChecked." value=\"\" />";
				echo "</li>";
			echo "\n</ul>\n";
			echo "</div><!--fpblock-->";
		}
	}
}
?>
<input type="submit" value="Update" />
</fieldset>
</form>
<?php 	mysql_close($con); ?>