var map, markers = [];
function mapInit(config) {
    map = new google.maps.Map(document.getElementById('map'), {
        center: config.center,
        zoom: config.zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        mapTypeControl: false,
        draggable: (config.draggable !== undefined) ? config.draggable : true
    });
}

var infoWindows = [];
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

            for (var i = 0; i < infoWindows.length; i++) {
                infoWindows[i].close();
            }
            infoWindow.open(map, marker);
        });
        infoWindows.push(infoWindow);
    }
    return  marker;
}

function showMarkers(data) {
    for (var i = 0; i < data.length; i++) {
        markers[i] = setMarker(data[i]);
    }
    new MarkerClusterer(map, markers, {
        maxZoom: 15,
        gridSize: 50,
        styles: [
            {
                "url": 'img/m1.png',
                "height": 55,
                "width": 55
            },
            {
                "url": 'img/m2.png',
                "height": 55,
                "width": 55
            },
            {
                "url": 'img/m3.png',
                "height": 55,
                "width": 55
            }
        ]

    });
}

function clearMap() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
}