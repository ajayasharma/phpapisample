<?php
// Core class which will handle your database request
class Database {
    private $dbHost;
    private $dbName;
    private $dbUsername;
    private $dbPassword;

    private $connectionString;

    public $dbConnection;
    public $statement;
    public $resultSet;
    

    public function __construct(){
        $this->dbHost = 'localhost';
        $this->dbName = 'test_mobileapi';
        $this->dbUsername = 'root';
        $this->dbPassword = 'mysql';

        $this->connectionString = "mysql:host=".$this->dbHost."; dbname=".$this->dbName;
        try{
            $this->connect();
        }catch(PDOException $ex){
            throw $ex;
        }
    }

    public function connect()
    {
        try
        {
            $this->dbConnection = new PDO($this->connectionString, $this->dbUsername, $this->dbPassword);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch( PDOException $ex)
        {
            throw $ex;
        }
    }

    public function disconnect()
    {
        unset($this->dbConnection);
    }

    public function query($queryString)
    {
        try
        {

            $this->statement = $this->dbConnection->prepare($queryString);
            $this->statement->execute();
        }
        catch( PDOException $ex)
        {
            throw $ex;
        }
    }

    public function loadObject() // Provides an stdClass object containing the first row only
    {
        try
        {
            if($this->statement->rowCount()){
                return $this->statement->fetchObject();
            }
            else
                return null;
        }
        catch(PDOException $ex)
        {
            throw $ex;
        }
    }

    public function loadObjectList() // Provides an array of objects containing all the rows
    {
        try
        {
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }
        catch(PDOException $ex)
        {
            throw $ex;
        }
    }

    public function loadResult() // Provides an stdClass object containing the first row only
    {
        try
        {
            if($this->statement->rowCount()){
                return $this->statement->fetchColumn();
            }
            else
                return null;
        }
        catch(PDOException $ex)
        {
            throw $ex;
        }
    }

    public function prepare($qry){
        $this->statement = $this->dbConnection->prepare($qry);
    }

    public function lastInsertId(){
        return $this->dbConnection->lastInsertId();
    }
}