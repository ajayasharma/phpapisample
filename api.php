<?php

// All your request will come to this file
// This file will tranfer the request to relevent filesize
// http://localhost/mobileappapi/api.php?module=event&task=list

// http://localhost/mobileappapi/api.php?module=event&task=store  and all the data is in POST
include('database.php');
include('module.php');
$moduleName = $_REQUEST['module'];   // $objectName = "event"
$task = $_REQUEST['task'];

if(!file_exists($moduleName.'.php')){ // file_exists('event.php')
    // return error
}

include($moduleName.'.php'); // include('event.php')

$className = ucfirst($moduleName);

$object = new $className(); // $object = new Event(); 

$object->$task(); // $object->list();
