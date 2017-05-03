<?php
class SiteModel {    
    public static function getContacts() {        
        $db = DB::getInstance();
        $statement = $db->prepare("
            SELECT * FROM contact 
            WHERE id = 1           
        ");        
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
	
	public static function getData($fp_categories_id){
		$db = DB::getInstance();
		$fpCategoryItem = $fp_categories_id;
		$categoryResult = $db->prepare("SELECT categoryid FROM fp_categories WHERE id='".$fpCategoryItem."' ");
		$categoryResult->execute();
		$categoryResultData = $categoryResult->fetch(PDO::FETCH_ASSOC);
		$fpResult = $db->prepare("SELECT itemid, hascategoryphoto, haseditorphoto FROM fp WHERE fpcategoryid='".$fpCategoryItem."' ");
		$fpResult->execute();
		$fpResultData = $fpResult->fetch(PDO::FETCH_ASSOC);

		$collumns_common = array("id", "pagetitle", "bodytext", "hasphoto","categoryid");
		$collumns_media = array("id", "headline", "shortsummary", "hasphoto","categoryid");
		$collumns_products = array("id", "headline", "shortsummary", "hasphoto","categoryid");
		$categoryResultData["categoryid"];
		// cxrilis saxelis camogeba
		$tableName = 'common';
		$collumnsData = ${"collumns_".$tableName};
		$collumns = "";
		for($j=0; $j<count($collumnsData); $j++){
			//echo  $collumnsData[$j];
			$comma = count($collumnsData)-1 == $j ? "" : ", ";
			$collumns .= $collumnsData[$j].$comma;
		}
		//echo $fpResultData["itemid"];
		$itemResult = $db->prepare("SELECT ".$collumns." FROM ".$tableName." WHERE  id='".$fpResultData["itemid"]."' ");
		//$itemResult or exit('Error: '.mysql_error());
		//$itemResultData = mysql_fetch_array($itemResult);
		$itemResult->execute();
		$itemResultData = $itemResult->fetch(PDO::FETCH_ASSOC);
		return array($itemResultData, $collumnsData, $tableName, $fpResultData);
	}
	
	public static function getCommonMain(){
		$dataSelected = self::getData(1);
		//$dataSelected[0][7];
		$bodytextHTML = $dataSelected[0][$dataSelected[1][2]];
		//echo $dataSelected[0][$dataSelected[1][0]];
		$item = $dataSelected[0][$dataSelected[1][0]];
		$db = DB::getInstance();
		$statement = $db->prepare("
            SELECT * FROM common 
            WHERE id = '".$item."'            
            ");        
       $statement->execute();
       return $statement->fetch(PDO::FETCH_ASSOC);
	}


	public static function getCommonMainItems($mainitem){
		$dataSelected = self::getData($mainitem);
		$bodytextHTML = $dataSelected[0][$dataSelected[1][2]];
		$item = $dataSelected[0][$dataSelected[1][0]];
		$db = DB::getInstance();
		$statement = $db->prepare("
			SELECT * FROM common 
			WHERE id = '".$item."'            
		");        
       $statement->execute();
	   $data = $statement->fetch(PDO::FETCH_ASSOC);
       return $data;
	}


	public static function getCommonCats(){
		$db = DB::getInstance();
		$statement = $db->prepare("
            SELECT * FROM categories 
            WHERE tablename = 'common' ORDER BY sort          
            ");        
       $statement->execute();
	   $data = $statement->fetchall(PDO::FETCH_ASSOC);
       return $data;	   
	}

	public static function getCommonList($catid){
		$db = DB::getInstance();
		$statement = $db->prepare("
		SELECT * FROM common 
		WHERE categoryid = '".$catid."' ORDER BY sort          
		");        
		$statement->execute();
		$data = $statement->fetchall(PDO::FETCH_ASSOC);
		return $data;	   
	}

	public static function geItemPics($itemid, $limit){
		$db = DB::getInstance();
		$statement = $db->prepare("
		SELECT * FROM commonphotos
		WHERE relid = '".$itemid."' ORDER BY id DESC LIMIT ".$limit."   
		");        
		$statement->execute();
		$data = $statement->fetchall(PDO::FETCH_ASSOC);
		return $data;	   
	}

	public static function getCommonDetail($comid){
		$db = DB::getInstance();
		$statement = $db->prepare("
		SELECT * FROM common 
		WHERE id = '".$comid."'
		");        
		$statement->execute();
		$data = $statement->fetch(PDO::FETCH_ASSOC);
		return $data;	   
	}

}