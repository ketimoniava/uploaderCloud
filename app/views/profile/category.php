 <link type='text/css' rel='stylesheet' href='/styles/wishcat.css' media='all' />
 
 <div class='catblock'>
	  <form action='?act=<?php echo $this->data['act']; ?>&id=<?php echo $this->data['catid']; ?>' method='post'>
			<fieldset>
				<label for='catname'>კატეგორია</label>
				<input type='text' name='catname' value='<?php echo @$this->data['catname']; ?>' id='catname' autofocus  />
				 <button type="submit" class="right" id="status-form-submit">განათავსე</button>
			</fieldset>
	  </form>


	  <div class='<?=$this->data['result']?>code'><?=$this->data['message']?></div><!--errcode-->
	  <h1>კატეგორიები</h1>
	  <ul class='catcategories'>
		<?php foreach ($this->data['categories'] as  $cat) :
				echo "<li>$cat[name] (<a href='?act=edit&id=$cat[id]'>განახლება</a>
							/
							<a onclick='return confirm(\"Delete category\")' href='?act=del&id=$cat[id]'>წაშლა</a>)</li>";
		endforeach;?>
	  </ul><!--catcategories-->
  </div><!--catblock-->