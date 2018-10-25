<?php
	session_start();
    
    //Takes the posted variables, removes the unwanted part and saves the names
	foreach($_POST as $key => $value){
		if(strpos($key, 'Amount')){
			$names[] .= str_replace("Amount", "", $key);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nice shop™</title>

    <!-- CSS links for Font Awesome, Bootstrap and my own stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Nice shop™</a>
    </nav>
</header>

<?php
    //Checks for empty fields and redirects an error
    if(empty($_POST["customerName"])){
        header('Location: index.php?error=Name field required');
    }
    elseif(empty($_POST["customerPhone"])){
        header('Location: index.php?error=Phone field required');
    }
    elseif(empty($_POST["customerAddress"])){
        header('Location: index.php?error=Address field required');
    }
    elseif(empty($_POST["customerEmail"])){
        header('Location: index.php?error=E-mail field required');
    }
    
    else{?>
        <p class="bigP box">Hej <?=$_POST["customerName"]?>!</p>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 centerText">
                    <p class="bigP">Varukorg</p>

                    <?php $totalPrice = 0;					
                    
                    //Loops through a list of the selected articles and writes out the order
					foreach($names as $name){
						if(is_numeric($_POST[$name."Amount"]) && $_POST[$name."Amount"] >= 1){?>
							<p> 
                                <!-- Example: Kotte, XX st - XX kr (XX kr/st) -->
								<?=$name.", ".$_POST[$name."Amount"]." st - ".($_POST[$name."Amount"]*$_POST[$name."Price"])." kr<br>(".$_POST[$name."Price"]." st)"?> 
							</p>
                        <?php
                        //Adds the price to the total
                         $totalPrice += ($_POST[$name."Amount"]*$_POST[$name."Price"]);
						}
					}
                    
                    // Writes if a discount applies on the current weekday
					if(date(D) === "Mon"){
						echo "<p class='discountText'>Måndagsrabatt! (-50%)</p>";
					}
					elseif(date(D) === "Wed"){
						echo "<p class='discountText'>Onsdagspriser (+10%)</p>";
					}
					elseif(date(D) === "Fri"){
						echo "<p class='discountText'>Fredagsrabatt! (-20kr på allt över 200kr)</p>";
					}

                    echo "<p>Totalt: ".$totalPrice." kr</p>";
                }?>
                </div>
				<div class="col-12 d-block d-md-none"><hr></div>
                
                <!-- Customer info from the form -->
                <div class="col-12 col-md-6">
                    <p class="bigP">Beställning till</p>
                    <p class="centerText">
                        <?=
                        $_POST["customerName"]."<br>".
                        $_POST["customerAddress"]."<br>".
                        $_POST["customerPhone"]."<br>".
                        $_POST["customerEmail"]."<br>"
                        ?>
                    </p>
                </div>

                <!-- Buttons -->
				<div class="centerText col-12">
					<a href="index.php" class="btn btn-dark">Return</a>
				</div>
            </div>
        </div>
        

<!-- Bootstrap scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>