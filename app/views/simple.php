<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Make your case online</title>
	<meta name="generator" content="editplus" />
	<meta name="author" content="" />
	<meta name="keywords" content="ატვირთე ფაილები, upload and store yor files permanently" />
	<meta name="description" content="" />
	
	<script type="text/javascript" src="/jquery/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="/jquery/resize.js" /></script>
	<script type="text/javascript" src="/public/js/a.js" /></script>
	<script type="text/javascript" src="/public/js/self.js" /></script>
	<script type="text/javascript" src="/public/js/status.js" /></script>
	
	<link type="text/css" rel="stylesheet" href="/public/css/userprofile.css" />
	<link type="text/css" rel="stylesheet" href="/public/css/wish.css" />
	<link type="text/css" rel="stylesheet" href="/public/css/inner.css" />
	<link type="text/css" rel="stylesheet" href="/public/css/friends.css" />
	<link type="text/css" rel="stylesheet" href="/public/css/main.css" />

	<script type="text/javascript">
		$(document).ready(function(){
		oldValue = $('#search').val();
		$('#search').focus(function() {
			sityva = $(this).val();
			if(oldValue == sityva){
				$(this).val("");
			}
		}).blur(function() {
			if($(this).val() == ""){
				$(this).val(oldValue);
			}
		});
		});
	</script>

 </head>
  <body> 
	<?php
	$this->loadView('inc/header');
	?>
	<section>
		<?php 
		$this->loadView($view); 
		?>
	</section>
	<footer>
		<div>© 2017 <a href='http:quantum.ge' target='_blank'>Alternet</a> LTD</div>
	</footer>
</body>
</html>