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
    <?php 
        if(isset($_SESSION["username"])){ ?>
            <h2 style="text-align:center;float:left">Hej <?=$_SESSION["username"]?>!</h2>
            <a href="includes/logout.php" style="width:100px;display:block;float:right;" class="btn btn-danger mt-1 mx-auto">Log out</a>
        <?php }
        else{ ?>
        <div class="row">
            <div class="col-6">
                <h2 style="text-align:center">Log in:</h2>
                <form action="includes/login.php" method="POST">
                    <label for="login_username">Username</label>
                    <input type="text" name="username" id="login_username"> <br>
                    <label for="login_password">Password</label>
                    <input type="password" name="password" id="login_password"> <br>
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
                    <input type="submit" class="btn btn-dark" value="Register">
                </form>
            </div>
        </div>
    <?php }
    ?>

    <?php
    // Writes if a discount applies on the current weekday
	if(date(D) === "Mon"){
		echo "<p class='bigP'>Måndagsrabatt! (-50%)</p>";
	}
	elseif(date(D) === "Wed"){
		echo "<p class='bigP'>Onsdagspriser (+10%)</p>";
	}
	elseif(date(D) === "Fri"){
		echo "<p class='bigP'>Fredagsrabatt! (-20kr på allt över 200kr)</p>";
	}
	?>
    <div class="row box">
        <?php
        foreach($stock as $article){ 
            //Applies discounts
            if(date(D) === "Mon"){
                $newPrice = $article["price"] * 0.5;
            }
            elseif(date(D) === "Wed"){
                $newPrice = $article["price"] * 1.1;
            }
            elseif(date(D) === "Fri" && $article["price"] > 200){
                $newPrice = $article["price"] - 20;
            }
            else{
                $newPrice = $article["price"];
            }
            ?>
            <div class="card col-6 col-md-4 col-xl-3">
                <img class="card-img-top" src="<?=$article['image']?>" alt="<?=$article['name']?>">
                <div class="card-body centerText">
					<h3 class="card-text"><?=$article["name"]?></h3>
					<p class="card-text"><?=$newPrice?> kr/st</p>
                    <form action="includes/add-to-cart.php" method="POST">
                        <input type="number" class="centerText" name="<?=$article["name"]?>Amount" value="0"/>
                        <input type="hidden" name="<?=$article["name"]?>Price" value="<?=$newPrice?>"/>
                        <input class="mt-1" type="submit" value="Add to cart">
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