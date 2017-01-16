<?php

     $veza = new PDO("mysql:dbname=wt_creda;host=localhost;charset=utf8;port=1312", "korisnik", "korisnik");
     $veza->exec("set names utf8");
     $rezultat = $veza->query("select id, name, number_of_citizens from city");
     if (!$rezultat) {
          $greska = $veza->errorInfo();
          print "SQL greška: " . $greska[2];
          exit();
     }


     foreach ($rezultat as $flight) {
          print $flight['name']." ".$flight['number_of_citizens'];
          print "<br>LP<br>";

     }

?>
