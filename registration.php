<?php
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

include "Account.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $firstName=validateInput($_POST["registerFirstName"]);
    $lastName=validateInput($_POST["registerLastName"]);
    $email=validateInput($_POST["registerEmail"]);
    $username=validateInput($_POST["registerUsername"]);

    $account=new Account($firstName, $lastName, $email, $username);
    $account->serialize();
    header("Location: Register.php");
}



function validateInput($data){
    $GLOBALS["error"]="error";
    return htmlspecialchars($data);
}
?>