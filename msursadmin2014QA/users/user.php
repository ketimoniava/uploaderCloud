 <?php  
 
 class user
 {
    public $id;
    public $first_name;
    public $last_name;
    
    public $work;
    public $city;
    public $address;
    public $phone;
    public $mobile;
    public $web;
    
    public $username;
    public $password          = 'password';
    public $per_password      = 'password';
    public $old_password      = 'password';
    public $per_old_password  = 'password';
    public $new_password      = 'password'; 
    public $type;
    public $yaer;
    public $month;
    public $day;
    public $gender;
    public $email;   
    public $old_email;
    public $security_code;
     
    
    public function registration($user)
    { 
       include 'languages/ge.php'; 
       global $db;
       $this->username         =  $user['username'];
       $this->first_name       =  $user['name'];
       $this->last_name        =  $user['surname'];
       
       
       $this->work             =  $user['work'];
       $this->city             =  $user['city'];
       $this->address          =  $user['address'];
       $this->phone            =  $user['phone'];
       $this->mobile           =  $user['mobile'];
       $this->web              =  $user['web'];
       
       
       $this->password         =  $user['password'];
       $this->per_password     =  $user['per_password']; 
       $this->email            =  $user['email']; 
       $this->type             =  $user['type'];       
       $this->security_code    =  $user['security_code'];
       
       if($this->check_errors())
       {  
          return $this->check_errors();
       }else 
       { 
          $allow_email  = isset($user['allow_email']) ? 1 : 0;
          $allow_phone  = isset($user['allow_phone']) ? 1 : 0;
          
          
          $time = time();
          $sql  = "INSERT INTO users";
          $sql .= "(username, email, password, name, surname, work, city, address, phone, mobile, web, type, date, code, ip, allow_email, allow_phone)VALUES";
          $sql .= "('".$this->username."', '".$this->email."', '".md5($this->password)."','".$this->first_name."', '".$this->last_name."', '".$this->work."', '".$this->city."','".$this->address."', '".$this->phone."', '".$this->mobile."','".$this->web."', '".$this->type."', '".date("d m Y")."', '".$time."', '".$_SERVER['REMOTE_ADDR']."', '".$allow_email."', '".$allow_phone."')";
          $db->query($sql);                      
          
          $to          = $this->email;
          $subject     = "kalmaxi.ge";
          $body        = "tqven daregistrirdit. registraciis gasaaqtiureblad gadadit am linkze"." "."http://".$_SERVER['SERVER_NAME']."?page=actuser&actuser=$time";
          $from        = "From: kalmaxi.ge";
          mail($to, $subject, $body, $from);
          
          //echo $this->first_name."<br />" . $this->last_name. "<br />". $this->username ."<br />" . $this->password. "<br />". $this->per_password ."<br />" .$this->email;      
       }
    }
    
    public function update($user)
    { 
       global $db;
       $this->id               =  $user['id'];
       $this->username         =  $user['username'];
       $this->old_username     =  $user['old_username'];
       
       
       $this->first_name       =  $user['name'];
       $this->last_name        =  $user['surname'];
       
       
       $this->work             =  $user['work'];
       $this->city             =  $user['city'];
       $this->address          =  $user['address'];
       $this->phone            =  $user['phone'];
       $this->mobile           =  $user['mobile'];
       $this->web              =  $user['web']; 
             
       
       $this->email            =  $user['email'];
       $this->old_email        =  $user['old_email'];
       
       $this->old_password     =  $user['old_password'];
       $this->per_old_password =  md5($user['re_old_password']);
       $this->password         =  $user['password'];
       $this->per_password     =  $user['per_password'];
            
       $this->security_code    =  $user['security_code']; 
       
       $this->type             =  $user['type'];       
       
       if($this->check_errors())
       {  
          return $this->check_errors();       
       }else  
       {
          $allow_email  = isset($user['allow_email']) ? 1 : 0;
          $allow_phone  = isset($user['allow_phone']) ? 1 : 0;        
        
        
          $sql  = "UPDATE users SET ";
          $sql .= "username = '".$this->username."', password = '".md5($this->password)."', email = '".$this->email."', name = '".$this->first_name."', surname = '".$this->last_name."', work = '".$this->work."', city = '".$this->city."', address = '".$this->address."', phone = '".$this->phone."', mobile = '".$this->mobile."', web = '".$this->web."', type = '".$this->type."', ip = '".$_SERVER['REMOTE_ADDR']."', allow_email = '".$allow_email."', allow_phone = '".$allow_phone."' ";
          $sql .= "WHERE id = '".$this->id."'"; 
          $db->query($sql); 
       }   
    } 
    
    public function check_errors()
    {
       include 'languages/ge.php';  
       global $db;
       $errors = array();        
       if(($this->old_username) != ($this->username))
       { 
       $select_username = "SELECT id FROM users WHERE username = '".$this->username."'"; 
       $select_username = $db->query($select_username);
       $check_username = $db->num_rows($select_username);
       if($check_username > 0 && $this->username != $this->old_username)
        $errors[] = $err[0];   
       }       
       
       if(($this->old_email) != ($this->email)) 
       { 
       $select_email = "SELECT id FROM users WHERE email = '".$this->email."'"; 
       $select_email = $db->query($select_email);
       $check_email = $db->num_rows($select_email);
       if($check_email > 0 && $this->email != $this->old_email)
        $errors[] = $err[1];   
       }        
        
       /*if((strlen($this->first_name) < 2) || (strlen($this->first_name) > 30))
        $errors[] = $err[9];
       else if(!preg_match("/^[A-Za-z][A-Za-z-]+$/" , $this->first_name)) 
        $errors[] = $err[10]; */             

       if((strlen($this->last_name) < 2) || (strlen($this->last_name) > 30))
        $errors[] = $err[11];
       else if(!preg_match("/[A-Za-z][A-Za-z-]+$/" , $this->last_name)) 
        $errors[] = $err[12];
        
       if(empty($this->work))
        $errors[] = $err[16]; 
        
       if(empty($this->city))
        $errors[] = $err[13];            
  
       if(empty($this->phone))
        $errors[] = $err[14];  

       if(empty($this->mobile))
        $errors[] = $err[15]; 
       
       if((strlen($this->username) < 4) || (strlen($this->username) > 25))
        $errors[] = $err[2];
       else if(!preg_match("/^[A-Za-z][\w+.-]+$/" , $this->username))
        $errors[] = $err[3];       
       
       if((strlen($this->password) < 4) || (strlen($this->password) > 25) || (strlen($this->new_password) < 4) || (strlen($this->new_password) > 30))
        $errors[] = $err[4];
       else if($this->password != $this->per_password)
        $errors[] = $err[5]; 
        
       if($this->old_password != $this->per_old_password)
        $errors[] = $err[8];       
        
       if(!preg_match("/^[A-Za-z][\w._-]+@\w[\w-.]+\.[a-zA-Z]{2,3}(\.[a-zA-Z]{2,3})?$/" , $this->email))  
        $errors[] = $err[6];
        
       if($this->security_code != $_SESSION['captcha'])
        $errors[] = $err[7]; 
       
       
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
       $image = 'avatars/'.$this->username.$this->image_extension;
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
    
    public function login($username, $password)
    {
       global $db;
       
       $password =md5($password);       
       $sql   = "SELECT id, username, password FROM users ";
       $sql  .= "WHERE username = '$username' AND password = '$password' AND blocked = '1'  LIMIT 1";
       $login = $db->query($sql);
       
       $login_result = array();
       
       if($db->num_rows($login) > 0)
       {
          $row = $db->fetch_array($login);
            
          $login_result[] = $row['id'];
          $login_result[] = $row['username'];
          $login_result[] = $row['password'];    
       }
       
       return $login_result;
    }
    
    public function check_cookie()
    {
       global $db;
        
       if((isset($_COOKIE['id'])) && (isset($_COOKIE['username'])) && (isset($_COOKIE['password'])))
       {
          $sql  = "SELECT id FROM users ";
          $sql .= "WHERE id = '$_COOKIE[id]' AND username = '$_COOKIE[username]' AND password = '$_COOKIE[password]'";
          $select = $db->query($sql);
          if($db->num_rows($select) > 0)
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
       
       $result  = $db->query("SELECT * FROM users WHERE id = '$id' LIMIT 1");
       $row     = $db->fetch_array($result);
       
       return $row;
    }
    
    public function select_user($sql)
    {
       global $database;
       
       $result = $database->query($sql);
       $object_array = array();       
       $row = $database->fetch_array($result);

       return $row;  
    }
 }
 
  
 ?>