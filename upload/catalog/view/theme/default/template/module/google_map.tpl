<?php if ($status) { ?>

    <div class="module-google-maps">
        <div id="map<?php echo $module; ?>" <?php echo 'style="height: '. $height .'; width: '. $width .';"'; ?> ></div>
    </div>

    <script>
        function initMap<?php echo $module; ?>() {
            var map = new google.maps.Map(document.getElementById('map<?php echo $module; ?>'), {
                center: {lat: <?= $lat ?>, lng: <?= $lng ?>},
                zoom: 17,
                styles: [{elementType:"geometry",stylers:[{color:"#f5f5f5"}]},{elementType:"labels.icon",stylers:[{visibility:"off"}]},{elementType:"labels.text.fill",stylers:[{color:"#616161"}]},{elementType:"labels.text.stroke",stylers:[{color:"#f5f5f5"}]},{featureType:"administrative.land_parcel",elementType:"labels.text.fill",stylers:[{color:"#bdbdbd"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"poi.business",stylers:[{visibility:"off"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#e5e5e5"}]},{featureType:"poi.park",elementType:"labels.text",stylers:[{visibility:"off"}]},{featureType:"poi.park",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#ffdcf2"}]},{featureType:"road.arterial",elementType:"labels.text.fill",stylers:[{color:"#757575"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#ccbbdd"}]},{featureType:"road.highway",elementType:"labels.text.fill",stylers:[{color:"#7b216d"}]},{featureType:"road.local",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]},{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#e2d5e6"}]},{featureType:"transit.station",elementType:"geometry",stylers:[{color:"#eeeeee"}]},{featureType:"water",elementType:"geometry",stylers:[{color:"#b5c9c9"}]},{featureType:"water",elementType:"labels.text.fill",stylers:[{color:"#9e9e9e"}]}]
            });

            new google.maps.Marker({
                position: {lat: <?= $lat ?>, lng: <?= $lng ?>},
                map: map,
                icon: '<?php echo $map_icon; ?>'
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $api_key ?>&callback=initMap<?php echo $module; ?>" async defer></script>

<?php } ?>
