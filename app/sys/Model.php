<?php

class Model {
   
    /**
     * PDO Object
     * @var type 
     */
    protected static $_db;
    
    /**
     * Table name
     * @var type 
     */
    protected $table;

    /**
     *All mysql fields
     * @var array
     */
    protected $fields;
    
    /**
     *THis is very beta version need 
     * recoding for later versions.
     * Adds part after
     * @var type 
     */
    protected $joinParts;
    /**
     * Key field for table
     * @var type 
     */
    protected $key = 'id';

    protected function db() {
        return self::$_db;
    }

    /**
     * Get mysql error
     * @return 
     */
    public function getError() {
        return $this->db()->errorInfo();
    }
    
    /**
     * Get mysql error code
     * @return 
     */
    public function getErrorCode() {
        return $this->db()->errorCode();
    }

    /**
     * Create PDO object,connect to database
     */
    public function __construct() {
    	if(self::$_db==null) :
            self::$_db = DB::getInstance();
        endif;
    }
    
    /**
     * Get all fields with filter info
     * @return array
     */
    public function getFields() {
        return $this->fields;
    }
    
    /**
     * Get table name
     * @return string
     */
    public function getTableName() {
        return $this->table;
    }
   
   /**
     * Get entry with id
     * @param type $key
     * @return type
     */
    public function getEntry($key) {
        $statement = $this->db->prepare("
            SELECT * FROM {$this->table} WHERE {$this->key} = :key
        ");
        
        $statement->bindParam(':key', $key);
        $statement->execute();        
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get entries with one lang version
     * @return type
     */
    public function getEntries() {
        $statement = $this->db()->prepare("
            SELECT 
                 a.*
            FROM {$this->table} a
            ORDER BY a.{$this->key}
        ");
        
        $statement->bindParam(':lang', $lang);
        $statement->execute();        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Create entry
     * @param type $data
     * @return int
     */
    public function createEntry(&$data) {
        $statement = DB::getInstance()->prepare("
            INSERT INTO {$this->table} (". DBHelper::getInsertKeys($data).")
                VALUES (".DBHelper::getInsertParams($data).")
            ");
            
        $res = $statement->execute(array_values($data));
        if ($res) {
            $id = $this->db()->lastInsertId();
        } else {
            $id = 0;
        }
        
        if(PageFunctions::isDebug()) {
            PageFunctions::debug('CreateEntry..');
            PageFunctions::debug('QUERY: '.$statement->queryString);
            PageFunctions::debug('DATA: ');
            PageFunctions::debug($data);
            PageFunctions::debug('ERROR: '.$this->getErrorCode());
            PageFunctions::debug($this->getError());
            PageFunctions::debug('AFFECTED: '.$statement->rowCount());
            PageFunctions::debug('ID: '.$id);
        }        
        return $id;
    }
    
    /**
     * Update entry 
     * @param primary key $key
     * @param array $data
     * @return int
    */
    public function updateEntry($key, &$data) {
        if(empty($data)){
            return -1;
        }
        
        $statement = $this->db()->prepare("
                UPDATE {$this->table} SET ". DBHelper::getUpdateKeys($data)."
                WHERE {$this->key} = ?
            ");
           
        $data[$this->key] = $key;        
        $res = $statement->execute(array_values($data));
		//var_export($statement->errorInfo());
        if($res){
            return $statement->rowCount();
        }
        return 0;
    }
    
     /**
     * Delete Entry from database
     * @param int $key
     * @return int
    */
    public function deleteEntry($key) {
        $statement = $this->db()->prepare("
            DELETE FROM {$this->table}
            WHERE {$this->key} = :key
        ");
        
        $statement->bindParam(':key' , $key, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount();
    }
    
}