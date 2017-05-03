<?php
/**
 * ბაზასთან კავშირის მონაცემები
 * 
 * ჩვენ ვიყენებთ PDO - PHP Data Object კლასს ბაზასთან სამუშაოდ
 * უფრო მეტი უსაფრთხოებისთვის და მოქნილობისთვის
 */
define('MAIN_DB_DSN', 'mysql:dbname=msurs;host=localhost;charset=utf8');
define('MAIN_DB_USER', 'George');
define('MAIN_DB_PASS', 'garcha');


/**
 * ყველასათვის წვდომადი საქაღალდე, სადაც განთავსდება ფაილები
 */
 // ეს არის ბმულისთვის გამოსაყენებლად, მაგ: სურათის მისამართი
define('PATH_TO_PUBLIC', rtrim(BASE_NAME,'/')."/public");
 // ეს კიდევ ატვირთვის დროს გამოსაყენებლად, სრული მისამართი
define('UPLOAD_PUBLIC_PATH', WEB_ROOT.DS."public");

/**
 * აქაც იგივე ოღონდ ეს პრივატული სადაც შეინახება მომხმარებლის ფაილები
 * ამას დამატებით დაცვა დაჭირდება შენი მხრიდან, 
 * ანუ კი არის პრივატული მარა როცა მომხმარებელი არის ავტორიზებული 
 * მაშინ უნდა ქონდეს წვდომა, ანუ ყველასთვის ხელმისაწვდომი არ იყოს
 * ისევე როგორც public/ საქაღალდე
 */
define('PATH_TO_PRIVATE', rtrim(BASE_NAME,'/')."/prv");
define('UPLOAD_PRIVATE_PATH', WEB_ROOT.DS."prv");

/**
 * ესენი ასე დატოვე
 */
$defaultPage = 'home';
$defaultAction = 'index';
