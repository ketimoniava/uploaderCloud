<?php
/**
 * მონაცემთა ბაზასთან სამუშაოდ, ზოგადი 
 * ფუნქციები შეგიძლია დაწერო აქ
 */
class DBHelper  {
	
    /**
     * მასივის ელემენტების ინდექსებს აერთებს მძიმით
     * 	$data = array(
     *	   name => 'test',
     *     age  => 24,
     *     key  => 'Val',
     * 	)
     * ამ მასივიდან ეს ფუნქცია დააბრუნებდა 'name,age,key'
     */
    public static function getInsertKeys(&$data) {
        return implode(',', array_keys($data));
    }

    /**
     * PDO Prepared (Insert) Query-სთვის იღებ იმდენ პარამეტრის (?) 
     * ჩამნაცვლებელს (Placeholder) რამდენი ელემენტიც არის $data მასივში
     *
     * ზედა მაგალითიდან დაგვიბრუნებდა '?,?,?'-ს
     */
    public static function getInsertParams(&$data) {
        $arr = array_fill(0, count($data), '?');
        return implode(',', $arr);
    }

    /**
     * აქაც მსგავსია ოღონდ განახლებისთვის, და თუ იყენებ 
     * სახელად პარამეტრებს (named-parameters) ანუ მასივის 
     * წევრების ინდექსები არის არაციფრული
     * მაშინ დააბრუნებდა 'name = :name, age = :age, key = :key'
     * name, age, key უნდა იყოს ბაზაში ველების სახელები რეალურად,
     * ანუ ეს ხდება როცა $named = true
     *
     * თუ $named = false მაში: 'name = ?, age = ?, key = ?'
     */
    public function getUpdateKeys(&$data,$named=false) {
        $tmp = array();
        foreach ($data as $k=>&$v) {
            if($named==false): 
                $tmp[] = "$k = ? ";
            else:
                $tmp[] = "$k = :$k";
            endif;
        }
        return implode(',', $tmp);
    }

}