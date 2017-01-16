<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Creda Airlines</title>
    <link rel="stylesheet" href="SharedStyles.css">
    <link rel="stylesheet" href="flights.css">
    <script src="flights.js"></script>
    <script src="main.js"></script>
    <script src="register.js"></script>
    <script src="about.js"></script>
</head>

<body onload="mainPageLoad(1)">

<?php


require "Flight.php";
require "validation.php";

$dateError=$durationError=$costError="";

if(isset($_REQUEST["Add"])) {

    if ($_REQUEST["Add"] == "Add") {
        $from = preventXSS($_REQUEST["from"]);
        $to = preventXSS($_REQUEST["to"]);
        $date = preventXSS($_REQUEST["date"]);
        $duration = preventXSS($_REQUEST["duration"]);
        $cost = preventXSS($_REQUEST["cost"]);
        $isValid=true;
        if(!isDateValid($date)){
          $dateError="You entered incorrect value for date! <br>";
          $isValid=false;
        }
        if(!isPositiveNumber($duration)){
          $durationError="You entered incorrect value for duration! <br>";
          $isValid=false;
        }
        if(!isPositiveNumber($cost)){
          $durationError="You entered incorrect value for cost! <br>";
          $isValid=false;
        }
        if($isValid){
          $newFlight = new Flight(-1,$from, $to, $date, $duration, $cost);
          $status=$newFlight->saveToDb();
          if($status!=0){
            $dbError=DBInfo::getMesssageForErrorCode($status);
          }
        }


    }
}
else{
  try{
      $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME,DBInfo::$PASSWORD);
      $connection->exec("set names utf8");
      if($flights=$connection->query("select * from flight")){
          if($connection->query("select count(*) from flight")->fetchColumn()){

              $results=$flights->fetchAll();
              $rowIndex=0;
              foreach($results as $flight){
                $key="option_" . $rowIndex;
                  $isValid=true;
                if(isset($_REQUEST[$key])){

                    if($_REQUEST[$key] == "Edit") {
                        break;
                    }
                    if($_REQUEST[$key] == "Save"){

                      $from = preventXSS($_REQUEST["editFrom"]);
                      $to = preventXSS($_REQUEST["editTo"]);
                      $date = preventXSS($_REQUEST["editDate"]);
                      $duration = preventXSS($_REQUEST["editDuration"]);
                      $cost = preventXSS($_REQUEST["editCost"]);

                      if(!isDateValid($date)){
                        $dateError="You entered incorrect value for date! <br>";
                        $isValid=false;
                      }
                      if(!isPositiveNumber($duration)){
                        $durationError="You entered incorrect value for duration! <br>";
                        $isValid=false;
                      }
                      if(!isPositiveNumber($cost)){
                        $durationError="You entered incorrect value for cost! <br>";
                        $isValid=false;
                      }
                      if($isValid){
                        $newFlight = new Flight($flight["id"],$from, $to, $date, $duration, $cost);
                        $status=$newFlight->updateDb();
                        if($status!=0){
                          $dbError=DBInfo::getMesssageForErrorCode($status);
                        }
                      }
                      else{
                        echo '<script>';
                        echo "alert('One of the values is not correct.');";
                        echo "window.location.href = 'flights.php';";

                        echo '</script>';
                        exit();
                      }

                    }
                    else if($_REQUEST[$key] == "Delete"){


                      $newFlight = new Flight($flight["id"], $flight["from_city"],$flight["date"], $flight["to_city"],
                        $flight["duration"],   $flight["cost"]);
                      $status=$newFlight->deleteFromDb();
                      if($status!=0){
                        $dbError=DBInfo::getMesssageForErrorCode($status);
                      }
                    }

                    header("Location: flights.php");
                    break;
                }


                $rowIndex++;

          }
        }
          else{
              echo "No flights Found.";
          }
      }
      else{
          echo "Error reading database.";
      }



   }
   catch(PDOException $e){
       die($e->errorInfo());
   }
}


function validateInput($data){
    return preventXSS($data);
}
?>
<div class="headerContainer">
    <div class="pageHeader">
        <div class="header top">
            <p id="titleText">
                Creda Airlines
            </p>
        </div>
        <div class="header search">

        </div>
        <div class="header bottom">
            <ul class="nav">
                <li><a href="index.php">HOME</a> </li>
                <li><a onclick="navigationItemClicked(1)" href="flights.php">FLIGHTS</a> </li>
                <li><a href="index.php">MAKE A RESERVATION</a></li>
                <li><a onclick="navigationItemClicked(3)" href="About.html">ABOUT US</a> </li>
                <li><a onclick="navigationItemClicked(4)" href="Contact.html">CONTACT</a> </li>
                <li><a onclick="navigationItemClicked(5)" href="register.php">REGISTER</a> </li>
            </ul>
            <div class="dropdown">
                <span onclick="dropDownClicked(this)">Menu</span>
                <div id="dropdownContent" class="dropdown-content">
                    <li class="dropdown-item"><a href="index.php">Home</a> </li>
                    <li class="dropdown-item"><a href='flights.php'>Flights</a> </li>
                    <li class="dropdown-item"><a href="index.php">Make a reservation</a></li>
                    <li class="dropdown-item"><a href="About.html">About us</a> </li>
                    <li class="dropdown-item"><a href="Contact.html">Contact</a> </li>
                    <li class="dropdown-item"><a href="register.php">Register</a> </li>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row main">
    <div class="column eight">
        <?echo $_SERVER['PHP_SELF']?>
        <form >
            <table id="flights-table">
                <tr>
                    <th>FROM</th>
                    <th>TO</th>
                    <th>DATE / TIME</th>
                    <th>DURATION</th>
                    <th>COST</th>

                </tr>

                <?php

                session_start();


                $isAdmin=false;
                $isEditMode=false;
                if(isset($_SESSION["username"])){
                    if($_SESSION["username"] == "admin"){
                        $isAdmin=true;
                    }
                }
                $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME,DBInfo::$PASSWORD);
                $connection->exec("set names utf8");
                $flights=$connection->query("select * from flight");
                $results=$flights->fetchAll();
                $rowIndex=0;
                foreach ($results as $flight){
                    $key="option_" . $rowIndex;
                    if(isset($_REQUEST[$key])){
                        if($_REQUEST[$key] == "Edit"){
                            $isEditMode=true;
                            echo "<tr>";
                            //echo "<td><input  type='text' value='". $flight->from ."' name='editFrom'></td>";
                            //echo "<td><input  type='text' value='". $flight->to ."' name='editTo'></td>";
                             try{
                             //$connection = new PDO("mysql:dbname=wt_creda;host=localhost;charset=utf8;port=1312", "korisnik", "korisnik");
                             //$connection->exec("set names utf8");
                           if($cities=$connection->query("select * from city")){
                               if($connection->query("select count(*) from city")->fetchColumn()){
                                   $results=$cities->fetchAll();
                                   echo "<td><select name='editFrom'>";
                                   foreach($results as $city){
                                        echo "<option value=". $city["name"] . ">" . $city["name"]  . "</option>";
                                   }
                                   echo "</td></select>";
                                   echo "<td><select name='editTo'>";
                                   foreach($results as $city){
                                        echo "<option value=". $city["name"] . ">" . $city["name"]  . "</option>";
                                   }
                                   echo "</td></select>";
                               }
                               else{
                                   echo "No Cities Found.";
                               }
                           }
                           else{
                               echo "Error reading database.";
                           }

                        }
                        catch(PDOException $e){
                            die($e->errorInfo());
                        }
                            echo "<td><input  type='datetime' value='". $flight["date"] ."' name='editDate'></td>";
                            echo "<td><input  type='number' value='". $flight["duration"] ."' name='editDuration'></td>";
                            echo "<td><input  type='number' value='". $flight["cost"] ."' name='editCost'></td>";
                            echo "<td><input style='background-color: darkred'  type='submit' value='Save' name='option_" . $rowIndex . "'></td>";
                            echo "</tr>";
                        }

                    }
                    else{
                        $fromCityName=$connection->query("select name from city where id= " . $flight["from_city"] )->fetchColumn();
                        $toCityName=$connection->query("select name from city where id= " . $flight["to_city"] )->fetchColumn();
                        echo "<tr>";
                        echo "<td>" . $fromCityName . "</td>";
                        echo "<td>" .  $toCityName. "</td>";
                        echo "<td>" .  $flight["date"]  . "</td>";
                        echo "<td>" .  $flight["duration"]  . "</td>";
                        echo "<td>" . $flight["cost"] . "</td>";
                        if($isAdmin){
                            echo "<td><input  type='submit' value='Edit' name='option_" . $rowIndex . "'></td>";
                            echo "<td><input style='background-color: darkred' type='submit' value='Delete' name='option_" . $rowIndex . "'></td>";
                        }

                        echo "</tr>";
                    }


                    $rowIndex++;
                }

                if($isAdmin && !$isEditMode){
                    echo "<tr>";
                   // echo "<td><input type='text' name='from' placeholder='City 1'></td>";
                   // echo "<td><input type='text' name='to' placeholder='City 2'></td>";
                   try{
                             $connection = new PDO("mysql:dbname=wt_creda;host=localhost;charset=utf8;port=1312", "korisnik", "korisnik");
                             $connection->exec("set names utf8");
                           if($cities=$connection->query("select * from city")){
                               if($connection->query("select count(*) from city")->fetchColumn()){

                                   $results=$cities->fetchAll();
                                   echo "<td><select name='from'>";
                                   foreach($results as $city){
                                        echo "<option value=". $city["name"] . ">" . $city["name"]  . "</option>";
                                   }
                                   echo "</td></select>";
                                   echo "<td><select name='to'>";
                                   foreach($results as $city){
                                        echo "<option value=". $city["name"] . ">" . $city["name"]  . "</option>";
                                   }
                                   echo "</td></select>";
                               }
                               else{
                                   echo "No Cities Found.";
                               }
                           }
                           else{
                               echo "Error reading database.";
                           }

                        }
                        catch(PDOException $e){
                            die($e->errorInfo());
                        }
                    echo "<td><input type='text' name='date' placeholder='dd/mm/yyyy hh:mm'></td>";
                    echo "<td><input type='number' name='duration'></td>";
                    echo "<td><input type='number' name='cost'></td>";
                    echo "<td><input style='background-color: darkgreen' name='Add' type='submit' value='Add'></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </form>

    </div>
</div>
<div class="row">
    <div class="column twelve error-log" id="errorDiv" style="color:red">
        <?php
        echo $dateError;
        echo $durationError;
        echo $costError;
        ?>
    </div>
</div>
</body>
