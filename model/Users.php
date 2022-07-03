<?php

class Users
{
    // DB stuff

    private $conn;
    private $table = 'tUser';

    // default var
    private $errors;

    // users properties

    public $userId;
    public $username;
    public $email;
    public $password;
    public $userTypeId;
    public $createdDate;
    public $isActive;
    public $role;

    // constructor with DB

    public function __construct($db)
    {
        $this->conn = $db;
        $this->errors = array();
    }

    // Get Users
    public function getAll()
    {
        // create query

        $query = 'SELECT 
                            
                            u.userId,
                            u.username,
                            u.email,
                            u.password,
                            ut.userTypeId,
                            ut.role AS user_role,     
                            u.createdDate,
                            u.isActive
                       FROM
                            ' . $this->table . ' u
                       INNER JOIN
                           tUserType ut ON ut.userTypeId = u.userTypeId
                       ORDER BY u.createdDate DESC
                            
                      ';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // exec query

        $stmt->execute();

        return $stmt;
    }

    // Get Specific user
    public function getUserById()
    {
        // create query

        $query = 'SELECT 
                            
                            u.userId,
                            u.username,
                            u.email,
                            ut.userTypeId,
                            ut.role,     
                            u.createdDate,
                            u.isActive
                       FROM
                            ' . $this->table . ' u
                       INNER JOIN
                           tUserType ut ON ut.userTypeId = u.userTypeId
                       WHERE
                            u.userId = ?
                            LIMIT 0,1
                            
                      ';

        // prepare statement

        $stmt = $this->conn->prepare($query);

        // Bind Id

        $stmt->bindParam(1, $this->userId);

        // exec query

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->username = $row['username'];
        $this->email = $row['email'];
        $this->role = $row['role'];
        $this->createdDate = $row['createdDate'];
        $this->isActive = $row['isActive'];

    }

    // Create User
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
                        SET 
                            username = :username, 
                            email = :email, 
                            password = :password, 
                            userTypeId = :userTypeId,
                            createdDate = :createdDate
                      ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->userTypeId = htmlspecialchars(strip_tags($this->userTypeId));
        $this->createdDate = htmlspecialchars(strip_tags($this->createdDate));

        // Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':userTypeId', $this->userTypeId);
        $stmt->bindParam(':createdDate', $this->createdDate);

        // validating form
        if (empty($username)) { array_push($this->errors, "Full name is required"); }
        if (empty($email)) { array_push($this->errors, "Email is required"); }
        if (empty($password)) { array_push($this->errors, "Password is required"); }

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

    // Update User
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                      SET 
                        username = :username, 
                        password = :password, 
                        email = :email, 
                        createdDate = :createdDate,
                      WHERE userId = :userId
                      ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->createdDate = htmlspecialchars(strip_tags($this->createdDate));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':createdDate', $this->createdDate);
        $stmt->bindParam(':userId', $this->userId);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

}

