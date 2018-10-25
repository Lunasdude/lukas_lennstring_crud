<?php

    include("includes/head.php");

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
    <a href="views/login.php" style="width:100px;display:block" class="btn btn-dark mt-1 mx-auto">Log in</a>
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
                    <!-- Sends the amount and the new price to the checkout form -->
                    <input form="checkoutForm" type="text" class="centerText" name="<?=$article["name"]?>Amount" placeholder="Antal"/>
                    <input form="checkoutForm" type="hidden" name="<?=$article["name"]?>Price" placeholder="Antal"
					value="<?=$newPrice?>"/>
                    <input class="mt-1" form="checkoutForm" type="submit" value="Add to cart">
                </div>
            </div>
        <?php 
        } ?>
    </div>
</div>

</body>
</html>