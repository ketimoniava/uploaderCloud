<?php
/**
 * ავტომატურად კლასების შემოტანა
 * იმისათვის რომ კლასმა სწორად იმუშაოს,
 * შესაბამის საქაღალდეებში კლასის სახელი და 
 * ფაილის სახელი უნდა ემთხვეოდეს ერთმანეთს
 */
class AutoLoader {
	  protected static $paths = array(
    );    
	/**
	* საქაღალდის დამატება, სადაც შემდეგ მოიძებნება ფაილი
	*/
    public static function addPath($path) {
       $path = realpath($path);
		//echo "<br />";
        if($path) {
            self::$paths[] = $path.DIRECTORY_SEPARATOR;
        }
    }
    
	/**
	 * ეს უშუალოდ ფუნქცია კლასის ძიებისთვის
	*/
    public static function load($class) {
       $classPath = $class.'.php'; // Do whatever logic here
        foreach (self::$paths as $path) {
            if(is_file($path . $classPath)) {
				$path.$classPath;
				//echo "<br />";
                require_once $path.$classPath;
                return;
            }
        }
    }
}

/*
 * კლასის რეგისტრაცია ავტო-შემომტანად
 * AutoLoader კლასი, load მეთოდი
*/
spl_autoload_register(array('AutoLoader', 'load'));