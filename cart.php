<?php
include('header.php');
include('connection.php');
$userId=1
?>

<main>
    <div class="hero">Your Cart</div>
    <div class="area-light">
        <div class="container cart-area">
            <div class="row">
                <div class="col">
                   
                    <?php
                    $getAllCartItem=[];

                    $cartItem = new Cart($conn);
                    $getAllCartItem = $cartItem->getCart($userId);
              
                    
                    foreach($getAllCartItem as $getProduct){
                       $item= $cartItem->getAllProductsUsingID($getProduct["product_id"]);
                       echo '<div class="card item">';
                       echo '<img class="card-img-top item-image" alt="' . $item[0]['product_name'] . '" src="images/' . $item[0]['product_image'] . '">';
                       echo '<div class="card-body">';
                       echo '<h5 class="card-title item-name">' . $item[0]['product_name'] . '</h5>';
                       echo '<h6 class="card-subtitle mb-2 text-muted item-price">$' . $item[0]['product_price'] . '</h6>';
                       echo '<p class="card-text item-desc">' . $item[0]['product_desc'] . '</p>';
                       echo '<a href="#" class="btn btn-pink">Remove From Cart</a>';
                       echo '</div>';
                       echo '</div>';
                     }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('footer.php'); ?>
