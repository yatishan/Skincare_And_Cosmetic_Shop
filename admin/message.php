<?php
include('./db.php');
include('./layout/side-bar.php');
?>
<h5 class="my-4">View Message</h5>
<!-- product show section start -->
<table class="table" >
  <thead>
    <tr>
      <th>No</th>
      <th>Id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Message</th>
      <th>Aciton</th>
    </tr>
  </thead>
  <tbody>
   <?php 
   $stmt = $pdo->query('SELECT * FROM contacts');
   $i=1;
   while($row = $stmt->fetch()):
   ?>
   <tr>
    <td><?php echo $i++; ?></td>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['message']; ?></td>
    <td>
        <a href="message_delete.php?id=<?php echo $row['id'] ?>"><i class="fa-solid fa-trash"></i></a>
    </td>
   </tr>
   <?php endwhile ?>
  </tbody>
</table>
<!-- product show section end -->

<?php
include('./layout/footer.php')
?>