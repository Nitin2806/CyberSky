<?php  include('header.php'); ?>

    <main>
        <div class="hero">Shop</div>
        <div class="area-light">

            <div class="container search-area">

            <?php 
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

            <div class="container shop-area">

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

                <div class="card item">
                    <img class="card-img-top item-image" src="images/iphone.jpg">
                    <div class="card-body">
                        <h5 class="card-title item-name">Item Name</h5>
                        <h6 class="card-subtitle mb-2 text-muted item-price">Item Price</h6>
                        <p class="card-text item-desc">Item Desc</p>
                        <a href="#" class="btn-orange">Add to Cart</a>
                        <a href="#" class="btn-pink">Remove From Cart</a>
                    </div>
                </div>

            
           

            </div>
        </div>
    </main>

<?php  include('footer.php'); ?>

  