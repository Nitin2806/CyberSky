<?php include('header.php'); ?>

<main>
    <div class="hero">Account</div>

    <div class="area-light">


        <div class="container account-area">
        
            <form id="account_form" name="account_form" class="details-form" method="post" action="account.php">

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
                    <button type="submit" id="submit_button" name="submit_button"  class="btn btn-orange">Update Account</button>
                    <a class="btn btn-pink" href="login.php?type=delete">Delete Account</a>
                </div>
            </form>
       
                
        
        </div>


    </div>





</main>

<?php include('footer.php'); ?>
