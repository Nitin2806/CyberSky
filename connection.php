<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'cybersky';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User class
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($username,$password,$firstname,$lastname,$email,$phone)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(username, password, firstname, lastname, email, phone) VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $username,$password,$firstname,$lastname,$email,$phone);
        $stmt->execute();
        if ($stmt->affected_rows > 0) 
        {
            return 'success';
        }
    }

    public function checkUser($username,$password)
    {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) 
        {
            $res = $result->fetch_assoc();
            if (password_verify($password,  $res['password'])) 
            {
                return $res['user_id'];
            } 
            else 
            {
                return 0;
            }
        } 
        else 
        {   
            return 0;
        }
    }
   
}

// Cart class
class Cart {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        return $stmt->execute();
    }
    public function getAllProductsUsingID($productId) {
        $sql = "SELECT * FROM product WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
        $stmt->close();
        return $products;
    }
    public function getCart($userId)  {
        $sql = "SELECT * FROM cart  WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function updateCart($cartId,$quantity)  
    {
        $sql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $cartId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) 
        {
            return '<div class="alert">Cart Updated!</div>';
        }
    }
    public function removeCart($cartId) 
    {
        $sql = "DELETE FROM cart WHERE cart_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i",$cartId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) 
        {
            return '<div class="alert">Item Removed from Cart!</div>';
        }
    }

}

// Product class
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM product";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSearchProducts($search) {
        $search = '%'.$search.'%';
        $sql = "SELECT * FROM product WHERE product_name LIKE ? OR product_desc LIKE ? OR product_price LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $search,$search,$search);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

$userObj = new User($conn);
$cartObj = new Cart($conn);




?>