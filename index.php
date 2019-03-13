<?php

include "includes/header.php";
include "includes/functions.php";
if (isset(($_GET["skoleNavn"]))) {
navnToId();
}

echo '<div class="main">';

echo "<h1>Find forældrenes indkomst på din skole</h1>";

include "includes/search.php";

include "includes/map.php";

if (isset(($_GET["kommune"]))) {
skolerKommune ();
}
if (isset(($_GET["id"]))) {
echo '<div class="skoleInfo">';
skoleInfo ();
echo '</div>';
skolerID();
}

echo "<div class='knapper'><a class='btn btn-primary' data-toggle='collapse' href='#kolapset' role='button' aria-expanded='false' aria-controls='kolapset'>Sådan er tallene udregnet</a></div>
<div id='kolapset' class='alert alert-primary metode collapse'><p>Analysen bygger på tal fra Danmarks Statistiks registre. I analysen indgår elever, der starter i 0-9. klasse på en ordinær grundskole, dvs. privat- og folkeskole, men ikke efterskole og specialskole. Elever over 17 år er ikke medregnet. </p>
<p>Skolerne skal have minimum 50 elever i alt, heraf mindst 10 elever i aldersgruppen 7-12 år, for at indgå i analysen. Dette gøres for at sikre, at særlige skoler kun med udskolingen ikke forstyrrer billedet.</p>
<p>Den gennemsnitlige indkomst for elevernes forældre opgøres på baggrund af ækvivaleret disponibel indkomst i familierne. Familier, der ikke er skattepligtige, hvor et medlem af familien er død i løbet af året, eller hvor DST ikke har oplysninger om indkomst, indgår ikke.</p></div>";

echo '</div>';

include "includes/footer.php";
?>
