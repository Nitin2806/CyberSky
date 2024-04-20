<?php include('header.php');
?>

<main>
    <div class="hero">
        <h1>Welcome to Cybersky</h1>
    </div>
    <div class="area-light">

        <div class="container search-area">

            <?php
            $productObj = new Product($conn);
            $cartItems = new Cart($conn);
            $products = $productObj->getAllProducts();
            if ($userId != 0) {
                $allCartItems = $cartItems->getCart($userId);
            } else
                $allCartItems = [];

            $search = "";

            if (isset($_GET['remove'])) {
                echo $cartItems->removeCart($_GET['remove']);
                $allCartItems = $cartItems->getCart($userId);
            }

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                if (!empty($_POST["search"])) {
                    $search = $_POST["search"];
                    $products = $productObj->getSearchProducts($search);
                }
                if (isset($_POST['product_id'])) {
                    $productId = $_POST['product_id'];
                    $quantity = 1;

                    $cartObj = new Cart($conn);
                    $cartObj->addToCart($userId, $productId, $quantity);
                }

                $allCartItems = $cartItems->getCart($userId);
            }

            ?>
            <form id="form" name="form" method="post" action="index.php">
                <div class="input-group mb-3">
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-orange" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="container shop-area">
            <?php foreach ($products as $product) {
            ?>

                <div class="card item">

                    <img class="card-img-top item-image" alt="<?php echo $product['product_name'] ?>" src="images/<?php echo $product['product_image'] ?>">

                    <div class="card-body">
                        <h5 class="card-title item-name"><?php echo $product['product_name'] ?></h5>
                        <h6 class="card-subtitle mb-2 item-price">$<?php echo  $product['product_price'] ?></h6>
                        <p class="card-text item-desc"><?php echo $product['product_desc'] ?></p>

                        <?php
                        if ($userId != 0) {
                            $cartid = 0;
                            foreach ($allCartItems as $singleItem) {
                                if ($singleItem["product_id"] == $product['product_id']) {
                                    $cartid = $singleItem["cart_id"];
                                }
                            }

                            if ($cartid == 0) {
                        ?>

                                <form method="post" action="index.php">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit" class="btn-orange" name="add_to_cart">Add to Cart</button>
                                </form>

                            <?php
                            } else {
                            ?>

                                <a href="index.php?remove=<?php echo $cartid; ?>" class="btn-pink">Remove From Cart</a>

                            <?php
                            }
                        } else {
                            ?>
                            <a class="btn btn-orange" href="login.php">Add to Cart</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>

            <?php
            }
            ?>

        </div>
    </div>
</main>

<?php include('footer.php'); ?>