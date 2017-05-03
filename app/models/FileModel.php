<?php

class FileModel extends Model {
    
    protected $table = "file";

    protected $fields = array(
        'id'        => 'int:10',
        'name'      => 'varchar:50',
        'orig_name' => 'varchar:100',
        'extension' => 'varchar:5',
        'user_id'   => 'int:5',
        'added'     => 'timestamp',
        'folder'    => 'varchar:100',
        'size'      => 'varchar:20', //DEFAULT NULL COMMENT 'Ex: 20kb. 1.2mb. 10 bytes',
        'OK'        => 'binary:3', //Optional KEY 
        'comment'   => 'varchar:255' //Optional KEY 
    );
    
    
    public static function getFile($id) {
        $statement = DB::getInstance()->prepare("
           SELECT * FROM file WHERE id = :id
        ");        
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();        
        return $statement->fetch(PDO::FETCH_ASSOC);      
    }

}