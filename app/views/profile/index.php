<div class='userprofile'>
	<div class='profile_info'>
		<h1><?php echo $this->userData[2]." ".$this->userData[3]; ?></h1>
		<p><?php echo $this->userData[1]; ?></p>
		<p><?php echo $birthdate; ?></p>
		<p><?php echo $this->userData[8]; ?></p>
		<p><?php echo $this->userData[7]; ?></p>
		<span><a href='#'>My profile</a></span>
		</div><!-- profile_info -->
		<div class="user-block">
			<div class="user-quick-nav">
				<button>My files</button>				
			</div>
		</div><!-- userblock -->
		<a href="<?=URL::getPath('profile/addshelf')?>">
			<button type="button">Add file</button>
		</a>
</div><!-- userprofile -->
<div class='activitycontainer'>
	<div class="shelf-container">
		<!-- <div class="shelf-item">
			<div class="shelf-header">This is some header</div>
			<div class="shelf-body">this is test shelf</div>
		</div> -->
	</div> 

<script type="text/javascript">
	$(function(){
		//Load shelfes
		//slimit, nlimit
		//loadUsershelfes(<?= $this->profileID ?>,'<?=shelfHelper::generateUserKey($this->profileID)?>');
		//, '<?= $total_groups ?>'
		loadUsershelfes1(<?= $this->profileID ?>,'<?=shelfHelper::generateUserKey($this->profileID)?>', '<?= $total_groups ?>');
	});
</script>
<div class="animation_image" style="display:none" align="center"><img src="/images/ajax-loader.gif"></div>
</div><!-- activitycont -->