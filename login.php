<?php include('header.php'); ?>

<main>
    <div class="hero">Login</div>
    <div class="area-light">
    
        <div class="container form-area">
            <form id="login_form" name="login_form" method="post" action="login.php">

                <div class="form-field">
                    <div class="page-error">Wrong Email/Password</div>
                </div>

                <div class="form-field">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                    <div class="field-error">Enter the username</div>
                </div>

                <div class="form-field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <div class="field-error">Enter the password</div>
                </div>
                
                <div class="form-field button-field">
                    <button type="submit" id="submit_button" name="submit_button"  class="btn btn-orange">Login</button>
                    <a class="btn btn-pink" href="login.php?type=signup">Signup</a>
                </div>
                
            </form>
        </div>


        <div class="container form-area">
            <form id="register_form" name="register_form" method="post" action="register.php">

                <div class="form-field">
                    <div class="page-error">Enter valid details</div>
                </div>

                <div class="form-field">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                    <div class="field-error">Enter the username</div>
                </div>

                <div class="form-field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <div class="field-error">Enter the password</div>
                </div>

                <div class="form-field">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    <div class="field-error">Confirm the password</div>
                </div>

                <div class="form-field">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" required>
                    <div class="field-error">Enter your first name</div>
                </div>

                <div class="form-field">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" required>
                    <div class="field-error">Enter your last name</div>
                </div>

                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <div class="field-error">Enter a valid email address</div>
                </div>

                <div class="form-field">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                    <div class="field-error">Enter your phone number</div>
                </div>

                <div class="form-field button-field">
                    <button type="submit" id="submit_button" name="submit_button" class="btn btn-orange">Register</button>
                    <a class="btn btn-pink" href="login.php?type=login">Login</a>
                </div>

            </form>
        </div>
    
    </div>
</main>

<?php include('footer.php'); ?>
