<?php
session_start();
include('./layout/navbar.php');
if(!isset($_SESSION['user_id'])){
    header('location: login&register.php?tab=account');
}else{
    $id=$_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
}

if(isset($_POST['logout'])){
    session_destroy();
    header('location: login&register.php?tab=account');
}

if(isset($_POST['update'])){
    $name=$_POST['user_name'];
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $phone=$_POST['user_phone'];
    $address=$_POST['user_address'];
    if(!empty($name) && !empty($email) && !empty($password) && !empty($phone) && !empty($address)){
        $stmt = $pdo->prepare('UPDATE users SET user_name = ?, user_email = ?, user_password = ?, user_address = ?, user_phone = ? WHERE user_id = ?');
        $stmt->execute([$name, $email, $password, $address, $phone, $id]);
        header('location: account.php');
    }else{
        echo "<script> alert('please fill your input') </script>";
    }
}

?>

<div class="container">
    <h5 class="text-center my-5">Account Information</h5>
    <div class="w-75 p-4 m-auto m-5" style="border:1px solid black; background-color:#F6F6F6; border-radius:10px;">
        <form action="" method="post">
            <div class="mb-3">
                <label for="name" class="form-label my-3">Name</label>
                <input type="text" name="user_name" class="form-control" id="name" style="border:1px solid #f7b6c4; background-color:transparent;" value="<?php echo $row['user_name'] ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label my-3">Email</label>
                <input type="email" name="user_email" class="form-control" id="email" style="border:1px solid #f7b6c4; background-color:transparent;" value="<?php echo $row['user_email'] ?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label my-3">Password</label>
                <input type="password" name="user_password" class="form-control" id="password" style="border:1px solid #f7b6c4; background-color:transparent;" value="<?php echo $row['user_password'] ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label my-3">Phone</label>
                <input type="number" name="user_phone" class="form-control" id="phone" style="border:1px solid #f7b6c4; background-color:transparent;" value="<?php echo $row['user_phone'] ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label my-3">Address</label>
                <input type="text" name="user_address" class="form-control" id="address" style="border:1px solid #f7b6c4; background-color:transparent;" value="<?php echo $row['user_address'] ?>">
            </div>
            <input type="submit" name="update" value="Update Information" class="home-btn text-white my-3 px-3 me-3">
            <input type="submit" name="logout" value="Logout" class="home-btn text-white my-3 px-3">
        </form>
    </div>
</div>


<?php
include('./layout/footer.php');
?>