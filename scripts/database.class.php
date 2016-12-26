<?php
class Database {
    private static $instance = null;
    private static $config = null;
    private static $connection = null;

    private function __construct() {
        self::db_connect();
    }

    private function __clone() {}

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Database;
        }

        return self::$instance;
    }
    
    private function db_connect() {
        if(!isset(self::$connection)) {
            self::$config = parse_ini_file('config.ini'); 
            self::$connection = new mysqli('127.0.0.1',self::$config['username'],self::$config['password'],self::$config['dbname']);
        }

        if(self::$connection->connect_errno) {
            echo 'cannot connect to database';
        }
    }

    public function query($query) {
      $stmt = self::$connection->query($query);
    
      return $stmt;
    }
}
?> 