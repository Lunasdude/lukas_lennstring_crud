<?php 
include("../includes/head.php");
include("../includes/database_connection.php");
?>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php">Nice shop™</a>
    </nav>
</header>

<p class="bigP box">Hej <?=$_SESSION["username"]?>!</p>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 centerText">
            <p class="bigP">Varukorg</p>

            <?php 
            $names=[];
            foreach($_POST as $key => $value){
                if(strpos($key, 'Amount')){
                    $names[] .= str_replace("Amount", "", $key);
                }
            }
            
            //Loops through a list of the selected articles and writes out the order
            foreach($names as $name){
                if(is_numeric($_POST[$name."Amount"]) && $_POST[$name."Amount"] >= 1){?>
                    <p> 
                        <!-- Example: Kotte, XX st - XX kr (XX kr/st) -->
                        <?=$name.", ".$_POST[$name."Amount"]." st - ".($_POST[$name."Amount"]*$_POST[$name."Price"])." kr<br>(".$_POST[$name."Price"]." st)"?> 
                    </p>
                <?php
                }
            }
            

// TO DO: * Stack orders of the same article into one pile


            // Writes if a discount applies on the current weekday
            if(date('N') === 1){
                echo "<p class='discountText'>Måndagsrabatt! (-50%)</p>";
            }
            elseif(date('N') === 3){
                echo "<p class='discountText'>Onsdagspriser (+10%)</p>";
            }
            elseif(date('N') === 5){
                echo "<p class='discountText'>Fredagsrabatt! (-20kr på allt över 200kr)</p>";
            }
            
            $totalPrice = 0;					
            
            $statement = $pdo->prepare("SELECT products.product_name, cart.amount, cart.new_price, cart.product_id FROM products INNER JOIN cart ON products.product_id=cart.product_id WHERE cart.customer_id = :userID");
            $statement->execute(
                [
                    ':userID' => $_SESSION["id"]
                ]
            );
            $articles = $statement->fetchAll();

            foreach($articles as $article){
                echo $article["product_name"]." - ".$article["new_price"]." kr/st<br>".$article["amount"]." st<br>"; ?>
                <a style="color:red" href="../includes/delete.php?remove=<?=$article["product_id"]?>">Remove</a> <br><br>
                <?php $totalPrice += ($article["new_price"] * $article["amount"]);
            }
            
            echo "<p>Totalt: ".$totalPrice." kr</p>";
        ?>
        </div>
        <div class="col-12 d-block d-md-none"><hr></div>
        
        <!-- Customer info from the form -->
        <div class="col-12 col-md-6">
            <p class="bigP">Beställning till</p>
            <p class="centerText">
            <?=
                $_SESSION["username"];
            ?>
            </p>
        </div>


<!-- TO DO: Confirm page -->

        <!-- Buttons -->
        <div class="centerText col-12">
            <a href="../index.php" class="btn btn-dark">Return</a>
        </div>
    </div>
</div>

</body>
</html>