<?php
session_start();
include('./layout/navbar.php');
if(isset($_GET['id'])){
    $cat_id=$_GET['id'];
}


$stmt = $pdo->prepare('SELECT * FROM categories WHERE cat_id = ?');
$stmt->execute([$cat_id]);
$cat_row = $stmt->fetch();

?>
<div class="d-flex justify-content-center align-items-center cat mb-5">
    <h3>#<?php echo $cat_row['cat_name'] ?></h3>
</div>
<div class="container text-center">
    <div class="sub-cat">
        <h5 class="text-center"><?php echo $cat_row['cat_name'] ?></h5>
        <div class="bar my-4"></div>
        <div>
            <a href="./shop.php?id=<?php echo $cat_id ?>">
            <button class="p-2 me-2" style="background-color: <?php echo empty($_GET['sc_id']) ? '#f7b6c4' : ''; ?>">ALL Skincare</button>
            </a>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM sub_categories WHERE cat_id = ?');
            $stmt->execute([$cat_id]);
            while($sc_row = $stmt->fetch()):
            ?>
            <a href="./shop.php?id=<?= $cat_id ?>&sc_id=<?= $sc_row['sc_id']?>&tab=shop"><button  class="p-2 me-2" style="background-color:<?php if(isset($_GET["sc_id"])){ echo $sc_row['sc_id']==$_GET['sc_id']?'f7b6c4':''; }else{ echo ''; } ?>"><?php echo $sc_row['sc_name'] ?></button></a>
            <?php endwhile ?>
        </div>
    </div>
</div>
<!-- product section start -->
    <div class="container my-5">
        <div class="row my-5">
            <?php 
            if(isset($_GET['sc_id'])){
                $sc_id=$_GET['sc_id'];
                $stmt = $pdo->prepare('SELECT * FROM products WHERE sc_id = ?');
                $stmt->execute([$sc_id]);
            }else{
                $stmt = $pdo->prepare('SELECT * FROM products JOIN sub_categories ON products.sc_id=sub_categories.sc_id JOIN categories ON sub_categories.cat_id=categories.cat_id WHERE categories.cat_id = ?');
                $stmt->execute([$cat_id]);
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