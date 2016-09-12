var map, markers = [];
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
}
function showMarkers() {
    if (markersData.length > 0) {
        for (var i = 0; i < markersData.length; i++) {
            markers[i] = setMarker(markersData[i]);
            markers[i].marker.setMap(map);
        }
    } else {
        markers[0] = setMarker({position: mapConfig.center});
        markers[0].marker.setMap(map);
    }
}

function setMarker(data) {
    var marker = new google.maps.Marker({
        draggable: false,
        position: data.position
    });
    if (data.content !== undefined) {
        var infoWindow = new google.maps.InfoWindow({
            content: data.content
        });
        marker.addListener('click', function () {
            infoWindow.open(map, marker);
        });
    }
    return {marker: marker, infoWindow: infoWindow};
}

function clearMap(){
    for(var i = 0; i < markers.length; i++){
        markers[i].marker.setMap(null);
    }
}