<?php
   include_once('fpdf/fpdf.php');
   
   $db_host = 'localhost';
   $db_user = 'root';
   $db_pass = '';
   $db_name = 'cybersky';
   
   $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
   
   
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   
   class PDF extends FPDF
   {
       function Header()
       {
           $this->Image('images/logo2.png',60,10,100);
           $this->Ln(20);
       }
   
       function Footer()
       {
           $this->SetY(-30);
           $this->Cell(0,20,'CyberSky @ 2024',0,0,'C');
       }
   }
   
   
   
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
   
       public function getUserAddress($address_id)
       {
           $sql = "SELECT * FROM address WHERE address_id = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i", $address_id);
           $stmt->execute();
           $result = $stmt->get_result();
           return $result->fetch_assoc();
       }
   
       public function setUserDeatails($userid, $firstname, $lastname, $email, $phone, $address_id, $line1, $line2, $city, $province, $postal_code)
       {
           if ($address_id != 0) 
           {
               $stmt = $this->conn->prepare("UPDATE address SET line1 = ?, line2 = ?, city = ?, province = ?, postal_code = ? WHERE address_id = ?");
               $stmt->bind_param("sssssi", $line1, $line2, $city, $province, $postal_code, $address_id);
               $stmt->execute();
           } 
           else 
           {
               $stmt2 = $this->conn->prepare("INSERT INTO address (line1, line2, city, province, postal_code) VALUES (?, ?, ?, ?, ?)");
               $stmt2->bind_param("sssss", $line1, $line2, $city, $province, $postal_code);
               $stmt2->execute();
               $address_id = $stmt2->insert_id;
           }
           $stmt = $this->conn->prepare("UPDATE user SET firstname = ?, lastname = ?, email = ?, phone = ?, address_id = ? WHERE user_id = ?");
           $stmt->bind_param("ssssii", $firstname, $lastname, $email, $phone, $address_id, $userid);
           $stmt->execute();
           return 'success';
       }

       public function deleteUser($userId,$address_id)
       {
        $Cart = new Cart($this->conn);
        $Cart->clearCart($userId);
        if($address_id!=0)
        {
            $sql = "DELETE FROM address WHERE address_id  = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i",$address_id );
            $stmt->execute();
        }
        $sql2 = "DELETE FROM user WHERE user_id  = ?";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bind_param("i",$userId);
        $stmt2->execute();
       }
      
   }
   
   
   class Cart{
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

       public function clearCart($userId) 
       {
           $sql = "DELETE FROM cart WHERE user_id = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i",$userId);
           $stmt->execute();
       }
   
       public function createInvoice($userId) 
       {
           $User = new User($this->conn);
           $userDetails = $User->getUserById($userId);
           $userAddress= $User->getUserAddress($userDetails['address_id']);
           
           $allCartItems = $this->getCart($userId);
          
          
                  
           
           $pdf = new PDF();
           $pdf->AddPage();
           $pdf->AliasNbPages();
           $pdf->Ln(20);
           $pdf->SetX(10);
           $pdf->SetFont('Courier','B',14);
           $pdf->Cell(60,5,$userDetails['firstname']." ".$userDetails['lastname'],0,0,"L");
           $pdf->SetX(-60);
           $pdf->Cell(60,5,"Date: ". date('Y-m-d'),0,1,"L");
           $pdf->SetFont('Courier','I',12);
           $pdf->Cell(60,5,$userDetails['email'],0,1,"L");
           $pdf->Cell(60,5,$userDetails['phone'],0,1,"L");
           $pdf->SetFont('Courier','',14);
           $pdf->Ln(5);
           $pdf->Cell(60,5,$userAddress['line1'],0,1,"L");
           if($userAddress['line2']!='')
           $pdf->Cell(60,5,$userAddress['line2'],0,1,"L");
           $pdf->Cell(60,5,$userAddress['city'],0,1,"L");
           $pdf->Cell(60,5,$userAddress['province'],0,1,"L");
           $pdf->Cell(60,5,$userAddress['postal_code'],0,1,"L");
           
           $pdf->Ln(10);
           $pdf->SetX(10);
           
           
               $pdf->SetFillColor(239,240,243);
               $pdf->SetFont('Courier', 'B', 14);
   
               $pdf->Cell(100,15,'Item',1,0,'L',1);
              
               
               $pdf->Cell(30,15,'Price',1,0,'R',1);
   
              
               $pdf->Cell(30,15,'Quantity',1,0,'R',1);
   
             
               $pdf->Cell(30,15,'Subtotal',1,0,'R',1);
   
               $grandtotal=0;
               $pdf->SetFont('Courier', '', 14);
           foreach($allCartItems as $singleItem)
           {   
               $item= $this->getAllProductsUsingID($singleItem["product_id"]);
               $subtotal= $singleItem["quantity"]*$item[0]['product_price'];
               $grandtotal=$grandtotal+$subtotal;
               $pdf->Ln(15);
               $pdf->SetX(10);
               $pdf->Cell(100,15,$item[0]['product_name'],1,0,"L");
               $pdf->Cell(30,15,'$'.$item[0]['product_price'],1,0,"R");
               $pdf->Cell(30,15,$singleItem["quantity"],1,0,"R");
               $pdf->Cell(30,15,'$'.$subtotal,1,0,"R");
           }
           $pdf->Ln(15);
           $pdf->SetX(10);
           $pdf->SetFont('Courier', 'B', 14);
               $pdf->SetFillColor(239,240,243);
               $pdf->Cell(160,15,'Grand Total',1,0,'L',1);
   
               $pdf->SetFillColor(239,240,243);
               $pdf->Cell(30,15, '$'.$grandtotal,1,0,'R',1);
           
           $pdf->Ln(30);
           $pdf->SetX(-60);
           
       
         
           $file='invoices/' . $userDetails['firstname'].'_'.date('Y_m_d_H_i_s').'.pdf';
       
           $pdf->Output($file,'F');
           //echo "<script>window.open('$file', '_blank');</script>";
           return $file;
           
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
   

   
   
   
   
   ?>