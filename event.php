<?php
// This class will manage all the actions related to events
// Add event , Update event, delete event, list event, getEvent
class Event extends Module {
    public $eventId;
    public $eventName;
    public $eventLocation;

    public function __construct() {
        parent::__construct();
        $this->eventId = 0;
        $this->eventName = '';
        $this->eventLocation = '';
        $this->query = '';
        $this->moduleName = 'Event';
    }

    public function store(){
        $this->eventName = $_POST['eventName'];
        $this->eventLocation = $_POST['eventLocation'];
        $this->query = "INSERT INTO event(eventName, eventLocation) VALUE ('".$this->eventName."', '".$this->eventLocation."') ";
        $this->storeData();
    }

    public function update(){
        $this->eventId = $_POST['eventId'];
        $this->eventName = $_POST['eventName'];
        $this->eventLocation = $_POST['eventLocation'];
        $this->query = "UPDATE event SET eventName='".$this->eventName."', eventLocation='".$this->eventLocation."' WHERE eventId=".$this->eventId;
        $this->updateData();
    }

    public function delete(){
        $this->eventId = $_POST['eventId'];
        $this->query = "DELETE FROM event WHERE eventId=".$this->eventId;
        $this->deleteData();
    }

    public function list(){
        $this->query = "SELECT * FROM event";
        $this->listData();
    }

    public function load(){
        $this->eventId = $_REQUEST['eventId'];
        $this->query = "SELECT * FROM event WHERE eventId = ".$this->eventId;
        $this->loadData();
    }
}