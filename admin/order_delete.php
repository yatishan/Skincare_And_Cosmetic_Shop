<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM order_product WHERE order_id = ?');
    $result_op = $stmt->execute([$id]);
    $stmt = $pdo->prepare('DELETE FROM orders WHERE order_id = ?');
    $result = $stmt->execute([$id]);
    if($result && $result_op){
        header("location:index.php");
    }
}

?>
