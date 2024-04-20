<?php include('header.php'); ?>

<main>
    <div class="hero">
        <h1>Checkout</h1>
    </div>

    <div class="area-light">
        <div class="container cart-area">

            <?php

            $cartItems = new Cart($conn);
            $allCartItems = $cartItems->getCart($userId);
            if (!$allCartItems) {
            ?>
                <div class="alert">
                    No Items in the Cart!
                </div>
            <?php
            } else {

                $User = new User($conn);
                $userDetails = $User->getUserById($userId);
                $firstname = $userDetails['firstname'];
                $lastname = $userDetails['lastname'];
                $email = $userDetails['email'];
                $phone = $userDetails['phone'];
                if ($userDetails['address_id'] != '') {
                    $address_id = $userDetails['address_id'];
                    $userAddress = $User->getUserAddress($address_id);

                    $line1 = $userAddress['line1'];
                    $line2 = $userAddress['line2'];
                    $city = $userAddress['city'];
                    $province = $userAddress['province'];
                    $postal_code = $userAddress['postal_code'];
                } else {
                    $address_id = 0;
                    $line1 = "";
                    $line2 = "";
                    $city = "";
                    $province = "";
                    $postal_code = "";
                }


                $firstname_error = "";
                $lastname_error = "";
                $email_error = "";
                $phone_error = "";
                $line1_error = "";
                $city_error = "";
                $province_error = "";
                $postal_code_error = "";

                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $firstname = $_POST["firstname"];
                    $lastname = $_POST["lastname"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $address_id = $_POST["address_id"];
                    $line1 = $_POST["line1"];
                    $line2 = $_POST["line2"];
                    $city = $_POST["city"];
                    $province = $_POST["province"];
                    $postal_code = $_POST["postal_code"];

                    $valid = 1;

                    if (empty($firstname) || !preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
                        $firstname_error = "Enter a valid firstname with only letters and whitespace";
                        $valid = 0;
                    }

                    if (empty($lastname) || !preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
                        $lastname_error = "Enter a valid lastname with only letters and whitespace";
                        $valid = 0;
                    }

                    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $email_error = "Enter a valid email address";
                        $valid = 0;
                    }

                    if (empty($phone) || !preg_match('/^[0-9]{10}+$/', $phone)) {
                        $phone_error = "Enter a valid 10 digit phone number";
                        $valid = 0;
                    }

                    if (empty($line1)) {
                        $line1_error = "Enter your address";
                        $valid = 0;
                    }

                    if (empty($city) || !preg_match("/^[a-zA-Z-' ]*$/", $city)) {
                        $city_error = "Enter a valid city with only letters and whitespace";
                        $valid = 0;
                    }

                    if (empty($province) || !preg_match("/^[a-zA-Z-' ]*$/", $province)) {
                        $province_error = "Enter a valid province with only letters and whitespace";
                        $valid = 0;
                    }

                    if (empty($postal_code) || !preg_match('/^([a-zA-Z0-9]){6}$/', $postal_code)) {
                        $postal_code_error = "Enter a valid 6-character postal code with only letters and numbers";
                        $valid = 0;
                    }

                    if ($valid == 1) {
                        $userUpdate = $User->setUserDeatails($userId, $firstname, $lastname, $email, $phone, $address_id, $line1, $line2, $city, $province, $postal_code);
                        $file = $cartItems->createInvoice($userId);
                        echo "<script>window.open('$file', '_blank');</script>";
                        $cartItems->clearCart($userId);

                        header("Refresh: 1; URL=index.php");
                        exit();
                    }
                }

            ?>

                <div class="cart-table">

                    <div class="cart-header">
                        <div class="cart-col cart-col-name">Name</div>
                        <div class="cart-col cart-col-price">Price</div>
                        <div class="cart-col cart-col-quantity">Quantity</div>
                        <div class="cart-col cart-col-subtotal">Subtotal</div>

                    </div>

                    <?php
                    $grandtotal = 0;
                    foreach ($allCartItems as $singleItem) {
                        $item = $cartItems->getAllProductsUsingID($singleItem["product_id"]);
                        $subtotal = $singleItem["quantity"] * $item[0]['product_price'];
                        $grandtotal = $grandtotal + $subtotal;
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




        <div class="container checkout-area">
            <form id="checkout_form" name="checkout_form" class="details-form" method="post" action="checkout.php">

                <input type="hidden" id="address_id" name="address_id" class="form-control" value="<?php echo $address_id; ?>">

                <div class="form-field">
                    <label for="firstname">First Name:*</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                    <div class="field-error"><?php echo $firstname_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="lastname">Last Name:*</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                    <div class="field-error"><?php echo $lastname_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="email">Email:*</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    <div class="field-error"><?php echo $email_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="phone">Phone:*</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>">
                    <div class="field-error"><?php echo $phone_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="line1">Address Line 1:*</label>
                    <input type="text" id="line1" name="line1" class="form-control" value="<?php echo $line1; ?>">
                    <div class="field-error"><?php echo $line1_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="line2">Address Line 2:</label>
                    <input type="text" id="line2" name="line2" class="form-control" value="<?php echo $line2; ?>">
                </div>

                <div class="form-field">
                    <label for="city">City:*</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo $city; ?>">
                    <div class="field-error"><?php echo $city_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="province">Province:*</label>
                    <input type="text" id="province" name="province" class="form-control" value="<?php echo $province; ?>">
                    <div class="field-error"><?php echo $province_error; ?></div>
                </div>

                <div class="form-field">
                    <label for="postal_code">Postal Code:*</label>
                    <input type="text" id="postal_code" name="postal_code" class="form-control" value="<?php echo $postal_code; ?>">
                    <div class="field-error"><?php echo $postal_code_error; ?></div>
                </div>

                <div class="form-field button-field">
                    <button type="submit" id="submit_button" name="submit_button" class="btn btn-orange">Checkout</button>
                </div>
            </form>

        <?php }

        ?>

        </div>


    </div>





</main>

<?php
include('footer.php'); ?>