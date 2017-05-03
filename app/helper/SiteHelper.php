<?php

class SiteHelper extends Helper {
    
	
	
	public static function generateOptionTags($options)
	{
		$str = '';
        
        $current = $options['current'];
				
	    foreach ($options['data'] as $data){
	        $str .= '<option value="'.$data[$options['k']].'" '.($current==$data[$options['k']]?' selected="selected"':'').'>'.$data[$options['v']].'</option>';
	    }  
		
		return $str;
	}
	
  
    /**
     * Get alert box, bootstrap styled
     * @param string $message
     * @param string $type defaults to 'info'. available: warning,danger,success,block,
     * @return type
     */
    public static function getAlert($message,$type="info"){
        return "
            <div class='alert alert-$type'>
                <!--<button type='button' class='close' data-dismiss='alert'>×</button>-->
                $message
            </div>";
    }
    
    /**
     * Get message p, bootstrap styled
     * @param string $message
     * @param string $type defaults to 'info'. available: warning,danger,success,muted
     * @return type
     */
    public static function getMessage($message,$type="info"){
        return "<p class='text-$type'>$message</p>";
    }

	public static function getShortenedHtmlText($bodytextHTML, $characterLimit){
	$bodytextNoTags = strip_tags($bodytextHTML);
	$bodytextNoTags = str_replace("&#160;", " ", $bodytextNoTags);
	$limitChars = $characterLimit;
	$shortenedHtmlText = mb_substr($bodytextNoTags, 0, $limitChars,'UTF-8');
	for($i=1; $i<100; $i++){
		if(mb_substr($shortenedHtmlText,(mb_strlen($shortenedHtmlText,'UTF-8')-$i), 1,'UTF-8')==" "){
			$shortenedHtmlText = mb_substr($shortenedHtmlText,0,((mb_strlen($shortenedHtmlText,'UTF-8')+1)-$i),'UTF-8')."...";
			break;
		}
	}
	return $shortenedHtmlText;
}

public static function getUserValid($fieldvalidate, $fnumber){
include 'languages/ge.php';  
$errors = array(); 
if($fnumber==1)
{
	$username = $fieldvalidate;
	$algo = 'sha256';
	$strlen = strlen($username);
	if($strlen == 0)	{ $data = 0;	} else { $data = $username; }
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&uname='.$username.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		$return = "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		$comment = $xml->comment;
		$return = "<span>".$comment."</span>\n";		
	}
	return $return;
}//username

if($fnumber == 2)
{
	$email = $fieldvalidate;
	$strlen = strlen($email);
	if($strlen == 0)	{ $data =0;	} else { $data=$email; }
	$algo = 'sha256';
	//$data = $email;
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&email='.$email.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		$return = "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		$comment = $xml->comment;
		$return = "<span>".$comment."</span>\n";		
	}
	return $return;
}//email

if($fnumber == 3)
{
	$mobile = $fieldvalidate;
	$strlen = strlen($mobile);
	$algo = 'sha256';
	if($strlen == 0)	{ $data = 0;	 } else { $data=$mobile; }
	$hashcode = hash($algo, $data, false);
	$url = 'http://service.ge/xml_moduls/ajax-validation.php?cat=users&mobile='.$mobile.'&hash='.$hashcode;
	$xml = simplexml_load_file($url);
	$resultcode = $xml->result;
	if($resultcode == 0)
	{
		$return = "<img src='images/ok_valide.png' alt='სწორია'>";
	} else { 
		$comment = $xml->comment;
		$return = "<span>".$comment."</span>\n";		
	}
	return $return;
}//mobile


}//
    
    

    
}