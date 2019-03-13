<div id="map"></div>
<script>
    function initMap() {
        <?php mapVar(); ?>
        var map = new google.maps.Map(document.getElementById('map'),
            <?php 
            if (isset(($_GET["id"]))) {
                echo "{zoom: 15,center:K" . ($_GET["id"]) . ",";
                }
            else {
                echo "{zoom: 6,center: {lat: 55.58,lng: 11.46},";
            }
            ?> 
                                      });

        <?php varInfo(); ?>

        <?php varMarker(); ?>

        <?php markerLink (); ?>
    }

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0gQC9oPYjl-Cq1XirX5hVBG09LJS8uds&callback=initMap">


</script>

<div class="d-inline-flex flex-row kort-forklaring">
    <p class="mr-1">Gennemsnitlig indkomst efter skat:</p>
    <p><img src="assets/ikon-200.png" class="img-fluid">Under 200.000 kr.</p>
    <p><img src="assets/ikon-300.png">200 - 300.000 kr.</p>
    <p><img src="assets/ikon-400.png">300 - 400.000 kr.</p>
    <p><img src="assets/ikon-500.png">400 - 500.000 kr.</p>
    <p><img src="assets/ikon-600.png">Over 500.000 kr.</p>
    </div>
<!--
    <?php if(isset($_GET["id"])):?>
    <p class="font-weight-bold"><img src="assets/icon.png">Denne skole</p>
    <?php endif;?>
-->

