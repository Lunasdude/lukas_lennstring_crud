<?php
    session_start();
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
    $stock = [ 
        [
            "name" => "Kotte",
            "price" => 80,
            "image" => "images/pinecone.png"
        ],
        [
            "name" => "Stubbe",
            "price" => 890,
            "image" => "images/stump.png"
        ],
        [
            "name" => "Däck",
            "price" => 500,
            "image" => "images/tire.png"
        ],
        [
            "name" => "Sten",
            "price" => 200,
            "image" => "images/rock.jpg"
        ],
        [
            "name" => "Durkplåt",
            "price" => 300,
            "image" => "images/metal.jpg"
        ],
        [
            "name" => "Bromsskiva",
            "price" => 379,
            "image" => "images/scrap.jpg"
        ]
    ];
?>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Nice shop™</a>
    </nav>
</header>
<div class="container">
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
					<p class="card-text"><?=$article["name"]?></p>
					<p class="card-text"><?=$newPrice?> kr/st</p>
                    <!-- Sends the amount and the new price to the checkout form -->
                    <input form="checkoutForm" type="text" class="centerText" name="<?=$article["name"]?>Amount" placeholder="Antal"/>
                    <input form="checkoutForm" type="hidden" name="<?=$article["name"]?>Price" placeholder="Antal"
					value="<?=$newPrice?>"/>
                </div>
            </div>
        <?php 
        } ?>
    </div>
    <div class="box">
        <!-- Checkout form for customer info -->
        <form id="checkoutForm" action="views/checkout.php" method="POST">
            <label for="customerName">Namn</label>
            <input class="field" type="text" name="customerName"/>
            <br>
            <label for="customerAdress">Adress</label>
            <input class="field" type="text" name="customerAddress"/>
            <br>
            <label for="customerPhone">Telefon</label>
            <input class="field" type="text" name="customerPhone"/>
            <br>
            <label for="customerEmail">E-Mail</label>
            <input class="field" type="text" name="customerEmail"/>
            <br>
            <!-- Displays potential form errors -->
            <h3 style="color:red"><?=$_GET["error"]?></h3>
            <input type="submit" value="Skicka" class="btn btn-dark"/>
        </form>
    </div>
</div>

<!-- Bootstrap scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>