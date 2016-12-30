<?php

$_SESSION["username"]="vehid";
session_start();
session_destroy();
echo "<script> alert('tuj sam''); </script>";
header("Location: MainPage.php");
