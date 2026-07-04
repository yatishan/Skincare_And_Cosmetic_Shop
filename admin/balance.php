<?php
include('./db.php');
include('./layout/side-bar.php');

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
    header('location:balance.php');
}

?>

<h5 class="my-4">Balance Lists</h5>
<!-- balance add section start -->
<form action="" method="post">
    <select class="form-select form-control" name="pro_id" aria-label="Default select example" style="width: 100%;">
       <?php 
        $stmt = $pdo->query('SELECT * FROM products');
        while($row = $stmt->fetch()):
        ?>
        <option value="<?php echo $row['pro_id'] ?>"><?php echo $row['pro_name'] ?></option>
        <?php endwhile ?>
    </select>
    <input type="text" name="income_qty" class="form-control" placeholder="Income Quantity" style="width: 100%;">
    <input type="date" name="income_date" class="form-control" placeholder="Income Date" style="width: 100%;">
    <input type="submit" value="Save" name="save" class="btn btn-danger px-3 my-3">
</form>
<!-- balance add section end -->
<!-- balance show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Id</th>
      <th>Product Name</th>
      <th>Income Quantity</th>
      <th>Sale Quantity</th>
      <th>Balane Quantity</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT balances.*, products.pro_name FROM balances JOIN products ON balances.pro_id=products.pro_id ORDER BY bal_id desc');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['bal_id']; ?></td>
    <td><?php echo $row['pro_name']; ?></td>
    <td><?php echo $row['income_qty']; ?></td>
    <td><?php echo $row['sale_qty']; ?></td>
    <td><?php echo $row['bal_qty']; ?></td>
    <td><?php echo $row['income_date']; ?></td>
    <td>
        <a href="balance_delete.php?id=<?php echo $row['bal_id'] ?>"><i class="fa-solid fa-trash"></i></a>
        <a href="balance_edit.php?id=<?php echo $row['bal_id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- balance show section end -->
<?php
include('./layout/footer.php');
?>