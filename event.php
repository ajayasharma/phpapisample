<?php
// This class will manage all the actions related to events
// Add event , Update event, delete event, list event, getEvent
class Event {
    public $eventId;
    public $eventName;
    public $eventLocation;
    public $dbConnection;

    public function __construct() {
        $this->eventId = 0;
        $this->eventName = '';
        $this->eventLocation = '';
        $this->dbConnection = new Database();

    }

    public function store(){
        $this->eventName = $_POST['eventName'];
        $this->eventLocation = $_POST['eventLocation'];
        $query = "INSERT INTO event(eventName, eventLocation) VALUE ('".$this->eventName."', '".$this->eventLocation."') ";
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'Event Successfully Stored';
            $response['data']['eventId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error storing event :'. $ex->getMessage() ;
            echo json_encode($response);
            throw $ex;
        }
    }

    public function update(){
        $this->eventId = $_POST['eventId'];
        $this->eventName = $_POST['eventName'];
        $this->eventLocation = $_POST['eventLocation'];
        $query = "UPDATE event SET eventName='".$this->eventName."', eventLocation='".$this->eventLocation."' WHERE eventId=".$this->eventId;
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'Event Successfully Stored';
            $response['data']['eventId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error updating event :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function delete(){
        $query = "DELETE FROM event WHERE eventId=".$this->eventId;
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'Event Successfully Deleted';
            $response['data']['eventId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error deleting event :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function list(){
        $query = "SELECT * FROM event";
        try{
            $this->dbConnection->prepare($query);
            $eventList = $this->dbConnection->loadObjectList();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $eventList;
            echo json_encode($response);

        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving event list :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function getEvent(){
        $this->eventId = $_REQUEST['eventId'];
        $query = "SELECT * FROM event WHERE eventId = ".$this->eventId;
        try{
            $this->dbConnection->prepare($query);
            $event = $this->dbConnection->loadObject();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $event;
            echo json_encode($response);
            
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving event :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }



}