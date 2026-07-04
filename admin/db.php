<?php

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=final_project;charset=utf8mb4',
        'root',
        '77778888',
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('connection failed');
}

?>
