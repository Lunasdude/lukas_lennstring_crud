<?php include("../includes/head.php");
/**
 * 1. Koppla upp till databasen
 * 2. Hämta användaren från databasen
 * 3. Kolla så att lösenordet i databasen stämmer överens med lösenordet som användaren har skrivit in i formuläret: password_verify
 */
include("../includes/database_connection.php");
?>
<div class="col-12">
    <h2 style="text-align:center">Log in:</h2>
    <form action="login.php" method="POST">
        <label for="login_username">Username</label>
        <input type="text" name="username" id="login_username"> <br>
        <label for="login_password">Password</label>
        <input type="password" name="password" id="login_password"> <br>
        <input type="submit" value="Log in">
    </form>
</div>
<hr>
<div class="col-12">
    <h2 style="text-align:center">New? Register:</h2>
    <form action="../includes/register.php" method="POST">
        <label for="register_username">Username</label>
        <input type="text" name="username" id="register_username"> <br>
        <label for="register_password">Password</label>
        <input type="password" name="password" id="register_password"> <br>
        <input type="submit" value="Register">
    </form>
</div>
<?php 
$username = $_POST["username"];
$password = $_POST["password"];
//Does not get the password because we can't! It's encrypted!
$statement = $pdo->prepare("SELECT * FROM customer WHERE username = :username");
//Execute populates the statement and runs it
$statement->execute(
    [
        ":username" => $username
    ]
);
//When select is used, fetch must happen
$fetched_user = $statement->fetch();

//3. compare
$is_password_correct = password_verify($password,$fetched_user["password"]);
if($is_password_correct){
    //Save user globally to session
    $_SESSION["username"] = $fetched_user["username"];
    header('Location: ../index.php');

}else{
    //Handle errors
    
}