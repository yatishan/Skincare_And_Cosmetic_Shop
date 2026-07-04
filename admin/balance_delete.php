<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM balances WHERE bal_id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:balance.php");
    }
}

?>
