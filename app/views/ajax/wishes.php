<link rel="stylesheet" href="http://localhost/public/css/jquery.remodal.css">
<link rel="stylesheet" href="http://localhost/public/css/multiple-select.css"/>
<?php if(isset($this->data['wishes'])): ?>
<?php foreach($this->data['wishes'] as &$wish): ?>
    <div class="wish-item">
        <div class="wish-header">            
            <a href="<?=URL::getPath('profile/viewWish?wid='.$wish['id'])?>"><?php echo $wish['title']; ?></a> <?php echo date('d.m.Y H:m',strtotime($wish['added'])); ?>
        </div>
		<div class="full-width wish-privacy">
            <?php
				//echo $wish['privacy'];
                echo WishHelper::drawPrivacy(
				$wish['id'], 
				$this->data['privacies'], 
				$wish['privacy']
				); 
            ?>
       <!-- <button type="submit" class="right" id="status-form-submit" onclick='change_privacy("<?=$wish['id']?>", $(this).parent().find("select").val()); '>ganaxleba</button>-->
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
            ?>
            <?php echo $wish['text']; ?>
        </div><!-- wish-body -->
    </div><!-- wish-item -->
	<a href='#wish<?php echo $wish['id']; ?>'>list</a>
	<script src="http://localhost/public/js//jquery.remodal.js"></script>
	<div data-remodal-id="wish<?php echo $wish['id']; ?>">
        <h1>მონიშნე მეგობრები</h1>
			<div>
			<form action="#" name="friendList" method="POST">
			<select id="selectFriends<?php echo $wish['id']; ?>" multiple="multiple">
				<option value="1">January</option>
				<option value="2">February</option>
				<option value="3">March</option>
				<option value="4">April</option>
				<option value="5">May</option>
				<option value="6">June</option>
				<option value="7">July</option>
				<option value="8">August</option>
				<option value="9">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
			 <!--<input type="button" name="ViewReport" value="View" class="bnotes" onclick="selectFriends();">-->
			</form>			
			<script src="http://localhost/public/js/jquery.multiple.select.js"></script>
			<script type="text/javascript">
			/*$(function() {
				$('#selectFriends'+<?=$wish['id']; ?>).multipleSelect();
			});
			function selectFriends(wishid)
			{
			    var wishid = wishid;
				var InvForm = document.forms.friendList;
				var selectFrValues = "";
				 $('#selectFriends option:selected').each(function() {
					var selval= $(this).val();
					if(selectFrValues !="")	{
						selectFrValues = selectFrValues + "," + selval;
					} else {
					  selectFrValues = selval;
					}
					friendid = selval;
					//addFriendInAccessList(wishid, friendid);
					//bazashi unda daematos monishnuli friend tavisi wish id-t
				});
				//alert(selectFrValues);
				//addFriendInAccessList(wishid, selectFrValues);
				//bazashi unda daematos monishnuli friend tavisi wish id-t
			}*/
			//var inst = $('[data-remodal-id=modal]').remodal();
			//inst.close();
			</script>
			</div>
			<div><a onclick="selectFriends(25);" class="remodal-confirm" href="#">არჩევა</a></div>
 </div>
<?php endforeach; ?>
<?php else: ?>
<p class="no-wishes">სურვილები არ მოიძებნა</p>
<?php endif; ?>
<script type="text/javascript">
	jQuery(document).ready(function(){ 
	$(".click").click(function(){
		var currendidname = $(this).attr("id");
		var currendid = '#'+currendidname;
		var dval = $(this).attr("data-value");
		var ulid = '#wish-privacy'+dval;
		//alert(ulid);
		$(".wish-privacy ul").hide();			
		$(ulid).slideDown(200);
		$(ulid+' li').slideDown(200);
		var allOptions = $(ulid).children('li');
		$(ulid).on("click", "li", function() {
			allOptions.removeClass('selected');
			$(this).addClass('selected');
			var lidval = $(this).attr("data-value");
			var wid = dval;
			change_privacy(wid, lidval);
			$(currendid).html($(this).html());
			allOptions.slideUp();
			$(ulid).slideUp();
		});//ulid func
	});//click
});//document
</script>
