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
require "City.php";
require "validation.php";

$nameError=$citizensError=$dbError="";

if(isset($_REQUEST["Add"])) {

    if ($_REQUEST["Add"] == "Add") {
        $name = preventXSS($_REQUEST["editName"]);
        $numberOfCitizens = preventXSS($_REQUEST["editNumCitizens"]);
        $isValid=true;

        if(!isCityNameValid($name)){
          $nameError="You entered incorrect value for city name! <br>";
          $isValid=false;
        }
        if(!isPositiveNumber($numberOfCitizens)){
          $citizensError="You entered incorrect value for number of citizens! <br>";
          $isValid=false;
        }
        if($isValid){
          $newCity = new City(-1,$name, intval($numberOfCitizens));
          $status=$newCity->saveToDb();
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
          if($cities=$connection->query("select * from city")){
              if($connection->query("select count(*) from city")->fetchColumn()){

                  $results=$cities->fetchAll();
                  $rowIndex=0;
                  foreach($results as $city){
                    $key="option_" . $rowIndex;
                      $isValid=true;
                    if(isset($_REQUEST[$key])){

                        if($_REQUEST[$key] == "Edit") {
                            break;
                        }
                        if($_REQUEST[$key] == "Save"){
                          $name = preventXSS($_REQUEST["editName"]);
                          $numberOfCitizens = preventXSS($_REQUEST["editNumCitizens"]);

                          if(!isCityNameValid($name)){
                            $nameError="You entered incorrect value for city name! <br>";
                            $isValid=false;
                          }
                          if(!isPositiveNumber($numberOfCitizens)){
                            $citizensError="You entered incorrect value for number of citizens! <br>";
                            $isValid=false;
                          }
                          if($isValid){
                            $newCity = new City(intval($city["id"]),$name, intval($numberOfCitizens));
                            $status=$newCity->updateDb();
                            if($status!=0){
                              $dbError=DBInfo::getMesssageForErrorCode($status);
                            }
                          }
                          else{
                            echo '<script>';
                            echo "alert('One of the values is not correct.');";
                            echo "window.location.href = 'cities.php';";

                            echo '</script>';
                            exit();
                          }

                        }
                        else if($_REQUEST[$key] == "Delete"){
                          $newCity=new City($city["id"],$city["name"], intval($city["number_of_citizens"]));
                          $status=$newCity->deleteFromDb();
                          if($status!=0){
                            $dbError=DBInfo::getMesssageForErrorCode($status);
                          }
                        }

                    header("Location: cities.php");


                        break;
                    }


                    $rowIndex++;

              }
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

}

$connection=null;
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
                <li><a onclick="navigationItemClicked(5)" href="Register.php">REGISTER</a> </li>
            </ul>
            <div class="dropdown">
                <span onclick="dropDownClicked(this)">Menu</span>
                <div id="dropdownContent" class="dropdown-content">
                    <li class="dropdown-item"><a href="index.php">Home</a> </li>
                    <li class="dropdown-item"><a href='flights.php'>Flights</a> </li>
                    <li class="dropdown-item"><a href="index.php">Make a reservation</a></li>
                    <li class="dropdown-item"><a href="About.html">About us</a> </li>
                    <li class="dropdown-item"><a href="Contact.html">Contact</a> </li>
                    <li class="dropdown-item"><a href="Register.php">Register</a> </li>
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
                    <th>CITY NAME</th>
                    <th>NUMBER OF CITIZENS</th>

                </tr>

                <?php


               $isEditMode=false;
                $isAdmin=true;

                try{
                    $connection = new PDO(DBInfo::$DB_CONNECTION_STRING, DBInfo::$USERNAME,DBInfo::$PASSWORD);
                    $connection->exec("set names utf8");
                        if($cities=$connection->query("select * from city")){
                            if($connection->query("select count(*) from city")->fetchColumn()){

                                $results=$cities->fetchAll();
                                $rowIndex=0;
                                foreach($results as $city){
                                  $key="option_" . $rowIndex;
                                  if(isset($_REQUEST[$key])){
                                      if($_REQUEST[$key] == "Edit"){
                                          $isEditMode=true;
                                          echo "<tr>";
                                          echo "<td><input  type='text' value='". $city["name"] ."' name='editName'></td>";
                                          echo "<td><input  type='text' value='". $city["number_of_citizens"]  ."' name='editNumCitizens'></td>";
                                          echo "<td><input style='background-color: darkred'  type='submit' value='Save' name='option_" . $rowIndex . "'></td>";
                                          echo "</tr>";
                                      }

                                  }
                                  else{
                                      echo "<tr>";
                                      echo "<td>" .  $city["name"] . "</td>";
                                      echo "<td>" . $city["number_of_citizens"] . "</td>";
                                      if($isAdmin){
                                          echo "<td><input  type='submit' value='Edit' name='option_" . $rowIndex . "'></td>";
                                          echo "<td><input style='background-color: darkred' type='submit' value='Delete' name='option_" . $rowIndex . "'></td>";
                                      }

                                      echo "</tr>";
                                  }


                                  $rowIndex++;
                                }

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


                if($isAdmin && !$isEditMode){
                    echo "<tr>";
                    echo "<td><input type='text' name='editName'></td>";
                    echo "<td><input type='text' name='editNumCitizens'></td>";
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
        echo $nameError;
        echo $citizensError;
        echo $dbError;
        ?>
    </div>
</div>

</body>
