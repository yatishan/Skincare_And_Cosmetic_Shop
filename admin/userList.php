<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_POST['save'])){
    $name=$_POST['user_name'];
    $email=$_POST['user_email'];
    $password=$_POST['user_password'];
    $phone=$_POST['user_phone'];
    $address=$_POST['user_address'];
    $role="Admin";
    if(!empty($name) && !empty($email) && !empty($password) && !empty($phone) && !empty($address)){
      $stmt = $pdo->prepare('INSERT INTO users (user_name, user_password, user_email, user_address, user_phone, user_role) VALUES (?, ?, ?, ?, ?, ?)');
      $stmt->execute([$name, $password, $email, $address, $phone, $role]);
      header('location:userList.php');
    }else{
      echo "<script> alert('please fill your input') </script>";
    }
    
}

?>

<h5 class="my-4">User Lists</h5>
<!-- user add section start -->
<form action="" method="post">
    <input type="text" name="user_name" class="form-control" placeholder="Enter your name">
    <input type="email" name="user_email" class="form-control" placeholder="Enter your email">
    <input type="password" name="user_password" class="form-control" placeholder="Enter your password">
    <input type="number" name="user_phone" class="form-control" placeholder="Enter your phone">
    <input type="text" name="user_address" class="form-control" placeholder="Enter your address">
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- user add section end -->
<!-- user show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>User Id</th>
      <th>User Name</th>
      <th>User Email</th>
      <th>User Password</th>
      <th>phone</th>
      <th>Address</th>
      <th>Aciton</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT * FROM users');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['user_name']; ?></td>
    <td><?php echo $row['user_email']; ?></td>
    <td><?php echo $row['user_password']; ?></td>
    <td><?php echo $row['user_phone']; ?></td>
    <td><?php echo $row['user_address']; ?></td>
    <td>
        <a href="user_delete.php?id=<?php echo $row['user_id'] ?>"><i class="fa-solid fa-trash"></i></a>
        <a href="user_edit.php?id=<?php echo $row['user_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- user show section end -->
<?php
include('./layout/footer.php');
?>