username: admin
password: adminadmin

1)Sta je uraðeno, a sta nije?
 Serijalizacija registrovanih korisnika i letova.
 Admin nakon logina koji se nalazi na MainPage-u ima mogucnost da dodaje, mijenja,
 brise i spasava letove (u 'flights.php'). Obicni korisnik ima samo mogucnost pregleda letova.
 Podaci su validirani u PHP-u, pri cemu je za registraciju korisnika uradjena totalna
 validacija ukljucujuci i XSS ranjivost dok je za letove uradjena samo validacija 
 za XSS. Validacija je uradjena i na login formi koja trenutno sluzi samo za login admina.
 
 Kada je admin logovan on moze na glavnoj stranici preuzeti pdf i csv izvjestaj klikom na odgovarajuce
 button-e koji su ispod glavnog menija.

 Pretraga letova sa trazenim specifikacijama.
 
 Dio za dodatni bod jos nije uradjen.

2) Bugovi
 Nisam primjetio bugove u verziji koju šaljem. 

5)Novi i relevantni fajlovi

Svi fajlovi koji imaju ekstenziju .php su modificirani ili novi. Sve funkcionalnosti su implementirane
u fajlovima cija imena opisuju funkcionalnosti