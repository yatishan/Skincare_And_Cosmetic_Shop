<?php 
include('./admin/db.php');
if(isset($_GET['tab'])){
  $tab=$_GET['tab'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skincare & Cosmetic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <!-- nav section start -->
    <nav class="navbar navbar-expand-lg py-3">
         <div class="container">
           <a class="navbar-brand" href="./index.php?tab=home">Skincare & Cosmetic</a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100 justify-content-center">
               <li class="nav-item me-2 ">
                 <a class="nav-link fs-6 active" aria-current="page" href="./index.php?tab=home" style="color:<?php
                echo $tab=='home'?"#f7597b":"#5a494b";
                ?> ;">Home</a>
               </li>
               <li class="nav-item me-2 dropdown">
                 <a class="nav-link fs-6 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:<?php
                echo $tab=='shop'?"#f7597b":"#5a494b";
                ?> ;">
                   Shop
                 </a>
                 <ul class="dropdown-menu">
                   <?php 
                   $stmt = $pdo->query('SELECT * FROM categories');
                   while($row = $stmt->fetch()):
                   ?>
                   <li><a class="dropdown-item" href="shop.php?id=<?php echo $row['cat_id'] ?>&&tab=shop"><?php echo $row['cat_name'] ?></a></li>
                   <?php endwhile ?>
                 </ul>
               </li>
               <li class="nav-item me-2">
                 <a class="nav-link fs-6" href="./about.php?tab=about" style="color:<?php
                echo $tab=='about'?"#f7597b":"#5a494b";
                ?> ;">About Us</a>
               </li>
               <li class="nav-item me-2">
                 <a class="nav-link fs-6" href="./contact.php?tab=contact" style="color:<?php
                echo $tab=='contact'?"#f7597b":"#5a494b";
                ?> ;">Contact</a>
               </li>
             </ul>
             <form class="d-flex" role="search">
               <a href="./product.php?tab=product" class="text-dark ms-3" ><i class="fa-solid fa-magnifying-glass" style="color:<?php
                echo $tab=='product'?"#f7597b":"#5a494b";
                ?> ;"></i></a>
               <a href="./account.php?tab=account" class="text-dark ms-3"><i class="fa-solid fa-user" style="color:<?php
                echo $tab=='account'?"#f7597b":"#5a494b";
                ?> ;"></i></a>
               <a href="./cart.php?tab=cart" class="text-dark ms-3"><i class="fa-solid fa-bag-shopping" style="color:<?php
                echo $tab=='cart'?"#f7597b":"#5a494b";
                ?> ;"></i></a>
             </form>
           </div>
         </div>
    </nav>
    <!-- nav section end -->