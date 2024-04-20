<?php include('header.php'); ?>

<main>

    <?php
    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    if (isset($_GET['type']) && $_GET['type'] == 'signup') {
        $type = 'signup';
    } elseif (isset($_POST['type']) && $_POST['type'] == 'signup') {
        $type = 'signup';
    } else {
        $type = 'login';
    }

    if (isset($_GET['message']) && $_GET['message'] == 'registered') {
        $message = '<div class="alert">User Account Created. Please Login!</div>';
    } else if (isset($_GET['message']) && $_GET['message'] == 'failed') {
        $message = '<div class="alert">No such user or wrong password!</div>';
    } else if (isset($_GET['message']) && $_GET['message'] == 'deleted') {
        $message = '<div class="alert">User Account has been deleted</div>';
    } else
        $message = '';

    $User = new User($conn);

    $username = "";
    $password = "";
    $username_error = "";
    $password_error = "";

    if ($type == 'login') {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $username = $_POST["username"];
            $password = $_POST["password"];
            $valid = 1;

            if (empty($username) || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $username_error = "Enter a valid username with only letters";
                $valid = 0;
            }

            if (empty($password)) {
                $password_error = "Enter a password";
                $valid = 0;
            }

            if ($valid == 1) {
                $result = $User->checkUser($username, $password);
                if ($result == 0) {
                    header("Location: login.php?message=failed");
                    exit();
                } else {
                    $_SESSION["userId"] = $result;
                    header("Location: index.php");
                    exit();
                }
            }
        }
    ?>

        <div class="hero">
            <h1>Login</h1>

        </div>
        <div class="area-light">

            <div class="container form-area">
                <form id="login_form" name="login_form" method="post" action="login.php">

                    <div class="form-field">
                        <input type="hidden" id="type" name="type" value="login">
                        <?php echo $message; ?>
                    </div>

                    <div class="form-field">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="form-control">
                        <div class="field-error"><?php echo $username_error; ?></div>
                    </div>

                    <div class="form-field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control">
                        <div class="field-error"><?php echo $password_error; ?></div>
                    </div>

                    <div class="form-field button-field">
                        <button type="submit" id="submit_button" name="submit_button" class="btn btn-orange">Login</button>
                        <a class="btn btn-black" href="login.php?type=signup" tabindex="0">Create an account?</a>
                    </div>

                </form>
            </div>
        </div>

    <?php
    } else {

        $confirm = "";
        $firstname = "";
        $lastname = "";
        $email = "";
        $phone = "";

        $confirm_error = "";
        $firstname_error = "";
        $lastname_error = "";
        $email_error = "";
        $phone_error = "";

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $username = $_POST["username"];
            $password = $_POST["password"];
            $confirm = $_POST["confirm_password"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];

            $valid = 1;

            if (empty($username) || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $username_error = "Enter a valid username with only letters";
                $valid = 0;
            }

            if (empty($password)) {
                $password_error = "Enter a password";
                $valid = 0;
            }

            if (empty($confirm) || $password != $confirm) {
                $confirm_error = "Password and Confirm Password should match";
                $valid = 0;
            }

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

            if ($valid == 1) {
                $result = $User->addUser($username, $password, $firstname, $lastname, $email, $phone);
                if ($result == 'success') {
                    header("Location: login.php?message=registered");
                    exit();
                }
            }
        }

    ?>

        <div class="hero">
            <h1>Register</h1>
        </div>
        <div class="area-light">

            <div class="container form-area">
                <form id="register_form" name="register_form" method="post" action="login.php">

                    <div class="form-field">
                        <input type="hidden" id="type" name="type" value="signup">
                        <?php echo $message; ?>
                    </div>

                    <div class="form-field">
                        <label for="username">Username:*</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>">
                        <div class="field-error"><?php echo $username_error; ?></div>
                    </div>

                    <div class="form-field">
                        <label for="password">Password:*</label>
                        <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                        <div class="field-error"><?php echo $password_error; ?></div>
                    </div>

                    <div class="form-field">
                        <label for="confirm_password">Confirm Password:*</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $confirm; ?>">
                        <div class="field-error"><?php echo $confirm_error; ?></div>
                    </div>

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
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                        <div class="field-error"><?php echo $email_error; ?></div>
                    </div>

                    <div class="form-field">
                        <label for="phone">Phone:*</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>">
                        <div class="field-error"><?php echo $phone_error; ?></div>
                    </div>

                    <div class="form-field button-field">
                        <button type="submit" id="submit_button" name="submit_button" class="btn btn-orange">Signup</button>
                        <a class="btn btn-black" href="login.php?type=login">Login</a>
                    </div>

                </form>
            </div>
        </div>

    <?php
    }
    ?>

</main>

<?php include('footer.php'); ?>