<?php
include('./db.php');
include('./layout/side-bar.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['save'])){
    $sc_name=$_POST['sc_name'];
    $cat_id=$_POST['cat_id'];
    $stmt = $pdo->prepare('UPDATE sub_categories SET sc_name = ?, cat_id = ? WHERE sc_id = ?');
    $stmt->execute([$sc_name, $cat_id, $id]);
    // header('location:subcategory.php');
}

?>

<h5 class="my-4">Sub Category Update</h5>
<!-- subcategory add section start -->

<?php 
$stmt = $pdo->prepare('SELECT * FROM sub_categories WHERE sc_id = ?');
$stmt->execute([$id]);
$sc_row = $stmt->fetch();
?>
<form action="" method="post">
    <input type="text" name="sc_name" class="form-control" placeholder="Sub Category Title" style="width: 100%;" value="<?php echo $sc_row['sc_name'] ?>">
    <select class="form-select form-control" name="cat_id" aria-label="Default select example" style="width: 100%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM categories');
        while($row = $stmt->fetch()):
        ?>
        <option <?php echo $selected=$row['cat_id']==$sc_row['cat_id']?"selected":""; ?> value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="submit" value="Update" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- sub category add section end -->
<?php
include('./layout/footer.php');
?>