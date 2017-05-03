<?php
function resizeAndSave2($dirSmall, $dirMedium, $dirOriginal, $imgWidthSmall, $imgWidthMedium, $fileSubmited, $title, $fileExt){
		/*
			Image Resizer / Thumbnailer Script
			Daniel Neri
			Viper Creations
			www.vipercreations.com
		*/
		//make sure this directory is writable!
		//$imgFormIndex."<br />";
		$path_thumbs = $dirSmall;
		$path_medium = $dirMedium;
		$path_big = $dirOriginal;
		
		//the new width of the resized image, in pixels.
		$img_thumb_width = $imgWidthSmall; // 
		$img_medium_width = $imgWidthMedium; // 

		$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)
		//List of allowed extensions if extlimit = yes
		$limitedext = array(".gif",".jpg",".png",".jpeg");
		$file_tmp = ("uploads/".$fileSubmited);
		$file_name = $fileSubmited;
        $file_size = filesize("uploads/".$fileSubmited);
      

        //check if you have selected a file.
		if(!file_exists($file_tmp)){
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
	   $MediumWidth = $img_medium_width;
	   //////////////////////////
	   // CREATE THE THUMBNAIL //
	   //////////////////////////
	   
       //keep image type
       if($file_size){
		   if($fileExt=='jpeg' or $fileExt=='jpg' or  $fileExt=='JPG' )
		   {
			 $new_img = imagecreatefromjpeg($file_tmp);
		   }
		   	if($fileExt=='png' )
		   {
			 $new_img = imagecreatefrompng($file_tmp);
		   }
		   if($fileExt=='gif' )
		   {
			 $new_img = imagecreatefrompng($file_tmp);
		   }
           //list the width and height and keep the height ratio.
           list($width, $height) = getimagesize($file_tmp);
           //calculate the image ratio
           $imgratio=$width/$height;
           if($imgratio>1){
              $newwidth = $ThumbWidth; 
              $newheight = $ThumbWidth/$imgratio;
			  
			  $newwidthMedium = $MediumWidth; 
              $newheightMedium = $MediumWidth/$imgratio; 
          }else{
                 $newheight = $ThumbWidth;
                 $newwidth = $ThumbWidth*$imgratio;
				 
				 $newwidthMedium = $MediumWidth; 
              	 $newheightMedium = $MediumWidth/$imgratio; 
           }
		  /* echo $newwidthMedium;
		    echo "<br />\n";
			echo $newheightMedium;
		    echo "<br />\n";
	      echo $newratio1 = $newwidth/$newheight;
	  	  echo "<br />\n";
		  echo $newratio2 = $newwidthMedium/$newheightMedium;*/
           //function for resize image.
           if(@function_exists(imagecreatetruecolor)){
           $resized_img_small = imagecreatetruecolor($newwidth, $newheight);
		   $resized_img_medium = imagecreatetruecolor($newwidthMedium, $newheightMedium);
           }else{
                 die("Error: Please make sure you have GD library ver 2+");
           }
           //the resizing is going on here!
           imagecopyresized($resized_img_small, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
 		   imagecopyresized($resized_img_medium, $new_img, 0, 0, 0, 0, $newwidthMedium, $newheightMedium, $width, $height);
		  
		   imagecopyresampled($resized_img_small, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		   imagecopyresampled($resized_img_medium, $new_img, 0, 0, 0, 0, $newwidthMedium, $newheightMedium, $width, $height);
		   //finally, save the image
           ImageJpeg($resized_img_small, $path_thumbs."/".$title.".".$fileExt );
           ImageDestroy($resized_img_small);
		   
		   ImageJpeg($resized_img_medium, $path_medium."/".$title.".".$fileExt );
           ImageDestroy($resized_img_medium);
		   
		   ImageDestroy($new_img);
        }
        //ok copy the finished file to the thumbnail directory
		copy($file_tmp, $path_big."/".$title.".".$fileExt);
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$extension = end(explode(".", $file_name));
}
?>