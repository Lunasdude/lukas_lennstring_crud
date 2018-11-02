<?php

include("database_connection.php");

if(isset($_GET['remove'])){
    $removal = $_GET['remove'];
    $statement = $pdo->prepare("DELETE FROM cart WHERE product_id = $removal");
    $statement->execute(
        [

        ]
    );
}

header('Location: ../views/checkout.php');