<?php

//load flights data from xml
$xmlFlights=simplexml_load_file("data/xml/flights.xml") or die("Error: Couldn't load file flights.xml");

//this is array of arrays - every array represents one line in csv (one flight)
$flightsArray = array();
array_push($flightsArray, array("FROM", "TO","DATE","DURATION", "COST"));
foreach($xmlFlights->children() as $flight){
        array_push($flightsArray, array($flight->from, $flight->to, $flight->date, $flight->duration, $flight->cost));
}

array_to_csv_download(
    $flightsArray,
    "flights.csv"
);

//approach found online
function array_to_csv_download($array, $filename = "export_flights.csv", $delimiter=",") {
    $f = fopen('php://memory', 'w');

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }
    fseek($f, 0);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    fpassthru($f);
}