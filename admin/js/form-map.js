var map, marker, autocomplete;
var geocoder = new google.maps.Geocoder();
function mapInit() {
    map = new google.maps.Map(
        document.getElementById('map'),
        {
            center: mapConfig.center,
            zoom: mapConfig.zoom,
            draggable: mapConfig.draggable,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: mapConfig.center
    });

    google.maps.event.addListener(marker, 'drag', function(){
        geocoder.geocode({'location': marker.getPosition()}, function(results, status){
            if(status == google.maps.GeocoderStatus.OK){
                document.getElementById(mapConfig.coordInpId).value = results[0].geometry.location.lat()+';'+results[0].geometry.location.lng();
            }
        });
    });
}
