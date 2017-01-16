<?php
require "Account.php";
require "validation.php";

if(isset($_POST["user"])){
  $username=preventXSS($_POST["user"]);
  $acc = new Account("", "", "", $username, "", "");
  $status=$acc->deleteFromDb();
  if($status!=0){
    echo '<script>';
    echo 'alert("'. DBInfo::getMesssageForErrorCode($status) . '");';
    echo "window.location.href = 'register.php';";

    echo '</script>';
  }
  else{
    echo '<script>';
    echo 'alert("User successfullt deleted.");';
    echo "window.location.href = 'register.php';";

    echo '</script>';

  }
    exit();
}

 ?>
