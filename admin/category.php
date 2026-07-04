<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_POST['save'])){
    $cat_name=$_POST['cat_name'];
    if(!empty($cat_name)){
      $stmt = $pdo->prepare('INSERT INTO categories (cat_name) VALUES (?)');
      $stmt->execute([$cat_name]);
      header('location:category.php');
    }else{
      echo "<script> alert('please fill your input') </script>";
    }
   
}

?>

<h5 class="my-4">Category Lists</h5>
<!-- category add section start -->
<form action="" method="post">
    <input type="text" name="cat_name" class="form-control" placeholder="Category Title" style="width: 100%;">
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- category add section end -->
<!-- category show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Category Id</th>
      <th>Category Title</th>
      <th>Aciton</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT * FROM categories');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['cat_id']; ?></td>
    <td><?php echo $row['cat_name']; ?></td>
    <td>
        <a href="category_delete.php?id=<?php echo $row['cat_id'] ?>"><i class="fa-solid fa-trash"></i></a>
        <a href="category_edit.php?id=<?php echo $row['cat_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- user show section end -->
<?php
include('./layout/footer.php');
?>