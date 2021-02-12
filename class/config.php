<?php
class Config {
    public $appName = 'todolist';
    protected $appVersion = 'v1.0';


    public function setConf(){

    }

    public function getConf(){

    }
}

class DbConfig extends Config {

    private $dbPath = 'data'.DIRECTORY_SEPARATOR;
    private $dbFile;
    private $operation;

    public function __construct(string $dbFile,string $operation)
    {
        $this->dbFile = $dbFile;
        $this->operation = $operation;
        $dirCheck = is_dir($this->dbPath);
        $fileCheck = file_exists($this->dbPath . $this->dbFile . $this->operation . '.json');
        if (!$dirCheck){
            $this->dirCreate();
        }
        if (!$fileCheck){
            $this->dbCreate($dbFile);
        }
    }

    private function dirCreate() : bool {
        return mkdir($this->dbPath);
    }

    private function dbCreate(string $dbName): bool {
       return file_put_contents($this->dbPath . $dbName . $this->operation . '.json', json_encode([]));
    }

    public function getDbFile() : string {
        return $this->dbPath . $this->dbFile . $this->operation . '.json';
    }


}