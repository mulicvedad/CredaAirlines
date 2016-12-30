<?php
$_POST = array(); //workaround for broken PHPstorm
parse_str(file_get_contents('php://input'), $_POST);

include "Account.php";
include "Flight.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username=validateInput($_POST["login-username"]);
    $password=validateInput($_POST["login-password"]);

    $adminXml = simplexml_load_file("admin.xml");

    foreach ($adminXml->children() as $admin){

        if($admin->username == $username && $admin->password == $password){
            session_start();
            $_SESSION["username"]="admin";

        }
    }
    echo "<script>window.location.href = 'MainPage.php'</script>";
}


function validateInput($data){
    return $data;
}
