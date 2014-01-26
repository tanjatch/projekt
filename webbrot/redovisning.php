<?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 


// Do it and store it all in variables in the Anax container.
$tamara['title'] = "Redovisning";

$tamara['main'] = <<<EOD
<article class="readable">
<h1>Redovisning av kursmomenten</h1>
<h2>Kmom06: Kom igång med Objektorienterad PHP</h2>
<p> Jag har inte så mycket erfarenheter sedan tidigare av bildhantering. Jag tyckte att momenten skulle ta kort tid att göra, men har fått några fel på väggen som var svåra att lösa, därför tog det längre tid än jag hoppades. </p>
<p> Jag tycker att det är bra verktyg för bildhantering. Först testade jag  img.php  med kodakflicka, det gick relativt bra. Jag har skapat klasserna CIMage och CGallery därefter, till och börja med hade jag inte så mycket kod i de, men sedan flyttade jag det mesta av koden från gallery och img till klasserna istället. CImage klassen var inte så svår att göra, det mesta av koden fanns med i img.php, men den andra klassen var svårare att förstå sig på, jag tittade i forumet hur andra har gjort det, fick lite idéer därifrån.  Jag har haft problem som flera studenter på kursen med att skriva rätt sökväg (slash eller backslash). Sedan visades inte bilderna i galleriet. Jag hittade lösningarna på forumet, men det tog lång tid tills jag förstod vad jag skulle göra. Jag tycker att PHP GD är svår, kan inte säga att förstår allt, men jag lyckades med galleriet, så att någonting förstod jag till sist. Tiden är också knapp, vill jätte gärna hinna med sista uppgiften innan kursen är slut.</p>
<p> Ett tag var jag på vägg att ge upp, tyckte att det inte borde vara så svårt, de flesta studenter har fixat momenten relativt fort, när jag läste på forumet.  Men sedan efter några dagar vilande från momenten, började jag igen att felsöka koden, till sist fick jag till det. </p>
<p> Jag tycker att Anax ser bra ut, jag övertygad att det kommer till användning när jag jobbar med projektet, det mesta finns där.  Det tog lång tid att göra kursmomenten, det var inte jag beredd på,men det är bra erfarenhet och jag har lärt mig mycket. Vad som saknas kan inte jag svara på, det viktigaste finns i Anax tycker jag. </p>
<h2>Kmom05: Kom igång med Objektorienterad PHP</h2>
<p>Jag tycker att det börjar bli rörigt nu med alla filer i webroten, kanske skulle jag ha flera mappar för var sin del av kursmomenten, även klasser blir fler och fler, börjar bli svårt att hålla reda på dem.  Nu är det nästan klart med att skapa klasser, vad jag saknar kan inte jag svara på. Det kommer jag att se när jag börjar med projektet, men det kanske blir för sent då.</p>
<p>Själva momenten gick så där, det var motgångar emellanåt, svårt att hitta fel jag lyckats göra. Först fixade jag det som man gick igenom i guiden, det fungerade bra, men jag fick inte se hela blogglistan, bara sista bloggen. Jag har funderat rätt länge på det, testat olika utskrifter, såg att jag hade allt i databasen men inte i utskriften, tills sist upptäckte jag felet i for- satsen, att jag inte skrivit punkt  i main (tamara['main'] .= ….), det är klart att det visar då det senaste. Det visar att jag har fortfarande svårt för php och html, annars skulle jag upptäcka felet mycket tidigare. Sedan fick jag problem med markdown, jag kopierade biblioteket från deras sida, det var med interface men jag har tagit bort de filerna. Till sist förstod jag felet och tagit fort interface, det fungerade perfekt. </p>
<p>Sedan började jag med klasser, först gjord jag CTextfiler, det var lättare att börja med den klassen, koden fanns ju i filter.  Det fungerade rätt så fort efter mina uppdateringar. CContent däremot var svårare att göra, jag kolladepå hur andra har gjort och försökte göra något liknande.  Till sist gjorde jag CPage och CPost som bygger på CContent, det är inte så mycket kod i de klasserna. Sedan la jag till att man kunde ta bort blogg och lägga till blogg(fick problem med id, jag hade inte riktigt fixat koppling med databasen, så att den inte ville skapa nya blogginlägg). Till sist gjorde jag en länk för att återskapa databasen, även här fick jag problem, fick en tom tabell  Content  gång på gång, men till sist fixade jag även det, bl.a. kollade jag hur andra har gjort.</p>
<p>Emellanåt var det frustrerande med det momentet. Det känns lite bättre med klasser och modulen, när jag har tid att håller på med det många dagar i sträck. När man fixar koden på direkten, känns det jätte bra, sedan råkar man göra fel, börja söka efter lösningar som ibland kan ta några dagar, då känns det inte så bra. 
Ärligt talat tycker jag att jag förstår det mesta men inte allt, hoppas det duger.
</p>
<h2>Kmom04: Kom igång med Objektorienterad PHP</h2>
<p>Direkt efter att jag gjort förra kursmomentet började jag med denna moment,jag tycket att jag kan använda min förra databas Test för att göra tabeller för Movie, när jag gjorde guiden med fildatabasen. Det var inte enkel, därför återanvände jag det mesta av koden som föreslagits för att göra kursmomentet, för att kompensera det hela så att ni ser att jag förstår någorlunda, la jag till en film. Jag skulle inte klara av att göra koden själv. </p>
<p>Det var tillräckligt med problem på vägen. Sedan skulle jag koppla det med min modul. Jag lyckades skapa CDatabase klassen, fick det att fungera. Sedan gjorde jag klassen CMovie där sparade jag funktioner som använd i movie.php. Jag försökte skapa fler klasser för att movie.php inte skulle vara så lång, men det blev för mycket fel, till sist gav jag upp. </p>
<p>Jag tycker att moduler fungerar riktigt bra, det är svårt emellanåt, men jag hoppas att det lönar sig i längden, när jag gör sista momenten.</p>
<p>Sist gjorde jag CUser, som fungerade perfekt på min lokal mhpMYAdmin. När jag sedan gjorde tabeller på skolan databas, blev det fel med login, databasen kände inte igen t.ex. ”doe”. Det tog många timmer för mig att komma på vad det för fel. Jag såg inte att någon hade liknande problem på forumet, det är svårt att fråga på forumet om man inte riktigt vet vart felet ligger. Jag gjorde några utskrifter med var_dumpp och dum, till sist lokaliserade jag vart problemet var, att skolans server hade problem med raden 
params = arrayy(htmlentitie(user), htmlentitie(password))

Så att när jag gjorde dump(res); visades det en tom array. Det fungerade lokalt men inte på skolans server. Det var jag själv som ändrade den kod som föreslagit(
params = arrayy();
params =[htmlentitie(user), htmlentitie(password)];)
för att Dreamweawer klagade just på den raden. </p>
<p>Det var en lättnad att se att det fungerade till sist. Jag tycket att guiden var svår att följa, och att jag fastnade för mycket på olika delar, hade fel jag inte kunde fixa på direkten. Det var ett svår kursmoment, kan vara för att jag fortfarande osäker på PHP och hur det fungerar med databaser. Jag vågar inte ens tänka på hur många timmar det har tagit att göra det klart.</p>
<h2>Kmom03: Kom igång med Objektorienterad PHP</h2>
<p>Jag är bekant med databaser, förutom att vi använt lite utav det i förra kursen har jag läst en kurs på 7,5p om databaser, där använde jag PostgreSQL. Grunderna kunde jag någorlunda, fast kursen jag läste om databaser var svår. Jag jobbade igenom guiden ”Kom igång med databasen MySQL och dess klienter”. Jag hade sedan tidigare WAMPServer för Windows installerat på min dator, men har inte använt MySQL. Provade försiktigt båda versioner(textbaserad och och phpMyAdmin). Komandon kände jag igen för det mesta, lyckades skapa en databas Test, men sedan blev det fel någonstans för att jag kunde inte skapa fler databaser, kan det vara lösenordet tänkte jag, men hur mycket än jag försökte  fixa det lyckades jag inte. Det blev en kompromiss att göra tabeller för Movie i databasen Test istället. Det gick bra.</p>
<p>Sedan lyckades jag koppla upp mig på phpMyAdmin på studenserver. Det var inga problem att skapa tabeller där. Först kollade jag på forumet vad kan det blir för problem med uppkoplingen, visste då vart man ska kolla lösenordet och att man kan bara skapa tabeller. </p>
<p>
MySql Workbench hade jag inte installerat först, gjorde det lite senare när jag började med nästa kursmoment. Det fungerade bra. De flesta övningarna gjorde jag i phpMyAdmin, tycket det fungerade rätt så bra, även skolans MySQL kopplade jag upp mig via phpMyAdmin.</p>
<p>Sista övningen ”Kom igång med MySQL” gjorde jag det mesta av, skapade tabell lärare, testade frågorna, det gick relativt bra.</p>
<p> Jag känner att jag fortfarande nybörjare vad det gäller databaser, trots att jag jobbat tidigare med det, just att man ska koppla ihop det med PHP och HTML. Jag vet inte hur mycket av det ska man förstå fullt ut, jag vet att jag har en hel del att fortfarande förstå mig på.</p>


<h2>Kmom02: Kom igång med Objektorienterad PHP</h2>
<p> Jag känner till objektorienterat koncept eftersom jag läst kurserna i programmering. Det var inte nytt för mig, men att göra det i PHP var nytt. Jag hade svårt till och börja med, kan bero på att jag fortfarande osäker på grunderna i PHP och hur man kombinerar det med html. Så att det var mycket fram och tillbaka för mig på den grundläggande delen av språket.</p>
<p> Jag jobbade igenom oophp20-guiden. Jag har gjort alla steg till sist fixade jag nästan tärningsspelet. Mina fel löste jag genom att titta i forumet eller försökte jag titta i guiden om jag missat någonting. Jag utgick från CDice.php och CDiceImage.php och modifierade CDiceHand.php så att det passade min uppgift. Som sagt följer man instruktionerna i guiden så blir uppgiften nästan klar. </p>
<p>Jag tittade även på forumet hur andra löste uppgiften, det hjälpte att se strukturen på spelet. Sedan började jag implementera spelet som modul, där fick jag problem och många fel. Det krävdes mycket jobb. Kanske var det fel att gör spelet för sig först? Sist hade jag problem med hur jag fixar min main för spelet för att där skulle jag bara ha PHP, gick inte att kombinera med html som i guiden. Jag såg lösningen på forumet. </p>
<p> Jag modifierade spelet lite gran, såg att man kan göra enkel för sig om man sparar varenda gång, men det finns en poäng att vänta med sparande tycker jag. Jag la till att utmaningen ligger även i att klara spelet på minst antal sparomgångar.</p>
<p>Jag har inte gjort extra uppgifter, har inte tid, tycker att jag la ner alldeles för mycket tid på den här uppgiften. Förhoppningsvis lönar det sig fortsättningsvis på kursen, förhoppningsvis har jag förstått PHP lite bättre.</p>
<hr>
<h2>Kmom01: Kom igång med Objektorienterad PHP</h2>
<h3>Utvecklingmiljö</h3>
Jag installerade en webbserver till förra kursen och en texteditor.

<p>Operativsystem: Windows 7</p>

<p>Webbläsare: Mozilla Firefox</p>

<p>Editor: JEdit</p>

<p>Websever: WAMP</p>

<p>FTP-klient: Filezilla</p>
<p> Jag gick igenom guiden, har använd mig av den på förra kursen, men det behövdes. Jag har använd delar av förra kursens hemsidan för att göra den här sidan. Jag har behövt mycket tid med den kursmomenten. Det var jobbig emelanåt, fick några obegripliga fel, t.ex. hade jag svårt med att se till att faviocon fungerade.</p>   
<p>Mitt Anax fick heta Tamara. Tamara är en variant av det hebreiska namnet Tamar med betydelsen 'palmträd'. Jag tykte att det var bra med struktur, det tog dock sin tid att förstå. Jag följde anvisningarna, gjorde webbmall likt Anax. Det var tillräkligt svårt. Jag inkludera CSorce som egen modul, det gick bra. </p>

<p> Jag gjorde extra uppgiften. Jag behövde lära mig hur Git fungerade för mina andra projekt, därför tänkte jag att det var lika bra att börja nu.
</p>




{$tamara['byline']}

</article>

EOD;


// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
