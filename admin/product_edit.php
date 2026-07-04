<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['save'])){
    $pro_name=$_POST['pro_name'];
    $pro_price=$_POST['pro_price'];
    $pro_detail=$_POST['pro_detail'];
    $sc_id=$_POST['sc_id'];
    $img_name = '';
    if(isset($_FILES['pro_img']) && $_FILES['pro_img']['error'] == 0){
        $img_name = time() . '_' . basename($_FILES['pro_img']['name']);
        $target = "../image/" . $img_name;
        move_uploaded_file($_FILES['pro_img']['tmp_name'], $target);
        $stmt = $pdo->prepare('UPDATE products SET pro_name = ?, pro_price = ?, pro_img = ?, pro_detail = ?, sc_id = ? WHERE pro_id = ?');
        $stmt->execute([$pro_name, $pro_price, $img_name, $pro_detail, $sc_id, $id]);
    }else{
        $stmt = $pdo->prepare('UPDATE products SET pro_name = ?, pro_price = ?, pro_detail = ?, sc_id = ? WHERE pro_id = ?');
        $stmt->execute([$pro_name, $pro_price, $pro_detail, $sc_id, $id]);
    }
    // header("location:product.php");
                        
}
?>

<h5 class="my-4">Product Update</h5>
<!-- prodcut add section start -->
<?php 
$stmt = $pdo->prepare('SELECT products.*, sub_categories.sc_name FROM products JOIN sub_categories ON products.sc_id=sub_categories.sc_id WHERE pro_id = ?');
$stmt->execute([$id]);
$pro_row = $stmt->fetch()

?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="pro_name" class="form-control" placeholder="Product Name" value="<?php echo $pro_row['pro_name'] ?>">
    <input type="number" name="pro_price" class="form-control" placeholder="Product Price" value="<?php echo $pro_row['pro_price'] ?>">
    <input type="text" name="pro_detail" class="form-control" placeholder="Prodcut Description" value="<?php echo $pro_row['pro_detail'] ?>">
    <input type="file" name="pro_img" class="form-control">
    <select class="form-select form-control" name="sc_id" aria-label="Default select example" style="width: 98%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM sub_categories');
        $i=1;
        while($row = $stmt->fetch()):
        ?>
        <option <?php echo $selected=$row['sc_id']==$pro_row['sc_id']?"selected":""; ?> value="<?php echo $row['sc_id'] ?>"><?php echo $row['sc_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="submit" value="Update" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- product add section end -->
<?php
include('./layout/footer.php');
?>