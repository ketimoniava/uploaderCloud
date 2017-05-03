<?php
if(isset($this->data['CommonMain'])) {
	$commrow = $this->data['CommonMain'];
	$commid = $commrow['id'];
	$pagetitle = $commrow['pagetitle'];
	$bodytext = $commrow['bodytext'];
	$categoryid = $commrow['categoryid'];		
	$body = SiteHelper::getShortenedHtmlText($bodytext, 650);	
}

if(isset($this->data['CommonMainOne']) &&isset($this->data['CommonMainTwo']) &&isset($this->data['CommonMainThree'])) {
	$commrow1 = $this->data['CommonMainOne'];
	$commrowPic1 = $this->data['CommonMainOnePic'];
	$commid1 = $commrow1['id'];
	$pagetitle1 = $commrow1['pagetitle'];
	$bodytext1 = $commrow1['bodytext'];
	$categoryid1 = $commrow1['categoryid'];		
	$img1 = '';
	$body1 = SiteHelper::getShortenedHtmlText($bodytext1, 250);	
	foreach($this->data['CommonMainOnePic'] as $commrowPic1) {
		$itempic1 = $commrowPic1['filename'];	
		$img1 = "<div class='aicon'><a href='/common/?comid=".$commid1."'><img src='prv/common/original/".$itempic1."' alt='".$pagetitle1."' /></a></div>\n";
	}
	
	$commrow2 = $this->data['CommonMainTwo'];
	$commrowPic2 = $this->data['CommonMainTwoPic'];
	$commid2 = $commrow2['id'];
	$pagetitle2 = $commrow2['pagetitle'];
	$bodytext2 = $commrow2['bodytext'];
	$categoryid2 = $commrow2['categoryid'];		
	$img2  = '';
	$body2 = SiteHelper::getShortenedHtmlText($bodytext2, 250);	
	foreach($this->data['CommonMainTwoPic'] as $commrowPic2) {
		$itempic2 = $commrowPic2['filename'];	
		$img2 = "<div class='aicon'><a href='/common/?comid=".$commid2."'><img src='prv/common/original/".$itempic2."' alt='".$pagetitle2."' /></a></div>\n";
	}	
	$commrow3 = $this->data['CommonMainThree'];
	$commrowPic3 = $this->data['CommonMainThreePic'];
	$commid3 = $commrow3['id'];
	$pagetitle3 = $commrow3['pagetitle'];
	$bodytext3 = $commrow3['bodytext'];
	$categoryid3 = $commrow3['categoryid'];		
	$img3 = '';
	$body3 = SiteHelper::getShortenedHtmlText($bodytext3, 250);	
	foreach($this->data['CommonMainThreePic'] as $commrowPic3) {
		$itempic3 = $commrowPic3['filename'];	
		$img3 = "<div class='aicon'><a href='/common/?comid=".$commid3."'><img src='prv/common/original/".$itempic3."' alt='".$pagetitle3."' /></a></div>\n";
	}
}
?>

<div class='topbanner'>
		<iframe width="420" height="315" src="http://youtube.com/embed/9MMzAZKZdKc?rel=0" frameborder="0" ></iframe>
		<article>
			<h1><a href='/common/?comid=<?=$commid;?>'><?php echo $pagetitle; ?></a></h1>
			<p><?php echo $body; ?></p>
			<div><a href='/login'>რეგისტრაცია</a></div>
		</article>
</div><!--topbanner-->

<div class='about_company'>
	<div class='block1'>
		<?php echo $img1; ?>
		<h2><a href='/common/?comid=<?=$commid1;?>'><?php echo $pagetitle1; ?></a></h2>
		<div><?php echo $body1; ?></div>
		<span><a href='/common/?comid=<?=$commid1;?>'>ვრცლად..</a></span>
	</div><!--block1-->
	<div class='block2'>
		<?php echo $img2; ?>
		<h2><a href='/common/?comid=<?=$commid2;?>'><?php echo $pagetitle2; ?></a></h2>
		<div><?php echo $body2; ?></div>
		<span><a href='/common/?comid=<?=$commid1;?>'>ვრცლად..</a></span>
	</div><!--block2-->
	<div class='block3'>
		<?php echo $img3; ?>
		<h2><a href='/common/?comid=<?=$commid3;?>'><?php echo $pagetitle3; ?></a></h2>
		<div><?php echo $body3; ?></div>
		<span><a href='/common/?comid=<?=$commid1;?>'>ვრცლად..</a></span>
	</div><!--block3-->
</div><!--aboutblock-->