<?php if(isset($this->data['file'])): ?>
<?php $file = &$this->data['file']; ?>
<div class="wish-item">
	<div class="wish-header"><?php echo $wish['title'].' - '.date('d.m.Y H:m', strtotime($wish['added'])) ?></div>
	<div class="-body">
			<?php
			if($wish['type'] == 'photo'){                    
				$filedata = FileModel::getFile($wish['file_id']);
				?>
					<img src="<?=PATH_TO_PRIVATE?>/pht/thmb/a/<?=$filedata['name'].'.'.$filedata['extension']?>" />   
				<?php
				$filedata = null;
			}
		?>            
		<?php echo $wish['text']; ?>
	</div>
	<div class="wish-actions">
		<ul class="wish-action-items">                
			<?php if($file['user_id'] == $this->userData[0]) : ?>
			<li><a onclick="return confirm('Do you wont to delete file')" href="<?=WishHelper::getWishURL($file['id']).'&act=delW'?>">Delete file</a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
<?php endif;