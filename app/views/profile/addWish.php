<div class="addwish-block">
    <div class=" user-quick-nav add-wish ">
        <form action="<?=URL::getPath('profile/AddWish')?>" id="status-form" enctype="multipart/form-data" method="post">
        <div class="full-width">
            <h1 class="left">სურვილის დამატება</h1>
        </div>
        <div class="full-width">
            <ul class="status-types">
                <?php $sType = $this->data['vf']->getValue('wish-type'); ?>
                <?php if($sType=='') $sType = 'status'; ?>
                <?php foreach(array('status'=>'სტატუსი','photo'=>'ფოტო','link'=>'ბმული') as $k=>$tp) : ?>
                <li>
                    <a href="#tab-status<?=('status'==$k?'':'-'.$k)?>" rel="<?=$k?>" 
                       class="<?=($sType==$k?'active':'')?>"><?=$tp?>
                    </a>
                </li>
                <?php endforeach; ?>
                <li class="right">
                <?php 
                    echo WishHelper::drawCategory(
                            $this->data['categories']  , 
                            $this->data['vf']->getValue('wish-category')
                    ); 
                ?>
                </li>
            </ul>  
            <input type="hidden" name="wish-type" id="status-type" value="<?=$sType?>" />
        </div>
        <div class="full-width tab-content">
            <div id="tab-status" class="s-tab <?=$sType=='status'?'open':''?>">                
            </div>
            <div id="tab-status-photo" class="s-tab <?=$sType=='photo'?'open':''?>">
                <div id="status-photo-file">                   
					<label>მიუთითეთ ფოტო</label>         
                    <input type="file" name="wish-photo" />
                </div>
            </div>
            <div id="tab-status-link" class="s-tab <?=$sType=='link'?'open':''?>">
				<label for='wish-link'>ბმულის/ლინკის მისამართი</label>                
                <input type="text" name="wish-link" id="wish-link" value="<?=$this->data['vf']->getValue('wish-link')?>" />
            </div>
        </div>    
        <div class="full-width">
			<div>
				<label for='wish-title'>სათაური</label>
				<input type="text" name="wish-title" id="wish-title" value="<?=$this->data['vf']->getValue('wish-title')?>" />
			</div>
			<div>
            <label for='wish-text'>ტექსტი</label>
            <textarea class="status-box" name="wish-text"><?=$this->data['vf']->getValue('wish-text')?></textarea>
			</div>
			<div>
				 <label for='wish-end-date'> სურვილის ვადა</label>           
				<input type="date" name="wish-end-date"  />
			<div>
        </div>
        <div class="full-width post-status">
            <?php 
                echo WishHelper::drawPrivacy(
					$this->data['privacies']
					,
					$this->data['vf']->getValue('wish-privacy')
				 ); 
            ?>
            <button type="submit" class="right" id="status-form-submit">განათავსე</button>
        </div>
        </form>
    </div><!--ser-quick-nav add-wish-->
	<div class="wish-message">
		<?=isset($this->data['message'])?$this->data['message']:''?>
	</div>
	<div class='backtoprofile'><a href='/profile'>პროფილზე გადასვლა</a></div>
</div><!--user-block-->