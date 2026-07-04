<?php
include('./layout/side-bar.php');
?>
<div class="dashboard-heading">
    <div>
        <span>Overview</span>
        <h5>Dashboard Summary</h5>
    </div>
</div>
<!-- dashboard card start -->
<div class="row my-4">
    <div class="col-md-3 my-4">
        <div class="dash-card">
            <div class="d-flex justify-content-between">
                <div>
                    <?php
                    $user_count = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
                    ?>
                    <p><?php echo $user_count ?></p>
                    <p>User Lists</p>
                </div>
                <i class="fa-solid fa-users fs-4 mt-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 my-4">
        <div class="dash-card">
            <div class="d-flex justify-content-between">
                <div>
                    <?php
                    $order_count = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
                    ?>
                    <p><?php echo $order_count ?></p>
                    <p>Order Lists</p>
                </div>
                <i class="fa-solid fa-cart-shopping fs-4 mt-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 my-4">
        <div class="dash-card">
            <div class="d-flex justify-content-between">
                <div>
                    <?php
                    $contact_count = $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
                    ?>
                    <p><?php echo $contact_count ?></p>
                    <p>Message Noti</p>
                </div>
                <i class="fa-solid fa-envelope fs-4 mt-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 my-4">
        <div class="dash-card">
            <div class="d-flex justify-content-between">
                <div>
                    <?php

                    $income_stmt = $pdo->query("SELECT * FROM orders WHERE DATE(order_date) = CURDATE()");
                    $total=0;
                    while($income_row = $income_stmt->fetch()){
                        $total+=$income_row['total_price'];
                    }
                    ?>
                    <p><?php echo $total ?></p>
                    <p>Income Amount</p>
                </div>
                <i class="fa-solid fa-rectangle-list fs-4 mt-3"></i>
            </div>
        </div>
    </div>
</div>
<!-- dashboard card end -->
<!-- dashboard table start -->
<h5>Recent Orders</h5>
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Order Id</th>
      <th>Customer Name</th>
      <th>Customer Phone</th>
      <th>Order Date</th>
      <th>Total Amount</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT orders.*, users.user_name, users.user_phone FROM orders JOIN users ON orders.user_id=users.user_id ORDER BY order_id desc');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['order_id']; ?></td>
    <td><?php echo $row['user_name']; ?></td>
    <td><?php echo $row['user_phone']; ?></td>
    <td><?php echo $row['order_date']; ?></td>
    <td><?php echo $row['total_price']?></td>
    <td>
        <a href="order_delete.php?id=<?php echo $row['order_id'] ?>"><i class="fa-solid fa-trash"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- dashboard table end -->
<?php
include('./layout/footer.php');
?>
