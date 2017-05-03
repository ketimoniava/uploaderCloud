<?php
function saveVideo($dirOriginal, $fileSubmited,  $videoIndex, $videoName,  $videoExtend)
{
	$path = $dirOriginal;
	//$limitedext = array(".gif",".jpg",".png",".jpeg");
	$limitedext = array(".swf",".mp4");
	$extlimit = "yes";
	$file_type = $fileSubmited["type"][$videoIndex];
     $file_name = $fileSubmited["name"][$videoIndex];
	$file_size = $fileSubmited["size"][$videoIndex];
    $file_tmp = $fileSubmited["tmp_name"][$videoIndex];

		 if(!is_uploaded_file($file_tmp)){
           echo "Error: Please select a file to upload!. <br>--<a href=\"$_SERVER[PHP_SELF]\">back</a>";
           exit(); //exit the script and don't process the rest of it!
        }

		$ext = strrchr($file_name,'.');
       $ext = strtolower($ext);
       //uh-oh! the file extension is not allowed!
      
	if($file_type =="application/x-shockwave-flash")
	{
	move_uploaded_file($file_tmp, $path."/".$videoName.".".$videoExtend);
	}
	else
	{
		echo "<p>თქვენი ვიდეო სამწუხაროდ არ აიტვირთა</p>";
		echo "<p>ატვირთეთ მხოლოდ SWF გაფართოების მქონე ვიდეო ფაილი</p>";
		exit();
	}
	
}
?>