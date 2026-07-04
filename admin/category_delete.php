<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM categories WHERE cat_id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:category.php");
    }
}

?>
