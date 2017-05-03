<?php

//include "conns/connection.php";
//include 'languages/ge.php';  

echo "text";

/*$errors = array(); 
if(isset($_POST["username"]))
{
	$username = mysql_real_escape_string(stripslashes(trim(@$_POST['username'])));
	$algo = 'sha256';
	$strlen = strlen($username);
	if($strlen==0)	{ $data =0;	} else { $data=$username; }
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&uname='.$username.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		echo "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		$comment = $xml->comment;
		echo "<span>".$comment."</span>\n";
	}
}//username

if(isset($_POST["email"]))
{
	$email = mysql_real_escape_string(stripslashes(trim(@$_POST['email'])));
	$strlen=strlen($email);
	if($strlen==0)	{ $data =0;	} else { $data=$email; }
	$algo = 'sha256';
	//$data = $email;
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&email='.$email.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode==0)
	{
		echo "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		$comment = $xml->comment;
		echo "<span>".$comment."</span>\n";
	}
}//email

if(isset($_POST["mobile"]))
{
	$mobile = mysql_real_escape_string(stripslashes(trim(@$_POST['mobile'])));
	$strlen=strlen($mobile);
	$algo = 'sha256';
	if($strlen==0)	{ $data = 0;	} else { $data=$mobile; }
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&mobile='.$mobile.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		echo "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		//echo "text";
		$comment = $xml->comment;
		echo "<span>".$comment."</span>\n";
	}
	//}
}//mobile

*/
?>