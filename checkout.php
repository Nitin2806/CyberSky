<?php include('header.php'); ?>

<main>
    <div class="hero">Checkout</div>

    <div class="area-light">
        <div class="container cart-area">
        
        <?php

$cartItems = new Cart($conn);

if($_SERVER['REQUEST_METHOD']=="POST")
{
   
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

        <div class="cart-table">

                <div class="cart-header">
                    <div class="cart-col cart-col-name">Name</div>
                    <div class="cart-col cart-col-price">Price</div>
                    <div class="cart-col cart-col-quantity">Quantity</div>
                    <div class="cart-col cart-col-subtotal">Subtotal</div>
                
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
                        <div class="cart-col cart-col-quantity"><?php echo $singleItem["quantity"]; ?></div>
                        <div class="cart-col cart-col-subtotal"><?php echo $subtotal; ?></div>
                    </div>
                
                <?php
                }
                ?>
                
                <div class="cart-total">
                    <div class="cart-col cart-col-name">Grand Total</div>
                    <div class="cart-col cart-col-price">&nbsp;</div>
                    <div class="cart-col cart-col-quantity">&nbsp;</div>
                    <div class="cart-col cart-col-subtotal"><?php echo $grandtotal; ?></div>
                </div>

            </div>

        
        </div>

        <?php } ?>


        <div class="container checkout-area">
        
            <form id="checkout_form" name="checkout_form" class="details-form" method="post" action="checkout.php">

                <div class="form-field">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control">
                    <div class="field-error">Enter your first name</div>
                </div>

                <div class="form-field">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="form-control">
                    <div class="field-error">Enter your last name</div>
                </div>

                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control">
                    <div class="field-error">Enter a valid email address</div>
                </div>

                <div class="form-field">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control">
                    <div class="field-error">Enter your phone number</div>
                </div>

                <div class="form-field">
                    <label for="address_line1">Address Line 1:</label>
                    <input type="text" id="address_line1" name="address_line1" class="form-control">
                    <div class="field-error">Enter Address Line 1</div>
                </div>

                <div class="form-field">
                    <label for="address_line2">Address Line 2:</label>
                    <input type="text" id="address_line2" name="address_line2" class="form-control">
    
                 </div>

                <div class="form-field">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control">
                    <div class="field-error">Enter City</div>
                </div>

                <div class="form-field">
                    <label for="province">Province:</label>
                    <input type="text" id="province" name="province" class="form-control">
                    <div class="field-error">Enter Province</div>
                </div>

                <div class="form-field">
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control">
                    <div class="field-error">Enter Postal Code</div>
                </div>

                <div class="form-field button-field">
                    <button type="submit" id="submit_button" name="submit_button"  class="btn btn-orange">Checkout</button>
                </div>
            </form>
       
                
        
        </div>


    </div>





</main>

<?php include('footer.php'); ?>
