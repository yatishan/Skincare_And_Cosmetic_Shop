<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM sub_categories WHERE sc_id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:subcategory.php");
    }
}

?>
