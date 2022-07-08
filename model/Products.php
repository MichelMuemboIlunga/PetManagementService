<?php

class Products
{
    // DB stuff

    private $conn;
    private $table = 'tProduct';

    // default var
    private $errors;

    // users properties

    public $productId;
    public $productName;
    public $productImage;
    public $productDescription;
    public $productPrice;
    public $productCode;
    public $productQuantity;
    public $createdDate;

       // constructor with DB

    public function __construct($db)
    {
        $this->conn = $db;
        $this->errors = array();
    }

    // Get Products
    public function getAll()
    {
        // create query

        $query = 'SELECT 
                            
                            P.productId,
                            P.productName,
                            P.productImage,
                            P.productDescription ,
                            P.productPrice,
                            P.productCode,
                            P.productQuantity,
                            P.createdDate
                            
                       FROM
                            ' . $this->table . ' P

                       ORDER BY P.createdDate DESC
                            
                      ';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // exec query

        $stmt->execute();

        return $stmt;
    }

    // Get Specific Products
    public function getProductById()
    {
        // create query

        $query = 'SELECT

                            P.productId,
                            P.productName,
                            P.productImage,
                            P.productDescription ,
                            P.productPrice,
                            P.productCode,
                            P.productQuantity,
                            P.createdDate
                       FROM
                            ' . $this->table . ' P

                       WHERE
                            P.productId = ?
                            LIMIT 0,1

                      ';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // Bind Id

        $stmt->bindParam(1, $this->productId);

        // exec query

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->productId = $row['productId'];
        $this->productName = $row['productName'];
        $this->productImage = $row['ProductImage'];
        $this->productDescription = $row['productDescription'];
        $this->productPrice = $row['productPrice'];
        $this->productCode = $row['productCode'];
        $this->productQuantity = $row['productQuantity'];
        $this->createdDate = $row['createdDate'];

    }

    // Create Products
   public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
                        SET 
                            productName = :productName, 
                            productImage = :productImage, 
                            productDescription = :productDescription, 
                            productPrice  = :productPrice,
                            productCode = :productCode,
                            productQuantity = :productQuantity,   
                            createdDate = :createdDate
                      ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->productName = htmlspecialchars(strip_tags($this->productName));
        $this->productImage = htmlspecialchars(strip_tags($this->productImage));
        $this->productDescription = htmlspecialchars(strip_tags($this->productDescription));
        $this->productPrice = htmlspecialchars(strip_tags($this->productPrice));
        $this->productCode = htmlspecialchars(strip_tags($this->productCode));
        $this->productQuantity = htmlspecialchars(strip_tags($this->productQuantity));

        // Bind data
        $stmt->bindParam(':productName', $this->productName);
        $stmt->bindParam(':productImage', $this->productImage);
        $stmt->bindParam(':productDescription', $this->productDescription);
        $stmt->bindParam(':productPrice', $this->productPrice);
        $stmt->bindParam(':productCode', $this->productCode);
        $stmt->bindParam(':productQuantity', $this->productQuantity);
        $stmt->bindParam(':createdDate', $this->createdDate);

        // validating form
//        if (empty($username)) { array_push($this->errors, "Full name is required"); }
//        if (empty($email)) { array_push($this->errors, "Email is required"); }
//        if (empty($password)) { array_push($this->errors, "Password is required"); }

        $currentDateTime = date('Y-m-d H:i:s'); // init current time

        if (empty($createdDate)){
            $stmt->bindParam(':createdDate', $currentDateTime);
        }

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

   // Update products
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                      SET
                        productName = :productName,
                        productImage = :productImage,
                        productDescription = :productDescription,
                        productPrice = :productPrice,
                        productCode = :productCode,
                        productQuantity = :productQuantity,
                        createdDate = :createdDate
                        WHERE productId = :productId
                      ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->productName = htmlspecialchars(strip_tags($this->productName));
        $this->productImage = htmlspecialchars(strip_tags($this->productImage));
        $this->productDescription = htmlspecialchars(strip_tags($this->productDescription));
        $this->productPrice = htmlspecialchars(strip_tags($this->productPrice));
        $this->productCode  = htmlspecialchars(strip_tags($this->productCode ));
        $this->productQuantity = htmlspecialchars(strip_tags($this->productQuantity));
        $this->createdDate = htmlspecialchars(strip_tags($this->createdDate));
        $this->productId = htmlspecialchars(strip_tags($this->productId));

        // Bind data
        $stmt->bindParam(':productName', $this->productName);
        $stmt->bindParam(':productImage', $this->productImage);
        $stmt->bindParam(':productDescription', $this->productDescription);
        $stmt->bindParam(':productPrice', $this->productPrice);
        $stmt->bindParam(':productCode', $this->productCode);
        $stmt->bindParam(':productQuantity', $this->productQuantity);
        $stmt->bindParam(':createdDate', $this->createdDate);
        $stmt->bindParam(':productId', $this->productId);

        $currentDateTime = date('Y-m-d H:i:s'); // init current time

        if (empty($createdDate)){
            $stmt->bindParam(':createdDate', $currentDateTime);
        }

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Product
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE productId = :productId';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->productId = htmlspecialchars(strip_tags($this->productId));

        // Bind data
        $stmt->bindParam(':productId', $this->productId);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}