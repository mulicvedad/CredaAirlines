username: admin
password: adminadmin

Link:
http://credaairlines-credaairlines.44fs.preview.openshiftapps.com/index.php
(uz deployment baze)
1)Sta je uraðeno, a sta nije?
 Uradjeno je sve. Nije uradjena detaljna provjera bugova zbog manjka vremena, tako da je moguce 
 da je ponesto promaklo.
 CRUD: korisnici (preko registracije, admin moze brisati), letovi, i gradovi (main page button kada je admin logovan)
 Dump baze se nalazi u folderu 'Baza'.
 Postman se nalazi u Postman folderu. 
 Web servis 'webService' koji za ime grada vraca sve letove koji polijecu iz tog grada ili
 slijecu u taj grad. (case insensitive)
 Migracija iz xmla u bazu.
 Nova forma za crud gradova koja je dostupna samo adminu na pocetnoj strani.