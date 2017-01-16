<?php

class DBInfo
{
  //public static $DB_CONNECTION_STRING_OLD="mysql:dbname=wt_creda;host=localhost;charset=utf8;";
//  public static $USERNAME_OLD="korisnik";
//  public static $PASSWORD_OLD="korisnik";



  //public static $DB_CONNECTION_STRING="mysql:host=localhost;port=1312;dbname=wt_creda";
  public static $USERNAME="creda";
  public static $PASSWORD="asvordpanjo";

  public static function getMesssageForErrorCode($errCode){
    if($errCode==1){
      return "Database error: Row already exists.";
    }
    else if($errCode==2){
      return "Database error: Row doesn't exist.";
    }
    else if($errCode==3){
      return "Database error.";
    }
  }
  public static function DB_CONNECTION_STRING(){
    $env= getenv('MYSQL_SERVICE_HOST');
    $DB_CONNECTION_STRING="mysql:host="  . $env . ";port=3306;dbname=flightsdb";
    return $DB_CONNECTION_STRING;
  }
}

 ?>
