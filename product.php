<?php
session_start();
include('./layout/navbar.php');

?>

    <!-- search section start -->
    <div class="container mt-5">
       <div class="row">
        <div class="col-lg-6">
        <form action="" method="post" class="d-flex justify-content-between">
            <input type="text" name="search" style="border:1px solid rgb(247, 101, 133); width:80%; border-radius:10px; padding:7px 10px;" placeholder="product name..">
            <input type="submit" name="save" value="Search" class="home-btn text-white px-3">
        </form> 
        </div>
       </div>
    </div>
    <!-- search section end -->
    <!-- product section start -->
    <div class="container my-5">
        <div class="row my-5">
            <?php 
            if(isset($_POST['save'])){
                $search=$_POST['search'];
                $stmt = $pdo->prepare('SELECT * FROM products WHERE pro_name LIKE ?');
                $stmt->execute(['%' . $search . '%']);
                if($stmt->rowCount() == 0){
                    echo "<script> alert('data is not found'); </script>";
                    $stmt = $pdo->query('SELECT * FROM products');
                }
            }else{
                $stmt = $pdo->query('SELECT * FROM products');

            }
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
    </div>
    <!-- product section end -->

<?php
include('./layout/footer.php');
?>