<style type="text/css">
    .form-signin {
        max-width: 230px;
        padding: 20px 20px 20px 20px;
		margin: 10px auto;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
	.form-signin fieldset { 
		border: 0px;
	 }
	 .form-signin legend { 
		  padding-bottom: 10px;
	  }
	  .form-signin button { 
			padding: 5px;
			border: 0px solid #DADADA; 
			background: #36897C; 
			font: 0.77em/1.3em sylfaen;
			color: #F2F2F2;
			border-radius: 5px;
			}
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
		border: 1px solid #DADADA;
    }
</style>
<div class='regist_block'>
<?php
	if(isset($this->data['errors'])) {
		$errornumber = $this->data['errors'] ->errornumber;
		if($errornumber>0){
			echo "<ul class='error_list'>\n";
			for($i=0; $i<$errornumber; $i++){
				$error = $this->data['errors']->error[$i];
				echo "<li>".$error."</li>\n";
			}
			echo "</ul><!-- error_list -->\n";
		}//error number 
	}//
?>
<form action='?cat=users&amp;regist=true' method='post' enctype='multipart/form-data' class='form-horizontal'>
	<fieldset>
		<legend>რეგისტრაცია</legend>
		<span>სავალდებულო ველები აღნიშნულია * სიმბოლოთი</span>
		<div>
			<label for='firstName'>First name *</label>
			<input type='text' name='firstName' id='firstName' />
		</div>
		<div>
			<label for='lastName'>Last name *</label>
			<input type='text' name='lastName' id='lastName' />
		</div>
		<div>
			<label for='mobile'>Mobile number *</label>
			<input type='text' name='mobile' id='mobile' />
			<span>(XXX XXXXXX)</span>
			<p class='error_msg' id='mobileValidate'></p>
		</div>
		<div>
			<label for='email'>Email *</label>
			<input type='text' name='email' id='email'  />
			<p class='error_msg' id='emailValidate'></p>
		</div>
		<div>
			<label for='registpassword'>Password *</label>
			<input type='password' name='registpassword' id='registpassword' />
		</div>		
		<div class='agreement'>
			<label for='agreement'>I agree <a href='index.php?cat=common&amp;cat_id=2'>rules</a></label>
			<input type='checkbox' name='agreement' value='1' id='agreement' />
		</div><!-- agreement -->
		<input type='submit' name='submit_registration' value='რეგისტრაცია' />	
	</fieldset>
</form>
</div><!-- regist_block -->
</div><!-- security_topics -->
<div class='login_block'>
	<form class="form-signin" action="" method="post" role="form">
		<fieldset>
			<legend>შესვლა</legend>
			<?php if(isset($this->data['message'])): ?>
				<div class="alert alert-danger">
					<?= $this->data['message'] ?>
				</div>
			<?php endif; ?>
			<input type="text" value="<?= $this->data['vf']->getValue('g_user') ?>" class="form-control" placeholder="სახელი" name="g_user" />
			<input type="password" class="form-control" placeholder="პაროლი" name="g_pass" />
			<label><input type="checkbox" value="remember-me" checked="checked" disabled="disabled" name="g_remember_user" /> დამიმახსოვრე</label>
			<button class="btn btn-lg btn-info btn-block" type="submit">ავტორიზაცია</button>
		</fieldset>
	</form>
</div><!-- fb_login_forms -->
<script type="text/javascript" src="/public/js/login.js" /></script>




