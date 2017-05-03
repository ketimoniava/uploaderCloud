<?php
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
$mail->Username = "testservice@service.ge"; // SMTP username 
$mail->Password = "123456789"; // SMTP password

$mail->From = "testservice@service.ge";
$mail->FromName = "service.ge";
$mail->IsHTML(true); // send as HTML

$mail->Subject ='subject'
$mail->Body = 'mesage'; //HTML Body

$to='visac ginda rom gaugzavno imis meili'; 
$mail->AddAddress($to);
logger('added address to mail object');

logger('about to send message');
try{
$mail->Send();
logger('mail sent successfully over tls');
} 
catch (phpmailerException $e)
{

logger("Error sending mail \n" . $e->errormessage());
logger("trying alternative port");

try{
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->send();
logger('Mail sent successfully via alternative port');
} 
catch (phpmailerException $e ){
logger("Error sending mail with alternative port \n" . $e->errorMessage());
} 
catch (Exception $e) {
logger( $e->getMessage());
}
}
catch (Exception $e) {    
logger( $e->getMessage());
}
//array_push($mails, $bccmail.",");
unset($mail);
?>