<?php 
session_start();
include("database_connection.php");

/**
 * 1. Ta orderkod från index
 * 2. Lägg motsvarande produkt + antal i databasen
 */
if(!isset($_SESSION["id"])){
    header('Location: ../index.php');
}else{
    $_SESSION["product_id"] = $_POST["product_id"];
    $_SESSION["product_amount"] = $_POST["product_amount"];
    $_SESSION["product_newprice"] = $_POST["product_newprice"];

    if(empty($_SESSION["product_amount"]) || $_SESSION["product_amount"] == 0){
        header('Location: ../index.php');
    }else{
        
        $statement = $pdo->prepare("SELECT * FROM cart WHERE customer_id = :customer_id");
        $statement->execute(
            [
                ':customer_id' => $_SESSION["id"]
            ]
        );
        $cartIDs = $statement->fetchAll();

        for($i = 0; $i < count($cartIDs); $i++){
            if($cartIDs[$i]["product_id"] == $_SESSION["product_id"]  &&  $cartIDs[$i]["customer_id"] == $_SESSION["id"]){
                
                $newAmount = $cartIDs[$i]["amount"] + $_SESSION["product_amount"];

                $statement = $pdo->prepare(
                    "UPDATE cart
                    SET amount = :amount
                    WHERE product_id = :product_id"
                );

                $statement->execute(
                    [
                        ':amount' => $newAmount,
                        ':product_id' => $_SESSION["product_id"]
                    ]
                );

                header('Location: ../index.php');
                return;
            }

        }

        $statement = $pdo->prepare(
            "INSERT INTO cart (product_id, customer_id, amount) 
            VALUES (:product_id, :customer_id, :amount)"
        );
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