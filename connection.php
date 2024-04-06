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

   
}

// Cart class
class Cart {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        echo $userId, $productId,$quantity;
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
}

$userObj = new User($conn);
$cartObj = new Cart($conn);

?>