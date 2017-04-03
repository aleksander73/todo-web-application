<?php

class DB_Manager {
    
    private static $instance = null;
    
    private $pdo = null;

    // ------------------------------------------------------------------------------
    
    private function __construct() {}
    
    public static function getInstance() {
        if(DB_Manager::$instance == null) {
            DB_Manager::$instance = new DB_Manager();
        }
        
        return DB_Manager::$instance;
    }
    
    // ------------------------------------------------------------------------------
    
    public function openConnection() {
        // If connection already exists
        if($this->pdo != null) {
            return $this->pdo;
        }
        
        // Load the config.ini file
        $config = parse_ini_file('config.ini');
        
        // Read the config.ini file
        $server = $config['server'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['dbname'];
        
        try {
            $this->pdo = new PDO("mysql:host = $server; dbname = $database;", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection failed!';
        }

        return $this->pdo;
    }
    
    public function closeConnection() {
        $this->pdo = null;
    }
}

?>