<?php

/**
 * ტესტირებისთვის შეგიძლია დაამატო ფუნქციები
 */
class Debug {
    
    /**
     * ბაიტები გადაყავს შესაბამის ხარისხებში
     * 
     * @staticvar array $unit
     * @param int $size
     * @return string
     */
    public static function convertBytes($size)
    {
        static $unit=array('b','kb','mb','gb','tb','pb');
        return round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

}