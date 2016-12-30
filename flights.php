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

$xml=simplexml_load_file("data/xml/flights.xml");
if(isset($_REQUEST["Add"])) {

    if ($_REQUEST["Add"] == "Add") {
        $from = validateInput($_REQUEST["from"]);
        $to = validateInput($_REQUEST["to"]);
        $date = validateInput($_REQUEST["date"]);
        $duration = validateInput($_REQUEST["duration"]);
        $cost = validateInput($_REQUEST["cost"]);

        $newFlight = new Flight($from, $to, $date, $duration, $cost);
        $newFlight->serialize();

    }
}
else{
    $rowIndex=0;
    foreach ($xml->children() as $flight){
        $key="option_" . $rowIndex;
        if(isset($_REQUEST[$key])){

            if($_REQUEST[$key] == "Edit") {
                break;
            }
            if($_REQUEST[$key] == "Save"){
                $from=validateInput($_REQUEST["editFrom"]);
                $to=validateInput($_REQUEST["editTo"]);
                $date=validateInput($_REQUEST["editDate"]);
                $duration=validateInput($_REQUEST["editDuration"]);
                $cost=validateInput($_REQUEST["editCost"]);

                $flight->from=$from;
                $flight->to=$to;
                $flight->date=$date;
                $flight->duration=$duration;
                $flight->cost=$cost;

            }
            else if($_REQUEST[$key] == "Delete"){
                unset($xml->flight[$rowIndex]);

            }


            header("Location: flights.php");
            $xml->asXML("data/xml/flights.xml");
            break;
        }


        $rowIndex++;
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
                <li><a href="MainPage.php">HOME</a> </li>
                <li><a onclick="navigationItemClicked(1)" href="flights.php">FLIGHTS</a> </li>
                <li><a href="MainPage.php">MAKE A RESERVATION</a></li>
                <li><a onclick="navigationItemClicked(3)" href="About.html">ABOUT US</a> </li>
                <li><a onclick="navigationItemClicked(4)" href="Contact.html">CONTACT</a> </li>
                <li><a onclick="navigationItemClicked(5)" href="Register.php">REGISTER</a> </li>
            </ul>
            <div class="dropdown">
                <span onclick="dropDownClicked(this)">Menu</span>
                <div id="dropdownContent" class="dropdown-content">
                    <li class="dropdown-item"><a href="MainPage.php">Home</a> </li>
                    <li class="dropdown-item"><a href='flights.php'>Flights</a> </li>
                    <li class="dropdown-item"><a href="MainPage.php">Make a reservation</a></li>
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
                    <th>FROM</th>
                    <th>TO</th>
                    <th>DATE / TIME</th>
                    <th>DURATION</th>
                    <th>COST</th>

                </tr>

                <?php

                session_start();
                $xml=simplexml_load_file("data/xml/flights.xml");

                $isAdmin=false;
                $isEditMode=false;
                if(isset($_SESSION["username"])){
                    if($_SESSION["username"] == "admin"){
                        $isAdmin=true;
                    }
                }
                $rowIndex=0;
                foreach ($xml->children() as $flight){
                    $key="option_" . $rowIndex;
                    if(isset($_REQUEST[$key])){
                        if($_REQUEST[$key] == "Edit"){
                            $isEditMode=true;
                            echo "<tr>";
                            echo "<td><input  type='text' value='". $flight->from ."' name='editFrom'></td>";
                            echo "<td><input  type='text' value='". $flight->to ."' name='editTo'></td>";
                            echo "<td><input  type='datetime' value='". $flight->date ."' name='editDate'></td>";
                            echo "<td><input  type='number' value='". $flight->duration ."' name='editDuration'></td>";
                            echo "<td><input  type='number' value='". $flight->cost ."' name='editCost'></td>";
                            echo "<td><input style='background-color: darkred'  type='submit' value='Save' name='option_" . $rowIndex . "'></td>";
                            echo "</tr>";
                        }

                    }
                    else{
                        echo "<tr>";
                        echo "<td>" . $flight->from . "</td>";
                        echo "<td>" . $flight->to . "</td>";
                        echo "<td>" . $flight->date . "</td>";
                        echo "<td>" . $flight->duration . "</td>";
                        echo "<td>" . $flight->cost . "</td>";
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
                    echo "<td><input type='text' name='from' placeholder='City 1'></td>";
                    echo "<td><input type='text' name='to' placeholder='City 2'></td>";
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

</body>