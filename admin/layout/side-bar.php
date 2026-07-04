<?php
session_start();
include('./db.php');
$user_id=$_SESSION['user_id'];
if($user_id){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $row = $stmt->fetch();
    if($row['user_role']=="User"){
        header('location:../index.php');
        exit;
    }
}else{
    header('location:../index.php');
    exit;
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location: ../login&register.php');
}

$tab = $_GET['tab'] ?? 'dash';
$page_titles = [
    'dash' => 'Dashboard',
    'user' => 'User Lists',
    'cat' => 'Category Lists',
    'sc' => 'Sub Category Lists',
    'pro' => 'Product Lists',
    'order' => 'Order Lists',
    'message' => 'Messages',
    'bal' => 'Balance',
];
$page_title = $page_titles[$tab] ?? 'Dashboard';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="admin-shell">
        <!-- side bar section start -->
        <div class="side-bar" id="side-bar">    
            <div class="admin-brand">
                <span class="admin-brand-icon"><i class="fa-solid fa-spa"></i></span>
                <div>
                    <h6>Skincare & Cosmetic</h6>
                    <p>Admin Panel</p>
                </div>
            </div>
            <div class="bar"></div>
            <div class="admin-nav-item">
                <a href="./index.php?tab=dash" class="admin-nav-link <?php echo $tab=='dash' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-house-chimney"></i>
                    <p class="m-3">Dashboard</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./userList.php?tab=user" class="admin-nav-link <?php echo $tab=='user' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-users"></i>
                    <p class="m-3">User Lists</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./category.php?tab=cat" class="admin-nav-link <?php echo $tab=='cat' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-list"></i>
                    <p class="m-3">Category Lists</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./subcategory.php?tab=sc" class="admin-nav-link <?php echo $tab=='sc' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <p class="m-3">Sub Category Lists</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./product.php?tab=pro" class="admin-nav-link <?php echo $tab=='pro' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-box-archive"></i>
                    <p class="m-3">Product Lists</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./order.php?tab=order" class="admin-nav-link <?php echo $tab=='order' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <p class="m-3">Order Lists</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./message.php?tab=message" class="admin-nav-link <?php echo $tab=='message' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-comment-dots"></i>
                    <p class="m-3">View Message</p>
                </a>
            </div>
            <div class="admin-nav-item">
                <a href="./balance.php?tab=bal" class="admin-nav-link <?php echo $tab=='bal' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-bookmark"></i>
                    <p class="m-3">Balance</p>
                </a>
            </div>  
        </div>
        <!-- side bar section end -->
        <!-- main section start -->
        <div class="main-div">
            <div class="admin-topbar">
             <button class="icon-button" type="button" onclick="myClick()" aria-label="Toggle sidebar">
                <i class="fa-solid fa-bars"></i>
             </button>
             <div class="admin-page-heading">
                <span>Admin</span>
                <h4><?php echo htmlspecialchars($page_title); ?></h4>
             </div>
             <div class="dropdown ms-auto">
               <button class="admin-user-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="admin-avatar"><i class="fa-solid fa-user"></i></span>
                    <span><?php echo htmlspecialchars($row['user_name'] ?? 'Admin'); ?></span>
               </button>
               <ul class="dropdown-menu dropdown-menu-end">
                 
                 <li>
                    <form action="" method="post">
                   <input type="submit" name="logout" value="Logout" class="dropdown-item">
                    </form>
                </li>
                 <li><a class="dropdown-item" href="#">Setting</a></li>
               </ul>
             </div>
            </div>
