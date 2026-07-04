<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['save'])){
    $cat_name=$_POST['cat_name'];
    $stmt = $pdo->prepare('UPDATE categories SET cat_name = ? WHERE cat_id = ?');
    $stmt->execute([$cat_name, $id]);
    // header('location:category.php');
}

?>

<h5 class="my-4">Category Update</h5>
<!-- category add section start -->
 <?php
 $stmt = $pdo->prepare('SELECT * FROM categories WHERE cat_id = ?');
 $stmt->execute([$id]);
 $row = $stmt->fetch();
 ?>
<form action="" method="post">
    <input type="text" name="cat_name" class="form-control" placeholder="Category Title" style="width: 100%;" value="<?php echo $row['cat_name'] ?>">
    <input type="submit" value="Update" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- category add section end -->
<?php
include('./layout/footer.php');
?>