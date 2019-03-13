<?php

setlocale(LC_ALL, "danish"); // det anhænger af systemet hvilken streng man skal bruge



function db_connect () {
//$servername = "localhost"; $username = "ae-data"; $password = "IsQuiz5443!!"; $dbname = "skoledata";
    
$servername = "localhost"; $username = "skoledata"; $password = "vDXtDmJVq01KcQp7"; $dbname = "skoledata";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    return $conn;
}

function navnToId() {
    $conn = db_connect();
    $skoleNavn = ($_GET["skoleNavn"]);
    
    $sql = "SELECT ID FROM skoledata WHERE Navn = '$skoleNavn'";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        $id = $row['ID'];
    }
    
    echo "<script>
    window.location.replace('index.php?id=" . $id . "');
    die();</script>";
}

function autoComplete () {
    $conn = db_connect();
    $sql = "SELECT Navn FROM skoledata ORDER BY Navn ASC";
    
    $result = $conn->query($sql);
    
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['Navn'];
    }
    
    //return json data
    echo json_encode($data);
    
}

function skolerKommune () {
    $conn = db_connect();
    $kommuneid = ($_GET["kommune"]);
    $sql = "SELECT * FROM `skoledata` WHERE `Kommune` = '$kommuneid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["ID"]. " - Name: " . $row["Navn"]. " " . $row["Kommune"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();

}

function skoleInfo () {
    
    $conn = db_connect();
    $instid = ($_GET["id"]);
    $sql = "SELECT * FROM `skoledata` WHERE `Kommune` = (SELECT `Kommune` FROM `skoledata` WHERE `ID` = '$instid') ORDER BY Indkomstgraense DESC";
    $result = $conn->query($sql);
    $kommuneSnit = array("København"=>"241000","Frederiksberg"=>"323000","Ballerup"=>"263000","Brøndby"=>"221000","Dragør"=>"334000","Gentofte"=>"513000","Gladsaxe"=>"298000","Glostrup"=>"240000","Herlev"=>"270000","Albertslund"=>"225000","Hvidovre"=>"255000","Høje-Taastrup"=>"241000","Lyngby-Taarbæk"=>"387000","Rødovre"=>"247000","Ishøj"=>"216000","Tårnby"=>"256000","Vallensbæk"=>"258000","Furesø"=>"339000","Allerød"=>"344000","Fredensborg"=>"308000","Helsingør"=>"270000","Hillerød"=>"287000","Hørsholm"=>"427000","Rudersdal"=>"442000","Egedal"=>"291000","Frederikssund"=>"259000","Greve"=>"272000","Køge"=>"261000","Halsnæs"=>"232000","Roskilde"=>"286000","Solrød"=>"324000","Gribskov"=>"258000","Odsherred"=>"221000","Holbæk"=>"243000","Faxe"=>"232000","Kalundborg"=>"232000","Ringsted"=>"249000","Slagelse"=>"231000","Stevns"=>"239000","Sorø"=>"235000","Lejre"=>"264000","Lolland"=>"198000","Næstved"=>"239000","Guldborgsund"=>"209000","Vordingborg"=>"227000","Bornholm"=>"217000","Middelfart"=>"253000","Assens"=>"228000","Faaborg-Midtfyn"=>"229000","Kerteminde"=>"234000","Nyborg"=>"232000","Odense"=>"236000","Svendborg"=>"238000","Nordfyns"=>"227000","Langeland"=>"195000","Ærø"=>"220000","Haderslev"=>"221000","Billund"=>"239000","Sønderborg"=>"225000","Tønder"=>"212000","Esbjerg"=>"237000","Fanø"=>"247000","Varde"=>"228000","Vejen"=>"223000","Aabenraa"=>"224000","Fredericia"=>"245000","Horsens"=>"250000","Kolding"=>"251000","Vejle"=>"251000","Herning"=>"251000","Holstebro"=>"235000","Lemvig"=>"250000","Struer"=>"225000","Syddjurs"=>"244000","Norddjurs"=>"220000","Favrskov"=>"261000","Odder"=>"256000","Randers"=>"229000","Silkeborg"=>"254000","Samsø"=>"221000","Skanderborg"=>"276000","Århus"=>"260000","Ikast-Brande"=>"240000","Ringkøbing-Skjern"=>"231000","Hedensted"=>"236000","Morsø"=>"209000","Skive"=>"228000","Thisted"=>"221000","Viborg"=>"242000","Brønderslev"=>"223000","Frederikshavn"=>"232000","Vesthimmerlands"=>"212000","Læsø"=>"225000","Rebild"=>"238000","Mariagerfjord"=>"225000","Jammerbugt"=>"225000","Aalborg"=>"241000","Hjørring"=>"228000");
    
    while($row = $result->fetch_assoc()) {
        foreach($kommuneSnit as $kommune => $indkomst) {
            if ($kommune === $row["Kommune"]) {
                $gennemsnit = $indkomst;
            }
}
        
            if ($row["Skoletype"] === "P") {
                $skoletype = "privatskole";
            }
            
            else {
                $skoletype = "folkeskole";
            }
            
            if ($row["ID"] === $instid) {
                
                $indkomstTjek = $row["Indkomstgraense"] * 1000;
                
                
                if ($indkomstTjek >= $gennemsnit) {
                    $gennemsnitsIndikator = "over";
                }
                
                else {
                    $gennemsnitsIndikator = "under";
                }
                
                echo "<p class='font-weight-bold'>" . $row["Navn"] . " er en " . $skoletype . " i " . $row["Kommune"] . " Kommune." . "</p>";
                echo "<p>" . "Forældrene til børn på skolen har i gennemsnit en indkomst på " . $row["Indkomst-interval"] . ".000 kr. efter skat." . " Det er " . $gennemsnitsIndikator . " gennemsnittet for kommunen, som er " . $gennemsnit / 1000 . ".000 kr." . "</p>";
                echo "<p>" . "I analysen indgår " . $result->num_rows . " skoler i " . $row["Kommune"] . " Kommune. Se, hvordan " . $row["Navn"] . " ligger i indkomstfordelingen sammenlignet med kommunens øvrige skoler nedenfor.";
            }
    }
}

function skolerID () {
    $conn = db_connect();
    $instid = ($_GET["id"]);
    $sql = "SELECT * FROM `skoledata` WHERE `Kommune` = (SELECT `Kommune` FROM `skoledata` WHERE `ID` = '$instid') ORDER BY Indkomstgraense DESC";
    $result = $conn->query($sql);
    
    echo '
    <div class="table-responsive">
    <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Navn</th>
      <th scope="col">Skoletype</th>
      <th scope="col">Indkomst interval</th>
    </tr>
  </thead>
   <tbody>';
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            
            if ($row["Skoletype"] === "P") {
                $skoletype = "Privatskole";
            }
            
            else {
                $skoletype = "Folkeskole";
            }
            
            if ($row["ID"] === $instid) {
            echo "<tr class='table-active'>" . "<th scope='row'>" . $row["Navn"] . "</th><td>" . $skoletype . "</td><td>" . $row["Indkomst-interval"] . ".000 kr.</td>" . "</tr>"; 
        }
            else {
                echo "<tr onclick='window.location=idIndex + " . $row["ID"] . "';>" . "<th scope='row'>" . $row["Navn"] . "</th><td>" . $skoletype . "</td><td>" . $row["Indkomst-interval"] . ".000 kr.</td>" . "</tr>";  
            }
            }
          echo "</tbody></table></div>";
    } else {
        echo "Ingen skole blev fundet";
    }
    $conn->close();

}

function mapVar() {
    $conn = db_connect();
    $sql = "SELECT * FROM skoledata ORDER BY Navn ASC";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        if ($row["Latitude"] != "FAILED" and $row["Longitude"] != "FAILED" ){
        echo  "var K" . $row["ID"] . " = {lat: " . $row["Latitude"] . ",lng: " . $row["Longitude"] . "};";
        }
    }
    
}

function varMarker() {
    $conn = db_connect();
    $sql = "SELECT * FROM skoledata ORDER BY Navn ASC";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        
        if (isset($_GET["id"]) && ($_GET["id"]) === $row["ID"]) {
            $ikon = "'assets/icon.png'";
        }
        
        else if ($row["Indkomstgraense"] < 200 ) {
            $ikon = "'assets/ikon-200.png'";
        }
        
        else if ($row["Indkomstgraense"] >= 200 && $row["Indkomstgraense"] < 300) {
            $ikon = "'assets/ikon-300.png'";
        }
        
        else if ($row["Indkomstgraense"] >= 300 && $row["Indkomstgraense"] < 400) {
            $ikon = "'assets/ikon-400.png'";
        }
        
        else if ($row["Indkomstgraense"] >= 400 && $row["Indkomstgraense"] < 500) {
            $ikon = "'assets/ikon-500.png'";
        }
        
        else if ($row["Indkomstgraense"] >= 500) {
            $ikon = "'assets/ikon-600.png'";
        }
        
        else {
            $ikon = "'assets/icon.png'";
        }
        
        if ($row["Latitude"] != "FAILED" and $row["Longitude"] != "FAILED" ){
        echo "var marker" . $row["ID"] . " = new google.maps.Marker({position: K" . $row["ID"] . ",map: map, icon:" . $ikon . ",});";
    }
        }
    
}

function varInfo() {
    $conn = db_connect();
    $sql = "SELECT * FROM skoledata ORDER BY Navn ASC";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {

        if ($row["Latitude"] != "FAILED" and $row["Longitude"] != "FAILED" ){
        echo "var infowindow" . $row["ID"] . " = new google.maps.InfoWindow({content: '" . $row['Navn'] . "'});";
    }
        }
    
}

function markerLink () {
    $conn = db_connect();
    $sql = "SELECT * FROM skoledata ORDER BY Navn ASC";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        
        if ($row["Latitude"] != "FAILED" and $row["Longitude"] != "FAILED" ){
        
        echo "marker" . $row["ID"] . ".addListener('click', function() {window.open('index.php?id=" . $row["ID"] . "','_self');});";
            
        echo "marker" . $row["ID"] . ".addListener('mouseover', function() {infowindow" . $row["ID"] . ".open(map, marker" . $row["ID"] . ");});";
            
        echo "marker" . $row["ID"] . ".addListener('mouseout', function() {infowindow" . $row["ID"] . ".close(map, marker" . $row["ID"] . ");});";
        }
    }
}

?>
