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
                    <h2>Your Items</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                   
                    <?php
                    $getAllCartItem=[];
                    
                    $cartItem = new GetCartItem($conn);
                    $getAllCartItem = $cartItem->getCart($userId);

                    foreach ($getAllCartItem as $item) {
                        echo '<div class="card item">';
                        echo '<img class="card-img-top item-image" alt="' . $item['product_name'] . '" src="images/' . $item['product_image'] . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title item-name">' . $item['product_name'] . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-muted item-price">$' . $item['product_price'] . '</h6>';
                        echo '<p class="card-text item-desc">' . $item['product_desc'] . '</p>';
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
