<?php
foreach($this->data['found'] as $w) :
	$username = (string)$w->username;
	$u_id = (string)$w->u_id;
	$regist_date = (string) $w->regist_date;
	$first_name = (string)$w->first_name;
	$last_name =  (string)$w->last_name;
	$mobile = (string)$w->mobile;
	$email = (string)$w->email;
	$profilepic = (string)$w->profilepic;
	$blocked = (string)$w->blocked;
	$fullname = $first_name." ".$last_name;
	if($profilepic == 0)
	{
		$userprofilepic = "/images/friendpic.png";
		$usertext = 'მომხმარებელს '.$fullname.' არ აქვს ფოტო';
	} else {
		$userprofilepic = $profilepic;
	}
	//echo $u_id;
	$areFriends = ProfileModel::areFriends($this->userData[0], $u_id);  
	if($areFriends == 0)
	{
		$hasRequest = ProfileModel::hasRequest($this->userData[0], $u_id);
		if($hasRequest == 0)
		{
			$addfriendaction = "<a href='#' onclick=\"addFriend($u_id, 'd2ds4g');"."return false;\"><button>დამეგობრება</button></a>";
		} else {
			$addfriendaction = "<a href='#' onclick=\"cancelFriend($u_id, 'd2ds4g');"."return false;\"><button>შეთავაზება გაგზავნილია(გაუქმება)</button></a>";	
			//$addfriendaction = "<a href='#' onclick=\"deleteRequest($activeuser, $u_id);"."return false;\"><button>შეთავაზება გაგზავნილია</button></a>";	
		}
	} else { $addfriendaction = ""; }
    ?>
	<div>
		<?php echo "<a href='/profile/".$username."'><img src='".$userprofilepic."' alt='".$fullname."' />"; echo $fullname; ?></a>
		<?php echo "<p id='frb'>".$addfriendaction."</p>"; ?>
	</div>
    <?php	
endforeach;    