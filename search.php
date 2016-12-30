<?php

$query="";
if(isset( $_GET["query"])){
    $query=validateInput( $_GET["query"]);
}

$flightsXml = simplexml_load_file("data/xml/flights.xml");

if($query != ""){

    $response="<table style='width:100%'>";
    $rowCounter=0;
    foreach ($flightsXml-> children() as $flight){
        if(stristr($flight->from, $query) || stristr($flight->to, $query)) {
            $response .= "<tr><td>".$flight->from ." - " . $flight->to ."</td></tr>";
            $rowCounter++;
        }
    }
    if($rowCounter==0){
        $response .= "<tr><td> No results </td></tr>";
    }

    $response.="</table>";

    echo $response;
}



function validateInput($data){
    return htmlspecialchars($data);
}