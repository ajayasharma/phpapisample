<?php
// This class will manage all the actions related to products
// Add product , Update product, delete product, list product, getproduct
class Product {
    public $productId;
    public $productName;
    public $productLocation;
    public $dbConnection;

    public function __construct() {
        $this->productId = 0;
        $this->productName = '';
        $this->productLocation = '';
        $this->dbConnection = new Database();

    }

    public function store(){
        $this->productName = $_POST['productName'];
        $this->productLocation = $_POST['productLocation'];
        $query = "INSERT INTO product(productName, productLocation) VALUE ('".$this->productName."', '".$this->productLocation."') ";
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'product Successfully Stored';
            $response['data']['productId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error storing product :'. $ex->getMessage() ;
            echo json_encode($response);
            throw $ex;
        }
    }

    public function update(){
        $this->productId = $_POST['productId'];
        $this->productName = $_POST['productName'];
        $this->productLocation = $_POST['productLocation'];
        $query = "UPDATE product SET productName='".$this->productName."', productLocation='".$this->productLocation."' WHERE productId=".$this->productId;
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'product Successfully Stored';
            $response['data']['productId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error updating product :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function delete(){
        $query = "DELETE FROM product WHERE productId=".$this->productId;
        try{
            $this->dbConnection->query($query);
            $response['status'] = 200;
            $response['message'] = 'product Successfully Deleted';
            $response['data']['productId'] = $this->dbConnection->lastInsertedId();
            echo json_encode($response);
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error deleting product :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function list(){
        $query = "SELECT * FROM product";
        try{
            $this->dbConnection->prepare($query);
            $productList = $this->dbConnection->loadObjectList();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $productList;
            echo json_encode($response);

        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving product list :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }

    public function getproduct(){
        $this->productId = $_REQUEST['productId'];
        $query = "SELECT * FROM product WHERE productId = ".$this->productId;
        try{
            $this->dbConnection->prepare($query);
            $product = $this->dbConnection->loadObject();
            $response['status'] = 200;
            $response['message'] = '';
            $response['data'] = $product;
            echo json_encode($response);
            
        }catch( PDOException $ex ) {
            $response['status'] = 403;
            $response['error'] = 'Error retrieving product :'. $ex->getMessage() ;
            echo json_encode($response);
        }
    }



}