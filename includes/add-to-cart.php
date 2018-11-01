<?php 
include("database_connection.php");

/**
 * 1. Ta orderkod från index
 * 2. Lägg motsvarande produkt + antal i databasen
 */
var_dump($_SESSION["id"]);
if(!isset($_SESSION["id"])){
    // header('Location: ../index.php');
}else{
    $_SESSION["product_id"] = $_POST["product_id"];
    $_SESSION["product_amount"] = $_POST["product_amount"];
    var_dump($_SESSION);
    if(empty($_SESSION["product_amount"]) || $_SESSION["product_amount"] == 0){
        // header('Location: ../index.php');
    }else{
        $statement = $pdo->prepare("INSERT INTO cart (product_id, customer_id, amount) VALUES (:product_id, :customer_id, :amount)");
        $statement->execute(
            [
                ':product_id' => $_SESSION["product_id"],
                ':customer_id' => $_SESSION["id"],
                ':amount' => $_SESSION["product_amount"]
            ]
        );
        header('Location: ../index.php');
    }
}