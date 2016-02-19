<?php
/**
 * Created by PhpStorm.
 * User: phpNT
 * Date: 19.02.2016
 * Time: 1:17
 */
/* @var $widget \common\widgets\ShowMapModal\ShowMapModal */
?>
<div id="map-canvas" style="border-radius: 3px;"></div>
<?php
$js = <<< JS
    var map;
    var myCenter = new google.maps.LatLng(53, -1.33);
    var marker = new google.maps.Marker({
        position: myCenter
    });

    function initialize() {
        var mapProp = {
            center: myCenter,
            zoom: 17,
            draggable: true,
            scrollwheel: false,
            disableDoubleClickZoom: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var geocoder = new google.maps.Geocoder;
        map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
        //marker.setMap(map);

        geocodeAddress(geocoder, map);

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(contentString);
            infowindow.open(map, marker);
        });
    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = "<?= $widget->address ?>";
        geocoder.geocode({'address': address}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    initialize();
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>
