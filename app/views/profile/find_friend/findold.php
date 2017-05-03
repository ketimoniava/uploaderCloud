<div class='friendpage'>
<h1>მეგობრები</h1>
<form action="" method="get">
	<fieldset>
	<legend>მოძებნე მეგობარი</legend>
	<label for='findfriends'>მოძებნე მეგობარი</label>
    <input type="text" name="findfriends" id='findfriends' />
    <button type="submit">ძიება</button>
    </fieldset>
</form>
<div class='found-friends'>
	<?php
	if($this->data['found']) :
		foreach($this->data['found'] as $found) :
		?>
		   <div class="found-friend">
			<?= $found['fullName'] ?>
			<?php
				if($found['isfriend']) {
					echo "<button disabled='disabled'>მეგობარი</button>\n";                    
					$removeKey = URL::generateKey(array($found['id'], 'remove'));
					echo "<button onclick=\"unFriend($found[id],'$removeKey');\">წაშლა</button>\n";
				} else {
				  echo "<a href='#' onclick=\"addFriend($found[id],'d2ds4g');"
							. "return false;\"><button>დამეგობრება</button></a>";
				}
			?>
		   </div><!--found-friend-->
		<?php
		endforeach;    
	endif;
	//echo '<pre>';
	//var_export($this->data['found']);
	?>
   </div><!-- found-friends -->
 </div><!-- friendpage -->