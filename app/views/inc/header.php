<?php
	$isAuthed = User::isAuthed();
?>
<header>
	<div class='header_top'>
		<div class='inside_top'>
			<ul class='user_menu'>
				<li><a href='/common'>Online shelf</a></li>
				<li><a href='/profile'>My profile</a></li>
				<li><a href='/profile/addfile'>My case</a></li>
			</ul><!-- user_menu -->
			<?php
				$this->userData = User::getUserData();
				if($isAuthed){ 
					echo "<ul class='user_top_menu'>
					<li><a href='/logout'>Sign out</a></li>
					<li class='username'>Welcome, <a href='#'>".$this->userData[1]."</a></li>
					</ul><!-- user_top_menu -->\n";
				} else {
				  echo "<div class='login'><a href='/login'>Sign in</a></div>\n";
				}
			?>
		</div><!-- inside_top -->
	</div><!-- header_top -->
</header>