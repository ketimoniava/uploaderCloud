 <?php  
  //echo "ddsdsdsdqqqqqqqqqqqqq";
 class user
 {
	//echo "ddsdsdsdqqqqqqqqqqqqq";
    public $id;
    public $firstName;
    public $lastName;
    
    public $phone;
    public $mobile;
	 //public $old_mobile;
    public $web;
    
    public $nickName;
	public $old_nickName;
    public $password          = 'password';
    public $password2      = 'password';
    public $oldPassword      = 'password';
    //public $oldPassword2  = 'password';
    public $newPassword      = 'password'; 
	public $newPassword2      = 'password'; 
    //public $type;
    public $yaer;
    public $month;
    public $day;
    //public $gender;
    public $email;   
    public $old_email;
    //public $security_code;
      
    public function registration($user)
    { 
       //include 'languages/ge.php'; 
       global $db;
       $this->nickName         =  $user['nickName'];
       $this->firstName      =  $user['firstName'];
       $this->lastName        =  $user['lastName'];
       
       
       $this->birthDay             =  $user['day'];
       $this->birthMonth             =  $user['month'];
       $this->birthYear          =  $user['year'];
	   //this->gender            =  $user['gender'];
       $this->phone            =  $user['phone'];
	   $this->mobile           =  $user['mobile'];
       $this->web              =  $user['web'];
       
       
       $this->password         =  $user['password'];
       $this->password2     =  $user['password2']; 
       $this->email            =  $user['email']; 
       //$this->type             =  $user['type'];       
       //$this->security_code    =  $user['security_code'];
       
       if($this->check_errors())
       {  
          return $this->check_errors();
       }else 
       { 
		  //$allow_email  = isset($user['allow_email']) ? 1 : 0;
		  //$allow_phone  = isset($user['allow_phone']) ? 1 : 0;
		$pass= md5($this->password);
        $time = time();
		  $date=date("Y-m-d h-m-s",$time);
		  //echo date(,$time)
		  $sql  = "INSERT INTO users (nickName, email, web, firstName, lastName, birthDay, birthMonth, birthYear, phone, mobile, regist_date, password) VALUES ('".$this->nickName."','".$this->email."', '".$this->web."','".$this->firstName."', '".$this->lastName."','".$this->birthDay."','".$this->birthMonth."','".$this->birthYear."','".$this->phone."','".$this->mobile."','".$date."','".$pass."')";
          mysql_query($sql) or exit('Error: ' . mysql_error());                 
          $to          = $this->email;
          $subject     = $_SERVER['SERVER_NAME'];
         $body        = "თქვენ წარმატებით გაიარეთ რეგისტრაცია!!! "."<br /> "."<a href='http://".$_SERVER['SERVER_NAME']."?category=login&amp;actuser=".$time."'>სისტემაში შესვლა</a>\n";
          $from        = $_SERVER['SERVER_NAME'];
          mail($to, $subject, $body, $from);
          //echo $this->first_name."<br />" . $this->last_name. "<br />". $this->nickName ."<br />" . $this->password. "<br />". $this->per_password ."<br />" .$this->email;      
       }//else
    }//function
    
	public function updatePassword($pass1,$pass2,$userID)
	 {
		global $db;
		$this->id=$userID;
		echo  $this->newPassword         =  $user['password1'];
        $this->newPassword2     =  $user['password2']; 
		 if($this->check_errors())
		   {  
			  return $this->check_errors();       
		   }
		   else  
		   {
			$pass=md5($this->newPassword);
			  $sql  = "UPDATE users SET password = '".$pass."' WHERE id = '".$this->id."'"; 
			  mysql_query($sql) or exit ('Error: '.mysql_error());
		   }  
	 }
    public function update($user,$userID)
    { 
       global $db;
       $this->id               =  $userID;
	   //echo $user['nickName'];
       //$this->nickName         =  $user['nickName'];
       $this->firstName      =  $user['firstName'];
       $this->lastName        =  $user['lastName'];
       
       
       $this->birthDay             =  $user['day'];
       $this->birthMonth             =  $user['month'];
       $this->birthYear          =  $user['year'];
	   //$this->gender            =  $user['gender'];
       $this->phone            =  $user['phone'];
	   $this->mobile           =  $user['mobile'];
       $this->web              =  $user['web'];
       
       $this->oldPassword    =  $user['oldPassword']; 
       $this->newPassword         =  $user['newPassword'];
       $this->newPassword2     =  $user['newPassword2']; 
       //$this->email            =  $user['email']; 
            
       //$this->security_code    =  $user['security_code']; 
       
       //$this->type             =  $user['type'];       
       
       if($this->check_errors())
       {  
          return $this->check_errors();       
       }
	   else  
       {
          //$allow_email  = isset($user['allow_email']) ? 1 : 0;
          //$allow_phone  = isset($user['allow_phone']) ? 1 : 0;        
        //echo $this->id;
        $pass=md5($this->newPassword);
          $sql  = "UPDATE users SET web = '".$this->web."', firstName = '".$this->firstName."', lastName = '".$this->lastName."', birthDay = '".$this->birthDay."', birthMonth = '".$this->birthMonth."', birthYear = '".$this->birthYear."', phone = '".$this->phone."', mobile = '".$this->mobile."', mobile = '".$this->mobile."', password = '".$pass."' WHERE id = '".$this->id."'"; 
          mysql_query($sql) or exit ('Error: '.mysql_error());
       }   
    }     
    public function check_errors()
    {
       include '../languages/ge.php';  
       global $db;
       $errors = array(); 
	    //echo "jjjjjjjjjjjjjj";
	   if(isset($this->nickName)&&isset($this->email))
		{
		   //echo "jjjjjjjjjjjjjj";
	   //echo $this->old_nickName;
	  // if(isset)
			  if(($this->old_nickName) != ($this->nickName))
			   { 
				//echo $this->nickName;
			   $select_nickName =mysql_query( "SELECT id, nickName FROM users WHERE nickName = '".$this->nickName."'"); 
				//$select_nickName1 = $db->query($select_nickName);
			   $check_nickName = mysql_num_rows($select_nickName);
			   if($check_nickName > 0 && $this->nickName != $this->old_nickName)
			   $errors[] = $err[0];  
				 if((strlen($this->nickName) < 6) || (strlen($this->nickName) > 25))
				$errors[] = $err[2];
			   else if(!preg_match("/^[A-Za-z][\w+.-]+$/" , $this->nickName))
				$errors[] = $err[3];  
			   
				}  
			   if(($this->old_email) != ($this->email)) 
			   { 
			   $select_email =mysql_query( "SELECT id, email FROM users WHERE email = '".$this->email."'"); 
			   //$select_email = $db->query($select_email);
			   $check_email = mysql_num_rows($select_email);
			   if($check_email > 0 && $this->email != $this->old_email)
				$errors[] = $err[1];   
			   }
			    if(!preg_match("/^[A-Za-z][\w._-]+@\w[\w-.]+\.[a-zA-Z]{2,3}(\.[a-zA-Z]{2,3})?$/" , $this->email))  
				 $errors[] = $err[6];
        }   
	   /*if((strlen($this->first_name) < 2) || (strlen($this->first_name) > 30))
        $errors[] = $err[9];
       else if(!preg_match("/^[A-Za-z][A-Za-z-]+$/" , $this->first_name)) 
        $errors[] = $err[10]; */             
		if((strlen($this->firstName) < 2) || (strlen($this->firstName) > 30))
       $errors[] = $err[11];
       else if(!preg_match("/[A-Za-zა-ჰ][A-Za-zა-ჰ]+$/" , $this->lastName)) 
       $errors[] = $err[10];
	
       if((strlen($this->lastName) < 2) || (strlen($this->lastName) > 30))
        $errors[] = $err[11];
       else if(!preg_match("/[A-Za-zა-ჰ][A-Za-zა-ჰ]+$/" , $this->lastName)) 
        $errors[] = $err[12];
        
       /*if(empty($this->work))
        $errors[] = $err[16]; 
        
       if(empty($this->city))
        $errors[] = $err[13];            
  
       if(empty($this->phone))
        $errors[] = $err[14];  
		*/
       if(empty($this->mobile)){
        $errors[] = $err[15]; }

		//echo $this->nickName;
          
       if(strlen($this->oldPassword)!=0)
		{
       if((strlen($this->oldPassword) < 6) || (strlen($this->oldPassword) > 25) || (strlen($this->newPassword) < 6) || (strlen($this->newPassword) > 30))
        $errors[] = $err[4];
       else if($this->newPassword != $this->newPassword2)
        $errors[] = $err[5]; 
        }
		
		if(strlen($this->newPassword)!=0)
		{
		   if((strlen($this->newPassword) < 6) || (strlen($this->newPassword) > 25) )
			$errors[] = $err[4];
		   else if($this->newPassword != $this->newPassword2)
			$errors[] = $err[5]; 
        }
       /*if($this->oldPassword != $this->oldPassword2)
        $errors[] = $err[8];       
        */
      
        
      // if($this->security_code != $_SESSION['captcha'])
        //$errors[] = $err[7]; 
       
       
       /*if(!empty($this->image_name))
       {
       if(($this->image_extension =='.jpg') || ($this->image_extension =='.jpeg') || ($this->image_extension == '.png') || ($this->image_extension == '.gif'))        
        $true;
       else
        $errors[] = $error[13];         
       }*/
       
                      
       if($errors)
        return $errors;
    }
    
    /*
    public function upload_image()
    {
       $image = 'avatars/'.$this->nickName.$this->image_extension;
       move_uploaded_file($this->image_tmp, $image);
    }  
    
    public function resize_image($img)
    {        
       $canvas_width  = 100;
       $canvas_height = 100;
    
       $canvas = imagecreatetruecolor($canvas_width, $canvas_height);
       list($img_width, $img_height) = getimagesize($img);
    
       switch($img)
      {
         case $this->image_extension == '.jpg' || $this->image_extension == '.jpeg':
         $original = imagecreatefromjpeg($img);
         break; 
         case $this->image_extension == '.png':
         $original = imagecreatefrompng($img);
         break;
         case $this->image_extension == '.gif':
         $original = imagecreatefromgif($img);
         break;
         
                
      }
    
    
       imagecopyresampled($canvas, $original, 0, 0, 
                      (($img_width / 2) - ( ($canvas_width /2 ) * 4)),
                      (($img_height / 2) - ( ($canvas_height /2 ) * 4)),
                      $img_width / 4 ,
                      $img_height / 4,
                      $img_width,
                      $img_height                      
                       );
    
       switch($img)
      {
         case $this->image_extension == '.jpg' || $this->image_extension == '.jpeg':
         imagejpeg($canvas, $img, 80);
         break;
         case $this->image_extension == '.png':
         imagejpeg($canvas, $img, 80);
         break;
         case $this->image_extension == '.gif':
         imagegif($canvas, $img, 80);
         break;       
      }                   
    }
    
    */
    
    public function login($nickName, $password)
    {
	   //BAZIDAN MOMXMAREBLIS MONACEMEBIS GAMOTANA SESIIS DAWYEBIS SHEMDEG
       global $db;
	   $nickName;
       $password1 =md5($password);       
		$sql   =mysql_query("SELECT id, nickName, email, web, firstName, lastName, phone, mobile, regist_date, blocked, password FROM users WHERE nickName = '".$nickName."' AND password = '".$password1."' AND blocked = '0'  LIMIT 1");
	    $login_result = array();
	    //echo "asdasd";
	   if (mysql_num_rows($sql)>0)
		{
		  echo $isUser=1;
		  $row=mysql_fetch_array($sql);
		 
		  $login_result[] = $row['id'];
          $login_result[] = $row['nickName'];
		  $login_result[] = $row['email'];
          $login_result[] = $row['web']; 
		  $login_result[] = $row['firstName'];
          $login_result[] = $row['lastName']; 
		 // $login_result[] = $row['gender'];
          $login_result[] = $row['phone']; 
		  $login_result[] = $row['mobile'];
          $login_result[] = $row['regist_date']; 
		  $login_result[] = $row['block'];
          $login_result[] = $row['password']; 
          //$login_result[] = $row['password'];  
		  return $login_result;
		}
		
       /*$login = $db->query($sql);
       
       $login_result = array();
       
       if($db->num_rows($login) > 0)
       {
          $row = $db->fetch_array($login);
          $login_result[] = $row['id'];
          $login_result[] = $row['nickName'];
          $login_result[] = $row['password'];    
       }*/
       
       
    }
    
    public function check_cookie()
    {
       global $db;
       if((isset($_COOKIE['id'])) && (isset($_COOKIE['nickName'])) && (isset($_COOKIE['password'])))
       {
          $sql  = mysql_query("SELECT id FROM users
		  WHERE id = '".$_COOKIE["id"]."' AND nickName = '".$_COOKIE["nickName"]."' AND password = '".$_COOKIE["password"]."' ");
		  $select=mysql_fetch_array($sql);
          //$select = $db->query($sql);
          if(mysql_num_rows($sql) > 0)
          {
             return true;
          }else
          {
             return false;
          }      
       }
    }
    
    public function user_by_id($id)
    {
       global $db;
       
       $result  =mysql_query("SELECT * FROM users WHERE id = '$id' LIMIT 1");
       $row     = mysql_fetch_array($result);
       
       return $row;
    }
    
    public function select_user($sql)
    {
       global $database;
       
       $result =mysql_query($sql);
       $object_array = array();       
       $row = mysql_fetch_array($result);

       return $row;  
    }
 }
 
  
 ?>