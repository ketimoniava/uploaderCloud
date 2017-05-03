<div class='bodyarticle'>
<?php
if(isset($this->data['categories'])): 
	if(isset($_GET["comid"])){
		if(isset($this->data['commdetail'])):
			$commrow = $this->data['commdetail'];
			$commid = $commrow['id'];
			$headline = $commrow['pagetitle'];
			$bodytext = $commrow['bodytext'];
			$categoryid = $commrow['categoryid'];
			//$url = URL::getPath('common/'.$catid.'');
			//<a href='?catid=".$catid." '>
			echo "<h1>".$headline."</h1>\n";
			echo "<div>".$bodytext."</div>\n";
		endif;
	} else {
		$categoryid = @$_GET["catid"];
	}

	//COMMON PAGES 
	if(isset($this->data['commlist'])): 
	$commlist = $this->data['commlist'];		
	$i = 0;
	foreach($commlist as $commrow)
	{
		$rowcommid = $commrow['id'];
		if(isset($commid)) { if($commid == $rowcommid) { $show = false; } else { $show = true; } } else { $show = true; }
		if($show == true):
		$i++;
		endif;
	}
	if($i>0):
		echo "<div class='related-info'>\n";
		$categories = $this->data['categories'];	
		$categorytitle = '';
		foreach($categories as $categoryrow)
		{
			if($categoryrow["id"] == $categoryid)
			{
				$categorytitle = $categoryrow["title"];
			}
		}
		if(isset($_GET["catid"]))
		{
			echo "<h1>".$categorytitle."</h1>\n";
		} else {
		echo "<h2>".$categorytitle."</h2>\n"; }
		echo "<ul class='commonList'>\n";
		foreach($commlist as $commrow)
		{
			$rowcommid = $commrow['id'];
			if(isset($commid)) { if($commid == $rowcommid) { echo $show = false; } else { $show = true; } } else { $show = true; }
			if($show == true):
				$headline = $commrow['pagetitle'];			
				echo "<li><a href='?comid=".$rowcommid." '>".$headline."</a></li>\n";
			endif;
		}
		echo "</ul><!--commonList-->\n";
		echo "</div><!--related-info-->\n";
		endif;		
	endif;

	//CATEGORIES
	if(!isset($_GET["comid"])):
		//$num_rows = count($categories);
		//print_r($this->data['categories']);
		$categories = $this->data['categories'];	
		foreach($categories as $categoryrow)
		{
			$rowcatid = $categoryrow['id'];
			$i = 0;
			if(isset($categoryid)) { if($categoryid == $rowcatid) { $show = false; } else { $show = true; } } else { $show = true; }
			if($show == true):
				$headline = $categoryrow['title'];
				//$url = URL::getPath('common/'.$catid.'');
				//<a href='?catid=".$catid." '>
				//echo "<li><a href='?catid=".$rowcatid." '>".$headline."</a></li>\n";
				$i++;
			endif;
		}
		if($i>0):
			$categorytitle = 'კატეგორიები';
			if(isset($_GET["catid"]))
			{
				echo "<h2>".$categorytitle."</h2>\n";
			} else {
			echo "<h1>".$categorytitle."</h1>\n"; }
			echo "<ul class='commonList'>\n";
			foreach($categories as $categoryrow)
			{
				$rowcatid = $categoryrow['id'];
				if(isset($categoryid)) { if($categoryid == $rowcatid) { $show = false; } else { $show = true; } } else { $show = true; }
				if($show == true):
					$headline = $categoryrow['title'];
					//$url = URL::getPath('common/'.$catid.'');
					//<a href='?catid=".$catid." '>
					echo "<li><a href='?catid=".$rowcatid." '>".$headline."</a></li>\n";
				endif;
			}
			echo "</ul><!--commonList-->\n";	
		endif;		
	endif;
	if(isset($commid)):
		echo "<p class='backward'><a href='/common'>უკან</a></p>\n";
	endif;
endif;
?>
</div><!--bodyarticle-->
