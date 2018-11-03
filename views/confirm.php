<?php
include("../includes/head.php");
include("../includes/database_connection.php");

$statement = $pdo->prepare("DELETE FROM cart WHERE customer_id = :customer_id");
$statement->execute(
    [
        ':customer_id' => $_SESSION["id"]
    ]
);
?>

<h1 class="col-12 centerText"> Tack för din beställning! </h1>
<div class="col-12" style="text-align:center">
    <a class="btn btn-danger" href="../index.php?logout=true">Log out</a>
    <a class="btn btn-dark" href="../index.php">Return</a>
</div>
</body>