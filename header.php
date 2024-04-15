<?php 
session_start();

if(isset($_SESSION["userId"]))
$userId=$_SESSION["userId"];
else
{
    $userId=0;
    if ((basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == 'login.php'))
    {}
    else
    {
        header("Location: login.php");
        exit();
    } 
}


include('connection.php'); 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
        <title>Cybersky</title>
    </head>
    <body>
        <nav>
            <div class="container">
                <div class="logo">
                    <img src="images/logo2.png">
                </div>
                <ul>          
                    <li><a href="index.php">Home</a></li>
                    <?php
                    if($userId!=0)
                    {
                    ?>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="login.php?logout=true">Logout</a></li>
                    <?php
                    }
                    else
                    {
                    ?>
                    <li><a href="login.php">Login</a></li>
                    <?php
                    }
                  ?>
                </ul>
            </div>
        </nav>