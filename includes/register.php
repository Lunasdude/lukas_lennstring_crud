<?php

include("database_connection.php");

if(empty($_POST["username"])){
    header('Location: ../index.php?registration_error=Fill username');
}elseif(empty($_POST["password"])){
    header('Location: ../index.php?registration_error=Fill password');
}else{
    $username = $_POST["username"];
    $password = $_POST["password"];
    //Password hashed with PASSWORD_DEFAULT uses the best avalible method
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $statement = $pdo->prepare("INSERT INTO customer(username, password) VALUES (:username, :password)");
    //Execute populates the statement and runs it
    $statement->execute(
        [
            ":username" => $username,
            ":password" => $hashed_password
        ]
    );
}