<?php
$host = "localhost";
$username = "root";
$password = "";

try {
  $connect = new PDO("mysql:host=$host", $username, $password);
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $db = "CREATE DATABASE IF NOT EXISTS cybersky;

    USE cybersky;";

  $connect->exec($db);

  $table1 = "CREATE TABLE `address` (
    `address_id` int(11) NOT NULL,
    `line1` varchar(100) NOT NULL,
    `line2` varchar(100) DEFAULT NULL,
    `city` varchar(100) NOT NULL,
    `province` varchar(100) NOT NULL,
    `postal_code` varchar(10) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    
    
  ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);
      
    
  ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;";


  $connect->exec($table1);

  $connect->exec($db);

  $table2 = "  CREATE TABLE `cart` (
    `cart_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `quantity` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    
    

  ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);
      
    

  ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;";


  $connect->exec($table2);

  $connect->exec($db);

  $table3 = "CREATE TABLE `product` (
    `product_id` int(11) NOT NULL,
    `product_name` varchar(100) NOT NULL,
    `product_desc` text NOT NULL,
    `product_price` float NOT NULL,
    `product_image` varchar(100) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    
    
  ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);
      
    
  ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
  
  
  INSERT INTO `product` (`product_id`, `product_name`, `product_desc`, `product_price`, `product_image`) VALUES
(1, 'Samsung Guru', 'Samsung', 50, 'guru.jpg'),
(2, 'Apple iPhone 6', 'iPhone ', 90, 'iphone6.jpg'),
(3, 'Motorola Edge 30', 'Motorola', 300, 'edge30.jpg'),
(4, 'iPhone 10', 'iPhone', 190, 'iphone10.jpg'),
(5, 'iPhone 11', 'iPhone', 1333, 'iphone11.jpg'),
(6, 'Samsung Galaxy S25', 'Samsung', 2000, 'samsungs25.jpg'),
(7, 'Samsung M33', 'Samsung', 900, 'samsungm33.jpg');
  
  ";


  $connect->exec($table3);

  $connect->exec($db);

  $table4 = "CREATE TABLE `user` (
    `user_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(100) NOT NULL,
    `firstname` varchar(100) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `address_id` int(11) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
    
  ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);
      
  ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;";


  $connect->exec($table4);

  header("Location: index.php");
  exit();
} catch (PDOException $error) {
  echo $error->getMessage();
}

$connect = null;
