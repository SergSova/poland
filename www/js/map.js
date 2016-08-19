var map, markers = [];
function mapInit(config){
    map = new google.maps.Map(document.getElementById('map'), {
        center: config.center,
        zoom: config.zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        mapTypeControl: false,
        draggable: (config.draggable !== undefined) ? config.draggable : true
    });
}

function setMarker(data) {
    var marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: data.position
    });
    if (data.content !== undefined) {
        var infoWindow = new google.maps.InfoWindow({
            content: data.content
        });
        marker.addListener('click', function () {

            for(var i = 0; i < markers.length; i++){
                markers[i].infoWindow.close();
            }
            infoWindow.open(map, marker);
        });
    }
    return {marker: marker, infoWindow: infoWindow};
}

function showMarkers(data){
    for (var i = 0; i < data.length; i++) {
        markers[i] = setMarker(data[i]);
    }
}

function clearMap(){
    for(var i = 0; i < markers.length; i++){
        markers[i].marker.setMap(null);
    }
}