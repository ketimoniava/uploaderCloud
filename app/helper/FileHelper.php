<?php
/**
 * დაილებთან სამუშაო დამხმარე კლასი
 */
class FileHelper extends Helper {
    /**
     * სიმბოლოები რისგანაც დაგენერირდება ფაილის სახელი ვთქვათ
     * @var string
     */
    private static $codes = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ";

    /**
     * ფაილის სახელის გენერირება
     * @param string $pre წინ დაურთოს რამე მაგ: 'PHT'
     * @param int $ln რამდენი სიმბოლო დააგენერიროს, $pre-ს გარდა
     * @return string
     */
    public static function generateRandomName($pre='',$ln=10){
        if ($pre) {
            $pre .= "-";
        }
        return $pre.substr(str_shuffle(self::$codes),0,$ln);
    }

    /**
     * ფაილის წაშლა
     * @param string $file ფაილის სრული მისამართი
     * @return boolean
     */
    public static function deleteFile($file) {
        if(is_file($file)){
            return @unlink($file);
        }
        return -1;
    }


}