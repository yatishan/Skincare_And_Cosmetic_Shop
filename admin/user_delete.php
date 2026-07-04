<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE user_id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:userList.php");
    }
}

?>
