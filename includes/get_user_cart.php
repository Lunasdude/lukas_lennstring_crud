<?php $statement = $pdo->prepare("SELECT products.product_name, cart.amount, cart.new_price, cart.product_id FROM products INNER JOIN cart ON products.product_id=cart.product_id WHERE cart.customer_id = :userID");
$statement->execute(
    [
        ':userID' => $_SESSION["id"]
    ]
);
$articles = $statement->fetchAll();