<?php  include('header.php');include('connection.php'); ?>

    <main>
        <div class="hero">Welcome to Cybersky</div>
        <div class="area-light">

            <div class="container search-area">

            <?php
            $productObj = new Product($conn);

            $products = $productObj->getAllProducts();
           
            $search="";

            if($_SERVER['REQUEST_METHOD']=="POST")
            {
                if(!empty($_POST["search"]))
                $search=$_POST["search"];
            }

            ?>
                <form id="form" name="form" method="post" action="index.php">
                    <div class="input-group mb-3">
                        <input type="text"  id="search" name="search" class="form-control" placeholder="Search" value="<?php echo $search; ?>">
                        <div class="input-group-append">
                            <button class="btn btn-orange" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col">
                    <h2>New Trending Phones</h2>
                </div>
            </div>
            <div class="container shop-area">
                <?php  foreach ($products as $product) { ?>
                <div class="card item">
                    <img  class="card-img-top item-image" alt="<?php  echo $product['product_name'] ?>" src="images/<?php  echo $product['product_image'] ?>">
                    <div class="card-body">
                        <h5 class="card-title item-name"><?php  echo $product['product_name'] ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">$<?php echo  $product['product_price'] ?></h6>
                        <p class="card-text item-desc"><?php echo $product['product_desc'] ?></p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </main>

<?php  include('footer.php'); ?>

  