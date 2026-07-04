<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_POST['save'])){
    $pro_name=$_POST['pro_name'];
    $pro_price=$_POST['pro_price'];
    $pro_detail=$_POST['pro_detail'];
    $sc_id=$_POST['sc_id'];
    $img_name = '';
    if($_FILES['pro_img']['name']!="" && !empty($pro_name) && !empty($pro_price) && !empty($pro_detail) && !empty('sc_id')){
      if(isset($_FILES['pro_img']) && $_FILES['pro_img']['error'] == 0){
        $img_name = time() . '_' . basename($_FILES['pro_img']['name']);
        $target = "../image/" . $img_name;
        move_uploaded_file($_FILES['pro_img']['tmp_name'], $target);
      }


    $stmt = $pdo->prepare('INSERT INTO products (pro_name, pro_price, pro_img, pro_detail, sc_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$pro_name, $pro_price, $img_name, $pro_detail, $sc_id]);
    }else{
      echo "<script> alert('please fill your input') </script>";
    }
    
                        
}
?>

<h5 class="my-4">Product Lists</h5>
<!-- prodcut add section start -->
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="pro_name" class="form-control" placeholder="Product Name">
    <input type="number" name="pro_price" class="form-control" placeholder="Product Price">
    <input type="text" name="pro_detail" class="form-control" placeholder="Prodcut Description">
    <input type="file" name="pro_img" class="form-control">
    <select class="form-select form-control" name="sc_id" aria-label="Default select example" style="width: 98%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM sub_categories');
        $i=1;
        while($row = $stmt->fetch()):
        ?>
        <option value="<?php echo $row['sc_id'] ?>"><?php echo $row['sc_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- product add section end -->
<!-- product show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Product Id</th>
      <th>Product Name</th>
      <th>Price</th>
      <th>Sub Category</th>
      <th>Detail</th>
      <th>Image</th>
      <th>Aciton</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT products.*, sub_categories.sc_name FROM products JOIN sub_categories ON products.sc_id=sub_categories.sc_id');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['pro_id']; ?></td>
    <td><?php echo $row['pro_name']; ?></td>
    <td><?php echo $row['pro_price']; ?></td>
    <td><?php echo $row['sc_name']; ?></td>
    <td style="width: 200px; height:100px" class="overflow-x-hidden"><?php echo $row['pro_detail']; ?></td>
    <td>
        <img src="../image/<?php echo $row['pro_img'] ?>" alt="" style="width:50px; height:50px;">
    </td>
    <td>
        <a href="product_delete.php?id=<?php echo $row['pro_id'] ?>"><i class="fa-solid fa-trash"></i></a>
        <a href="product_edit.php?id=<?php echo $row['pro_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- product show section end -->
<?php
include('./layout/footer.php');
?>