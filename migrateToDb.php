<?php

require "Flight.php";
require "validation.php";

try {
    $xml_flights=simplexml_load_file("data/xml/flights.xml");
    $xml_users=simplexml_load_file("data/xml/xml_account");

    $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME, DBInfo::$PASSWORD);
    $connection->exec("set names utf8");

    $cities=$connection->query("select * from city");
    $arrCities=[];
    foreach($cities->fetchAll() as $city){
      $arrCities[]=$city["id"];
    }

    $citiesCount=$connection->query("select count(*) from city")->fetchColumn();
    $usersCount=$connection->query("select count(*) from user")->fetchColumn();
    $flightsCount=$connection->query("select count(*) from flight")->fetchColumn();

    if($citiesCount!=0){
      $stmt=$connection->prepare("insert into user set first_name=:fn,
                        last_name=:ln, email=:mail, username=:uname, password=md5(:pw), city_id=:city;");

      $stmt->bindParam(':fn', $firstName);
      $stmt->bindParam(':ln', $lastName);
      $stmt->bindParam(':mail', $email);
      $stmt->bindParam(':uname', $username);
      $stmt->bindParam(':pw', $password);
      $stmt->bindParam(':city', $cityId, PDO::PARAM_INT);

      $counter=0;
      foreach($xml_users->children() as $user){

          $prep=$connection->prepare("select count(*) from user where username=?");
          $prep->bindValue(1, $user->username);
          $prep->execute();
          if($prep->fetchColumn()==0){
            $firstName=$user->firstName;
            $lastName=$user->lastName;
            $email=$user->email;
            $username=$user->username;
            $password=$user->password;

            $tmp=$connection->prepare("select id from city where name=? ");
            $tmp->bindValue(1, $user->city);
            $tmp->execute();
            $cityId=$tmp->fetchColumn();
            $stmt->execute();
          }

          $counter++;
        }
    }

    if($citiesCount!=0){
      $stmt=$connection->prepare("insert into flight set id=:id, from_city=:fc,
                        to_city=:tc, date=:dat, duration=:dur, cost=:cos;");

      $stmt->bindParam(':id', $flightId, PDO::PARAM_INT);
      $stmt->bindParam(':fc', $fromCity, PDO::PARAM_INT);
      $stmt->bindParam(':tc', $toCity, PDO::PARAM_INT);
      $stmt->bindParam(':dat', $date);
      $stmt->bindParam(':dur', $duration, PDO::PARAM_INT);
      $stmt->bindParam(':cos', $cost, PDO::PARAM_INT);

      $counter=0;
      foreach($xml_flights->children() as $flight){
        echo  $flight->from ;
        $prep=$connection->prepare("select count(*) from flight where id=?");
        $prep->bindValue(1, $flight->id);
        $prep->execute();
        if($prep->fetchColumn()==0){
          $flightId=$flight->id;
          $date=$flight->date;
          $duration=$flight->duration;
          $cost=$flight->cost;

        $tmp=$connection->prepare("select id from city where name=? ");
        $tmp->bindValue(1, $flight->from);
        $tmp->execute();
        $fromCity=$tmp->fetchColumn();

        $tmp=$connection->prepare("select id from city where name=? ");
        $tmp->bindValue(1, $flight->to);
        $tmp->execute();
        $toCity=$tmp->fetchColumn();

          $stmt->execute();
        }

          $counter++;
        }
    }
    header("Location: index.php?succ=1");

} catch (PDOException $e) {
  header("Location: index.php?succ=0");

}
catch (Exception $e) {
  header("Location: index.php?succ=0");

}


$connection=null;
function validateInput($data){
    return preventXSS($data);
}
 ?>
