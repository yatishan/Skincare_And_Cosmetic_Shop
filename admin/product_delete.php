<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM products WHERE pro_id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:product.php");
    }
}

?>
