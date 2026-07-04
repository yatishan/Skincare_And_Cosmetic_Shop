<?php
include('./db.php');
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
    $result = $stmt->execute([$id]);
    if($result){
        header("location:message.php");
    }
}

?>
