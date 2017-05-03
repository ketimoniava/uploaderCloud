<?php
	function logger($message){
	   //echo '<pre>';    
	  	if(is_object($message)):
			$message = get_object_vars($message);
		endif;
		if(is_array($message)):
		//print_r($message);
		else:
		  $message;
		endif;
	   //echo '<pre>';
	}
	include "class.phpmailer.php";
	logger('retrieved mailer class');

	$mail = new PHPMailer();
	logger('instantiated php mailer');

	$mail->IsSMTP(); // send via SMTP
	$mail->SMTPDebug = 5;
	logger('set phpmailer to SMTP');

	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';

	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "auction@service.ge"; // SMTP username
	$mail->Password = "Keti123456789"; // SMTP password

	$mail->From = "auction@service.ge";
	$mail->FromName = "auction.service.ge";
	///"ketevan.moniava@quantum.ge", "Ketevan Moniava"
	/*$mail->AddAddress($to);
	logger('added address to mail object');
	$mail->IsHTML(true); // send as HTML
	$mail->Subject = $subject;
	$mail->Body = $message; //HTML Body
	$mail->AltBody = "This is the body when user views in plain text format"; */
?>