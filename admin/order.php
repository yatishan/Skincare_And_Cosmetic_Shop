<?php
include('./db.php');
include('./layout/side-bar.php');
?>
<h5 class="my-4">Order Lists</h5>
<!-- order show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Order Id</th>
      <th>Product Name</th>
      <th>Quantity</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT order_product.*, orders.*, products.pro_name FROM order_product JOIN orders ON order_product.order_id=orders.order_id JOIN products ON order_product.pro_id=products.pro_id ORDER BY orders.order_id desc');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['order_id']; ?></td>
    <td><?php echo $row['pro_name']; ?></td>
    <td><?php echo $row['op_qty']; ?></td>
    <td><?php echo $row['op_price']; ?></td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- order show section end -->

<?php
include('./layout/footer.php')
?>