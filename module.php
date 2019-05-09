<?php
class Module {
    public $dbConnection;
    public $message;
    public $data;
    public $query;
    public $moduleName;

    public function __construct() {
        $this->dbConnection = new Database();
        $this->message = '';
        $this->data = array();
    }

    private function sendJSONResponse(){
        $response['status'] = 200;
        $response['message'] = $this->message;
        $response['data'] = $this->data;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function sendJSONErrorReponse(){
        $response['status'] = 403;
        $response['error'] = $this->message ;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function storeData(){
        try{
            $this->dbConnection->query($this->query);
            $this->message = $this->moduleName.' Successfully Stored';
            $this->data = array();
            $this->data['id'] = $this->dbConnection->lastInsertId();
            $this->sendJSONResponse();
            
        }catch( PDOException $ex ) {
            $this->message = 'Error storing '.$this->moduleName.' :'. $ex->getMessage();
            $this->sendJSONErrorReponse();
        }
    }
    // This needs to be updated belwo this line.
    public function updateData(){
        try{
            $this->dbConnection->query($this->query);
            $this->message = $this->moduleName.' Successfully Updated';
            $this->data = array();
            $this->data['id'] = $this->dbConnection->lastInsertId();
            $this->sendJSONResponse();
            
        }catch( PDOException $ex ) {
            $this->message = 'Error storing '.$this->moduleName.' :'. $ex->getMessage();
            $this->sendJSONErrorReponse();
        }
    }

    public function deleteData(){
        try{
            $this->dbConnection->query($this->query);
            $this->message = $this->moduleName.' Successfully Deleted';
            $this->data = array();
            $this->sendJSONResponse();
            
        }catch( PDOException $ex ) {
            $this->message = 'Error storing '.$this->moduleName.' :'. $ex->getMessage();
            $this->sendJSONErrorReponse();
        }
    }

    public function listData(){
        try{
            $this->dbConnection->prepare($this->query);
            $dataList = $this->dbConnection->loadObjectList();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $dataList;
            echo json_encode($response);

        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving '.$this->moduleName.'list :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function loadData(){
        try{
            $this->dbConnection->prepare($query);
            $data = $this->dbConnection->loadObject();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $data;
            echo json_encode($response);
            
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving '.$this->moduleName.' :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }



}