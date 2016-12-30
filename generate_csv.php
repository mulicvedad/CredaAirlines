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


function array_to_csv_download($array, $filename = "export_flights.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');

    // loop over the input array
    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter);
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}