<?php
  /*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
  class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $port= DB_PORT;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
      try {
        $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;";
        // make a database connection
        $this->dbh = new PDO($dsn, $this->user, $this->pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
        // if ($dsn) {
        //   echo "Connected to the $this->dbname database successfully!";
        // }
      } catch (PDOException $e) {
        die($e->getMessage());
      }
    }

    // Prepare statement with query
    public function query($sql){
      $this->stmt = $this->dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null){
      if(is_null($type)){
        switch(true){
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
        }
      }
      
      $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(){
      return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount(){
      return $this->stmt->rowCount();
    }

    public function resultSet1(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchColumnValue(){
      $result = $this->execute();
      $number_of_rows = $this->stmt->fetchColumn();
      return  $number_of_rows;
    }
  


  }