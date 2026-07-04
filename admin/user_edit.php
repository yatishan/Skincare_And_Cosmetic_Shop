<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['save'])){
    $name=$_POST['user_name'];
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $phone=$_POST['user_phone'];
    $address=$_POST['user_address'];
    $role="Admin";
    $stmt = $pdo->prepare('UPDATE users SET user_name = ?, user_email = ?, user_password = ?, user_address = ?, user_phone = ?, user_role = ? WHERE user_id = ?');
    $stmt->execute([$name, $email, $password, $address, $phone, $role, $id]);
}

?>
<h5 class="my-4">User Update</h5>
<!-- user add section start -->
<?php 
$id=$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();
?>
<form action="" method="post">
    <input type="text" name="user_name" class="form-control" value="<?php echo $row['user_name'] ?>" placeholder="Enter your name">
    <input type="email" name="user_email" class="form-control" value="<?php echo $row['user_email'] ?>" placeholder="Enter your email">
    <input type="password" name="user_password" class="form-control" value="<?php echo $row['user_password'] ?>" placeholder="Enter your password">
    <input type="number" name="user_phone" class="form-control" value="<?php echo $row['user_phone'] ?>" placeholder="Enter your phone">
    <input type="text" name="user_address" class="form-control" value="<?php echo $row['user_address'] ?>" placeholder="Enter your address">
    <input type="submit" value="Update" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- user add section end -->

<?php
include('./layout/footer.php');
?>