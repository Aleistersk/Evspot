Evspot application - based on Nette Framework Sandbox
======================================================

Aplikacia EVSPOT.


Co je Evspot aplikacia?
------------------------
Evspot aplikacia sluzi pouzivatelom v domacnosti evidovat pouzivane zariadenia v danej domacnosti, ako aj 
ich spotrebu - odhadovanu a skutocnu. Ponuka prehlad o evidovanyzch zariadeniach a vypis celkovej spotreby v domacnosti
spolu s cenovou kalkulaciou.
Evidencia spociva v evidovani prikonu jednotlivych zariadeni, ich odhadovanej doby pouzivania, ich nazvu, 
a aj nameranej skutocnej spotreby (v kWh - kilowatt hodinach). Aplikacia Evspot vyratava zo zadanych udajov 
odhadovanu spotrebu daneho zariadenia. Pri evidencii zariadenia prihlasenym pouzivatelom do systemu mu prideli pouzivatel 
kategoriu, ako aj sadzbu (v eurach), ktora sluzi pre vypocet sumy za evidovanu skutocnu spotrebu a odhadovanu spotrebu.
Evidovane zariadenia sa ukladaju do DB aplikacie.


Instalacia
----------

Pre samotnu instalaciu aplikacie je vyzadovany server s podporou PHP (v.5.3 a vyssie) a databazovym systemom MySQL.
Instalacia spociva v stiahnuti adresara "Evspot-nette" s celym jeho obsahom a nakopirovanim tohto adresara na
server (localhost, resp. vzdialeny server) do priecinka public_html. Je dobre premenovat adresar "Evspot-nette" 
iba na nazov "evspot". 
Pre databazu aplikacie je potrebne vytvorit tabulky databazy pomocou SQL skriptov ulozenych v 
adresari "SQL scripts for MySQL DB" v MySQL na serveri. Nazov DB si pouzivatel, ktory instaluje apliaciu Evspot, 
voli sam (priklad nazvu DB "evspot"). Po vytvoreni tabuliek DB a umiestneni Evspot-nette adresara na server a jeho premenovani
na "evspot" je nutne nakonfigurovat pristup k DB v konfiguracnom subore s nazvom 'config.neon'. Tento sa nachadza
v podadresari "app\config\" aplikacie. Priklad konfiguracie DB pre aplikaciu je nasledujuci:

database:
			dsn: 'mysql:host=localhost;dbname=evspot'
			user: usernameForMySQL
			password: passwordForMySQLuser

Tym je instalacia ukoncena a mozete zacat pouzivat aplikaciu. Aplikacia sa spusta cez webovy prehliadac zadanim url v tvare:

http://server/evspot/www/

kde server - je adresa Vasho servera (napr. localhost)

Na vzdialenom serveri sa odporuca do priecinka public_html umiestnit index.php stranka pre redirect na aplikaciu s nasledujucim
obsahom (sluzi iba ako priklad):

<?php
  /* Redirect to a different page in the current directory that was requested */
  $host  = $_SERVER['HTTP_HOST'];
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = 'evspot/www/index.php';
  header("Location: http://$host$uri/$extra");
  exit;
?> 