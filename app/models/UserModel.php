<?php
class UserModel extends Model {    
	protected $table = "users";	
    /**
     * Check is user+pass exists
     * @param type $user
     * @param type $pass
     * @return type
    */
    public static function CheckUser($user, $pass) {
        //echo "hey too late";
        $db = DB::getInstance();        
        /* $sth = $db->prepare("
            SELECT * 
            FROM users 
            WHERE user = :user AND pass = :pass
        ");*/
		$username = $user;
		$password = $pass;
		$algo = 'sha256';
		$data = "login".$username.$password;
		//bool $raw_output
		$hashcode = hash($algo, $data, false);	
		$url = 'http://service.ge/xml_moduls/usercheck.php?cat=login&username='.$username.'&password='.$password.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		// get first book title
		$resultcode = $xml->result;
		// show title
		$resultcode;
		$login_user = array();
		if($resultcode == 0)
		{
			/*$user_id = (string)$xml->info->u_id;
			$username = (string) $xml->info->username;
			$first_name = (string)$xml->info->first_name;
			$last_name = (string)$xml->info->last_name;
			$email = (string)$xml->info->email;
			$profilepic = (string)$xml->info->profilepic;
			$password = (string)$xml->info->password;*/
			$login_user[] = (string)$xml->info->u_id;
			$login_user[] = (string)$xml->info->username;
			$login_user[] = (string)$xml->info->first_name;
			$login_user[] = (string)$xml->info->last_name;
			$login_user[] = (string)$xml->info->birthday;
			$login_user[] = (string)$xml->info->birthmonth;
			$login_user[] = (string)$xml->info->birthyear;
			$login_user[] = (string)$xml->info->mobile;
			$login_user[] = (string)$xml->info->email;
			$login_user[] = (string)$xml->info->profilepic;
			$login_user[] = (string)$xml->info->password;
			// show title
			/*$_SESSION['id'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['email'] = $email;
			$_SESSION['profilepic'] = $profilepic;
			$_SESSION['password'] = $password;*/
		} 
        //$sth->bindParam(':user',$user,PDO::PARAM_STR);
        //$sth->bindParam(':pass',$pass,PDO::PARAM_STR);
        //$sth->execute();
        //return $sth->fetch(PDO::FETCH_ASSOC);
		return $login_user;        
    }    

	public static function registUser($user) {
		echo $fname = @$user["firstName"];
		$lname = @$user["lastName"];
		$bday = @$user["day"];
		$bmonth = @$user["month"];
		$byear = @$user["year"];
		$mobile = @$user["mobile"];
		$uname = @$user["registusername"];
		$email = @$user["email"];
		$pass1 = @$user["registpassword"];
		$pass2 = @$user["registpassword2"];
		$agreement = @$user["agreement"];

		if(empty($fname)){ $fname = 0; }
		if(empty($lname)){ $lname = 0; }
		if(empty($bday)){ $bday = 0; }
		if(empty($bmonth )){ $bmonth = 0; }
		if(empty($byear)){ $byear = 0; }
		if(empty($uname)){ $uname = 0; }
		if(empty($email)){ $email = 0; }
		if(empty($pass1)){ $pass1 = 0; }
		if(empty($pass2)){ $pass2 = 0; }
		if(empty($agreement)){ $agreement = 0; }

		$siteid = 1;
		$algo = 'sha256';
		$data = 'registtrue'.$uname.$pass1.$pass2.$fname.$lname.$bday.$bmonth.$byear.$mobile.$email.$agreement.$siteid;
		$hashcode = hash($algo, $data, false);	
		$url = 'http://service.ge/xml_moduls/regist_user.php?cat=users&uregist=true&uname='.$uname.'&pass1='.$pass1.'&pass2='.$pass2.'&fname='.$fname.'&lname='.$lname.'&bday='.$bday.'&bmonth='.$bmonth.'&byear='.$byear.'&mobile='.$mobile.'&email='.$email.'&agreement='.$agreement.'&siteid='.$siteid.'&hash='.$hashcode;
		$xml = simplexml_load_file($url);
		//print_r($xml);
		$resultcode = $xml->result;
		$comment = $xml->comment;
		return $xml;
		/*if($resultcode == 1)
		{
			$errors = $xml->info->error[0][0];
			$errornumber = $xml->info->errornumber;
			if($errornumber>0)
			{
				echo "<ul class='error_list'>\n";
				for($i=0; $i<$errornumber; $i++)
				{
					$error = $xml->info->error[$i];
					echo "<li>".$error."</li>\n";
				}
				echo "</ul>\n";
			}
			//include "includes/users/errorUpdateForm1.php";			
		}
		else
		{
			//return 0;
			echo "<div class='succregisttext'>\n";
			echo "<p>რეგისტრაციის დასასრულებლათ გთხოვთ მიუთითოთ თქვენს მობილურ ტელეფონზე/ელფოსტით მიღებული სმს კოდი</p>\n"; 
			echo "<p>იმ შემთხვევაში თუ ვერ მიიღებთ sms კოდს:<a href='?cat=users&amp;state=code'>კოდის მიღება</a>.</p>\n";
			echo "</div><!--succregisttext-->\n";
			include "includes/login/smsloginform.php";
		}*/
		
	}
    /*public static function updateUser($user,$data) {
        return true;
    }*/    
}