<?php 
session_start();
include('./layout/navbar.php');
?>
    <!-- home section start -->
    <div class="container">
        <div class="row align-items-center mt-3">
            <div class="col-md-6">
                <h6 class="heading mb-3">Sale Up To 50% Off</h6>
                <h3 class="mb-3"><span class="text-secondary">Discover </span>The Secrets</h3>
                <h3 class="mb-3">Of <span class="text-secondary">Beauty</span></h3>
                <a href="./product.php?tab=product"><button class="text-white home-btn">Shop Now<i class="fa-solid fa-paper-plane ms-2"></i></button></a>
            </div>
            <div class="col-md-6">
                <div class="row align-items-center">
                    <div class="col-7">
                        <img class="img1" src="./image/_.jpeg" alt="">
                    </div>
                    <div class="col-5">
                        <img class="img2" src="./image/Refresher.jpeg" alt="">
                        <img class="img3" src="./image/I Switched to a Korean Skin Care Routine_ Here's Why I'm a Total Convert.jpeg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- home section end -->
    <!-- latest product section start -->
    <div class="container my-5">
        <h4 class="my-5">Latest Product</h4>
        <div class="row my-5">
            <?php 
            $stmt = $pdo->query('SELECT * FROM products ORDER BY pro_id desc limit 8');
            while($row = $stmt->fetch()):
              $pro_id=$row['pro_id'];
              $bal_stmt = $pdo->prepare('SELECT * FROM balances WHERE pro_id = ? ORDER BY bal_id desc limit 1');
              $bal_stmt->execute([$pro_id]);
              $bal_row = $bal_stmt->fetch();
              if($bal_row['bal_qty']!=null || $bal_row['bal_qty'] > 0){
            ?>
           
            <div class="col-lg-3 col-md-4 col-sm-6 px-3 mb-3">
                <div class="pro-div pb-3 text-center">
                    <img width="100%" height="250px" src="./image/<?php echo $row['pro_img'] ?>" alt="">
                    <h6 class="my-2"><?php echo $row['pro_name'] ?></h6>
                    <?php 
                     if(isset($_SESSION['user_id'])){
                    ?>
                    <button onclick="myClick('<?php echo $row['pro_id'] ?>','<?php echo $row['pro_detail'] ?>','<?php echo $row['pro_name'] ?>','<?php echo $row['pro_price'] ?>','<?php echo $row['pro_img'] ?>')" class="login-btn">Add To Cart</button>
                    <?php }else{ ?>
                    <a href="./login&register.php?tab=account"><button class="login-btn">Login</button></a>
                    <?php  }?>
                    <p><?php echo $row['pro_price'] ?>MMK</p>
                </div>
            </div>
            <?php } endwhile ?>
        </div>
        <a href="./product.php?tab=product"><button class="text-white home-btn">Shop All Product</button></a>
    </div>
    <!-- latest product section end -->
    <!-- why choose us section start -->
    <div class="container mt-5">
      <h4 class="my-5">Why Choose Us</h4>
      <div class="row mb-5">
        <div class="col-lg-3 col-md-6 px-3 mb-3">
          <div class="text-center w-100" style="background-color: #f7b6c4; padding:30px 0px; border-radius:10px;">
            <i class="fa-solid fa-rectangle-list fs-3 mb-3"></i>
            <h5>Smart Search & Filter</h5>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 px-3 mb-3">
          <div class="text-center w-100" style="background-color: #f7b6c4; padding:30px 0px; border-radius:10px;">
            <i class="fa-solid fa-business-time fs-3 mb-3"></i>
            <h5>24/7 Service</h5>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 px-3 mb-3">
          <div class="text-center w-100" style="background-color: #f7b6c4; padding:30px 0px; border-radius:10px;">
            <i class="fa-solid fa-suitcase  fs-3 mb-3"></i>
            <h5>Online Order</h5>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 px-3 mb-3">
          <div class="text-center w-100" style="background-color: #f7b6c4; padding:30px 0px; border-radius:10px;">
            <i class="fa-solid fa-truck  fs-3 mb-3"></i>
            <h5>Fast Delivery</h5>
          </div>
        </div>
      </div>
    </div>
    <!-- why choose us section end -->
<?php
include('./layout/footer.php');
?>