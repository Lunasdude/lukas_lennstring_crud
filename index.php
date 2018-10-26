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
    </nav>
</header>

<div class="container">
    <?php 
        if(isset($_SESSION["username"])){ ?>
            <h2 style="text-align:center">Hej <?=$_SESSION["username"]?>!</h2>
            <a href="includes/logout.php" style="width:100px;display:block" class="btn btn-danger mt-1 mx-auto">Log out</a>


        <?php }
        else{ ?>
            <a href="views/login.php" style="width:100px;display:block" class="btn btn-dark mt-1 mx-auto">Log in</a>

            
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
                    <form action="views/checkout.php" method="POST">
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

</body>
</html>