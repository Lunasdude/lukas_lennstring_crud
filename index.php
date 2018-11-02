<?php
    session_start();

/**
 * JOIN products
 * ON products.product_id
 * = cart.product_id
 */
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nice shop™</title>

    <!-- CSS links for Font Awesome, Bootstrap and my own stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<?php
    //Data about the articles
    include("includes/stock.php");
    include("includes/database_connection.php");
?>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Nice shop™</a>

        <?php 
        if(isset($_SESSION["username"])){ ?>
        <div class="dropdown dropleft">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-shopping-cart"></i></button>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <span class="dropdown-item-text">
                    Thingy Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore dolor iure saepe officiis delectus id quas maxime vitae veritatis optio, cum, voluptatum odio suscipit. Qui, nisi unde. Ratione, blanditiis accusantium?
                </span>
                <a href="views/checkout.php" class="btn btn-info mx-auto checkoutBtn">Checkout</a>
            </div>    
        </div>
        
        <?php }
    ?>
    </nav>
</header>

<div class="container">
    <div class="row">
    <?php 
        if(isset($_SESSION["username"])){ ?>
            <h2 style="text-align:center;float:left" class="col-6">Hej <?=$_SESSION["username"]?>!</h2>
            <a href="includes/logout.php" style="width:100px;display:block;" class="btn btn-danger mt-1 mx-auto">Log out</a>
        <?php }
        else{ ?>
            <div class="col-6">
                <h2 style="text-align:center">Log in:</h2>
                <form action="includes/login.php" method="POST">
                    <label for="login_username">Username</label>
                    <input type="text" name="username" id="login_username"> <br>
                    <label for="login_password">Password</label>
                    <input type="password" name="password" id="login_password"> <br>
                    <h4 style="color:red;"><?=substr_replace($_GET["error"], ' ', 5, 1)?></h4>
                    <input type="submit" class="btn btn-dark" value="Log in">
                </form>
            </div>
            <hr>
            <div class="col-6">
                <h2 style="text-align:center">New? Register:</h2>
                <form action="includes/register.php" method="POST">
                    <label for="register_username">Username</label>
                    <input type="text" name="username" id="register_username"> <br>
                    <label for="register_password">Password</label>
                    <input type="password" name="password" id="register_password"> <br>
                    <h4 style="color:red;"><?=substr_replace($_GET["registration_error"], ' ', 4, 1)?></h4>
                    <input type="submit" class="btn btn-dark" value="Register">
                </form>
            </div>
    <?php } ?>
    </div>
    <div class="row box">
        <?php
        // Writes if a discount applies on the current weekday
        if(true){
            echo "<p class='bigP col-12'>Måndagsrabatt! (-50%)</p>";
        }
        elseif(date(D) === "Wed"){
            echo "<p class='bigP col-12'>Onsdagspriser (+10%)</p>";
        }
        elseif(date(D) === "Fri"){
            echo "<p class='bigP col-12'>Fredagsrabatt! (-20kr på allt över 200kr)</p>";
        }

        $statement = $pdo->prepare("SELECT * FROM products");
        //Execute populates the statement and runs it
        $statement->execute();
        //When select is used, fetch must happen
        $fetched_stock = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($fetched_stock as $product){ 
            //Applies discounts
            if(date(D) === "Mon"){
                $newPrice = $product["price"] * 0.5;
            }
            elseif(date(D) === "Wed"){
                $newPrice = $product["price"] * 1.1;
            }
            elseif(date(D) === "Fri" && $product["price"] > 200){
                $newPrice = $product["price"] - 20;
            }
            else{
                $newPrice = $product["price"];
            }
            ?>
            <div class="card col-6 col-md-4 col-xl-3">
                <img class="card-img-top" src="images/<?=$product['image']?>" alt="<?=$product['product_name']?>">
                <div class="card-body centerText">
					<h3 class="card-text"><?=$product["product_name"]?></h3>
					<p class="card-text"><?=$newPrice?> kr/st</p>
                    <form action="includes/add-to-cart.php" method="POST">
                        <input type="number" class="centerText" name="product_amount"/>
                        <input type="hidden" name="product_id" value="<?=$product["product_id"]?>"/>
                        <input class="btn mt-1" type="submit" name="submit" value="Add to cart">
                    </form>
                </div>
            </div>
        <?php 
        } ?>
    </div>
</div>

<!-- Bootstrap scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>