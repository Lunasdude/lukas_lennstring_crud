<?php
session_start();
include("database_connection.php");

if(isset($_GET['remove'])){
    
    $statement = $pdo->prepare("DELETE FROM cart WHERE product_id = :removal AND customer_id = :customer_id");
    $statement->execute(
        [
            ':removal' => $_GET['remove'],
            ':customer_id' => $_SESSION['id']
        ]
    );
}

header('Location: ../views/checkout.php');