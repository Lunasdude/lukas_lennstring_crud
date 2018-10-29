<?php include("../includes/head.php");
/**
 * 1. Koppla upp till databasen
 * 2. Hämta användaren från databasen
 * 3. Kolla så att lösenordet i databasen stämmer överens med lösenordet som användaren har skrivit in i formuläret: password_verify
 */
include("../includes/database_connection.php");

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