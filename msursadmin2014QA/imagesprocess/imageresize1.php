<?php

function resizeAndSave1($dirSmall, $dirOriginal, $imgWidth, $fileSubmited, $imgFormIndex, $title, $fileExt){

		/*
			Image Resizer / Thumbnailer Script
			Daniel Neri
			Viper Creations
			www.vipercreations.com
		*/
		//make sure this directory is writable!
		$path_thumbs = $dirSmall;
		$path_big = $dirOriginal;
		
		//the new width of the resized image, in pixels.
		$img_thumb_width = $imgWidth; // 

		$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)
		//List of allowed extensions if extlimit = yes
		$limitedext = array(".gif",".jpg",".png",".jpeg");
		//echo $fileSubmited[0];
		//the image -> variables
		$file_type = $fileSubmited["type"][$imgFormIndex];
		$file_name = $fileSubmited["name"][$imgFormIndex];
        $file_size = $fileSubmited["size"][$imgFormIndex];
        $file_tmp = $fileSubmited["tmp_name"][$imgFormIndex];

        //check if you have selected a file.
		if(!is_uploaded_file($file_tmp)){
           echo "Error: Please select a file to upload!. <br /><p class='back' ><a href='javascript:history.back(1);'>უკან დაბრუნება</a></p>";
           exit(); //exit the script and don't process the rest of it!
        }
       //check the file's extension
       $ext = strrchr($file_name,'.');
       $ext = strtolower($ext);
       //uh-oh! the file extension is not allowed!
       if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
          echo "<p class='back' >Wrong file extension.  <br /><a href='javascript:history.back(1);'>უკან დაბრუნება</a></p>";
          exit();
       }
       //so, whats the file's extension?

       //create a random file name
      $rand_name=$title;
      // $rand_name= rand(0,999999999);
       //the new width variable
       $ThumbWidth = $img_thumb_width;

	   //////////////////////////
	   // CREATE THE THUMBNAIL //
	   //////////////////////////
	   
       //keep image type
       if($file_size){
          if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){
               $new_img = imagecreatefromjpeg($file_tmp);
           }elseif($file_type == "image/x-png" || $file_type == "image/png"){
               $new_img = imagecreatefrompng($file_tmp);
           }elseif($file_type == "image/gif"){
               $new_img = imagecreatefromgif($file_tmp);
           }
           //list the width and height and keep the height ratio.
           list($width, $height) = getimagesize($file_tmp);
           //calculate the image ratio
           $imgratio=$width/$height;
           if ($imgratio>1){
              $newwidth = $ThumbWidth; 
              $newheight = $ThumbWidth/$imgratio; 
           }else{
                 $newheight = $ThumbWidth;
                 $newwidth = $ThumbWidth*$imgratio;
           }
           //function for resize image.
           if (@function_exists(imagecreatetruecolor)){
           $resized_img = imagecreatetruecolor($newwidth,$newheight);
           }else{
                 die("Error: Please make sure you have GD library ver 2+");
           }
           //the resizing is going on here!
           imagecopyresized($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		   //finally, save the image
           ImageJpeg ($resized_img,$path_thumbs."/".$title.".".$fileExt );
           ImageDestroy ($resized_img);
           ImageDestroy ($new_img);
        }

        //ok copy the finished file to the thumbnail directory
		move_uploaded_file ($file_tmp, $path_big."/".$title.".".$fileExt );

}

?>