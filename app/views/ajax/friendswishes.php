	<?php if(isset($this->data['wishes'])): ?>
	<?php foreach($this->data['wishes'] as &$wish): ?>
	<?php
	$wish_user_id = $wish['user_id'];
	$algo = 'sha256';
	$data = "usercheck".$wish_user_id;
	$hashcode = hash($algo, $data, false);	
	$url = 'http://service.ge/xml_moduls/userinfo.php?cat=usercheck&userid='.$wish_user_id.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		$user_id = (string)$xml->info->u_id;
		$mobile = (string)$xml->info->mobile;
		$first_name =  (string)$xml->info->first_name;
		$last_name =  (string)$xml->info->last_name;
		$profile_pic =  (string)$xml->info->profile_pic;
		$email =  (string)$xml->info->email;
		$full_name = $first_name." ".$last_name;
		if(empty($profile_pic))
		{
			$profilepic = "<img src='/images/userprofile.png' width='50' height='50'  alt='".$full_name."' />\n";
		}
		else {
			$profilepic = "<img src='".$profile_pic."' width='50' height='50' alt='".$full_name."' />\n";
		}
		?>
		<div class='wishblock'>
			<div class='profilepic'><?= $profilepic; ?></div><!--profilepic-->
			<div class='rightblock'>
				<div class='user_full_name'><?= $full_name; ?></div><!--user_full_name-->
				<div class="wish-item">
					<div class="wish-header">            
						<a href="<?=URL::getPath('profile/viewWish?wid='.$wish['id'])?>"><?php echo $wish['title']; ?></a> <?php echo date('d.m.Y H:m',strtotime($wish['added'])); ?>
					</div>
					<div class="wish-body">
						<?php
							if($wish['type'] == 'photo'){                    
								$filedata = FileModel::getFile($wish['file_id']);
								?>
								<a href="<?=URL::getPath('profile/viewWish?wid='.$wish['id'])?>"><img src="<?=PATH_TO_PRIVATE?>/pht/thmb/a/<?=$filedata['name'].'.'.$filedata['extension']?>" /></a>
								<?php
								$filedata = null;
							}
							echo $wish['text']; 
						?>
					</div><!-- wish-body -->
				</div><!-- wish-item -->
			</div><!-- rightblock -->
		</div><!-- wishblock -->
		<?php 
	}	
	endforeach; ?>
	<div class='backtoprofile'><a href='/profile'>პროფილზე გადასვლა</a></div>
	<?php else: ?>
	<p class="no-wishes">სურვილები არ მოიძებნა</p>
<?php endif; ?>