<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_POST['save'])){
    $sc_name=$_POST['sc_name'];
    $cat_id=$_POST['cat_id'];
    if(!empty($sc_name) && !empty($cat_id)){
      $stmt = $pdo->prepare('INSERT INTO sub_categories (sc_name, cat_id) VALUES (?, ?)');
      $stmt->execute([$sc_name, $cat_id]);
      header('location:subcategory.php');
    }else{
      echo "<script> alert('please fill your input') </script>";
    }
   
}

?>

<h5 class="my-4">Sub Category Lists</h5>
<!-- subcategory add section start -->
<form action="" method="post">
    <input type="text" name="sc_name" class="form-control" placeholder="Sub Category Title" style="width: 100%;">
    <select class="form-select form-control" name="cat_id" aria-label="Default select example" style="width: 100%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM categories');
        $i=1;
        while($row = $stmt->fetch()):
        ?>
        <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- subcategory add section end -->
<!-- subcategory show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Sub Category Id</th>
      <th>Sub Category Name</th>
      <th>Category Name</th>
      <th>Aciton</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT sub_categories.*, categories.cat_name FROM sub_categories JOIN categories ON sub_categories.cat_id=categories.cat_id');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['sc_id']; ?></td>
    <td><?php echo $row['sc_name']; ?></td>
    <td><?php echo $row['cat_name']; ?></td>
    <td>
        <a href="subcategory_delete.php?id=<?php echo $row['sc_id'] ?>"><i class="fa-solid fa-trash"></i></a>
        <a href="subcategory_edit.php?id=<?php echo $row['sc_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- subcategory show section end -->
<?php
include('./layout/footer.php');
?>