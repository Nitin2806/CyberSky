<?php
include('header.php');

?>

<main>
    <div class="hero">Your Cart</div>
    <div class="area-light">
        <div class="container cart-area">

            <?php

                $cartItems = new Cart($conn);

                if($_SERVER['REQUEST_METHOD']=="POST")
                {
                    $post=($_POST);
                    foreach ($post as $key => $quantity) 
                    {                
                        if (strpos($key, 'cart_quantity_') !== false) 
                        {   
                            $cartId = substr($key, strlen('cart_quantity_'));
                            echo $cartItems->updateCart($cartId,$quantity);
                        }
                    }
                }

                if(isset($_GET['remove']))
                {
                    echo $cartItems->removeCart($_GET['remove']);
                }

                $allCartItems = $cartItems->getCart($userId);
                if(!$allCartItems)
                {
                ?>
                    <div class="alert">
                        No Items in the Cart!
                    </div>
                <?php
                }
                else
                {
                    
                    ?>

        <form id="cart_form" name="cart_form" method="post" action="cart.php">

            <div class="cart-table">

                <div class="cart-header">
                    <div class="cart-col cart-col-name">Name</div>
                    <div class="cart-col cart-col-price">Price</div>
                    <div class="cart-col cart-col-quantity">Quantity</div>
                    <div class="cart-col cart-col-subtotal">Subtotal</div>
                    <div class="cart-col cart-col-action">Action</div>
                </div>
                
                <?php
                $grandtotal=0;
                foreach($allCartItems as $singleItem)
                {
                    $item= $cartItems->getAllProductsUsingID($singleItem["product_id"]);
                    $subtotal= $singleItem["quantity"]*$item[0]['product_price'];
                    $grandtotal=$grandtotal+$subtotal;
                ?>

                    <div class="cart-item">
                        <div class="cart-col cart-col-name"><?php echo $item[0]['product_name']; ?></div>
                        <div class="cart-col cart-col-price"><?php echo $item[0]['product_price']; ?></div>
                        <div class="cart-col cart-col-quantity">
                            <input type="number" name="cart_quantity_<?php echo $singleItem['cart_id']; ?>" id="cart_quantity_<?php echo $singleItem['cart_id']; ?>"  value="<?php echo $singleItem["quantity"]; ?>">
                        </div>
                        <div class="cart-col cart-col-subtotal"><?php echo $subtotal; ?></div>
                        <div class="cart-col cart-col-action">
                            <a class="btn btn-pink" href="cart.php?remove=<?php echo $singleItem["cart_id"]; ?>">Remove</a>
                        </div>
                    </div>
                
                <?php
                }
                ?>
                
                <div class="cart-total">
                    <div class="cart-col cart-col-name">Grand Total</div>
                    <div class="cart-col cart-col-price">&nbsp;</div>
                    <div class="cart-col cart-col-quantity">&nbsp;</div>
                    <div class="cart-col cart-col-subtotal"><?php echo $grandtotal; ?></div>
                    <div class="cart-col cart-col-action">
                        <button type="submit" id="update_button" name="update_button"class="btn btn-black">Update Cart</button>
                    </div>
                </div>

            </div>

            <div class="button-field">
                <a class="btn btn-orange" href="checkout.php">Checkout</a>
            </div>
        
        </form>

            <?php } ?>

        </div>



    </div>
</main>

<?php include('footer.php'); ?>
