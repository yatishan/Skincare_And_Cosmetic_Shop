<?php

include('./db.php');
include('./layout/side-bar.php');

if(isset($_GET['id'])){
    $id=$_GET['id'];
}

if(isset($_POST['save'])){
    $pro_id=$_POST['pro_id'];
    $income_qty=$_POST['income_qty'];
    $income_date=$_POST['income_date'];
    $has_stmt = $pdo->prepare('SELECT * FROM balances WHERE pro_id = ? ORDER BY bal_id desc limit 1');
    $has_stmt->execute([$pro_id]);
    $has_row = $has_stmt->fetch();
    if($has_row){
       $total_balance=$income_qty+$has_row['bal_qty'];
       $stmt = $pdo->prepare('INSERT INTO balances (pro_id, income_qty, sale_qty, bal_qty, income_date) VALUES (?, ?, ?, ?, ?)');
       $stmt->execute([$pro_id, $income_qty, '0', $total_balance, $income_date]);
    }else{
       $stmt = $pdo->prepare('INSERT INTO balances (pro_id, income_qty, sale_qty, bal_qty, income_date) VALUES (?, ?, ?, ?, ?)');
       $stmt->execute([$pro_id, $income_qty, '0', $income_qty, $income_date]);
    }
    // header('location:balance.php');
}

?>

<h5 class="my-4">Balance Update</h5>
<!-- balance add section start -->
<?php
 $stmt = $pdo->prepare('SELECT balances.*, products.pro_name FROM balances JOIN products ON balances.pro_id=products.pro_id WHERE bal_id = ?');
 $stmt->execute([$id]);
 $bal_row = $stmt->fetch();
?>
<form action="" method="post">
    <select class="form-select form-control" name="pro_id" aria-label="Default select example" style="width: 100%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM products');
        while($row = $stmt->fetch()):
        ?>
        <option <?php echo $selected=$row['pro_id']==$bal_row['pro_id']?"selected":""; ?> value="<?php echo $row['pro_id'] ?>"><?php echo $row['pro_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="text" name="income_qty" class="form-control" placeholder="Income Quantity" style="width: 100%;" value="<?php echo $bal_row['income_qty'] ?>">
    <input type="date" name="income_date" class="form-control" placeholder="Income Date" style="width: 100%;" value="<?php echo $bal_row['income_date'] ?>">
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- balance add section end -->
<?php
include('./layout/footer.php');
?>