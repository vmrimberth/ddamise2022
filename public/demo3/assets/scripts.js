let defaultLatitude = -17.3131921;
let defaultLongitude = -65.8829336;
let map, markers, lines = null;
let urlBase = "https://localhost/ddamise2022/demo3/api.php";

$(function () {
    console.log("Web App Loaded...");
    init();

    $('#draw').click(function (event) {
        let username = $('#users').val();
        $.get(urlBase + '?type=points&username=' + username, function (data) {

            markers.clearLayers();
            lines.clearLayers();

            let points = Array();

            data.forEach(element => {
                L.marker([element.latitude, element.longitude], {
                    title: element.username,
                    riseOnHover: true
                }).addTo(markers);
                points.push(new L.LatLng(element.latitude, element.longitude));
            });

            console.log(data);

            new L.Polyline(points, {
                color: 'red',
                weight: 3,
                opacity: 0.5,
                smoothFactor: 1
            }).addTo(lines);

            map.setView(new L.LatLng(data[0].latitude, data[0].longitude), 16);

        });
        event.preventDefault();
    });
})

function loading(status) {
    if (status) {
        $('#loading').show();
    } else {
        $('#loading').hide();
    }
}

function init() {
    map = L.map('map').setView([defaultLatitude, defaultLongitude], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    markers = L.layerGroup().addTo(map);
    lines = L.layerGroup().addTo(map);

    loading(false);

    if (navigator.geolocation) {
        console.log("Location Loaded...");
        navigator.geolocation.getCurrentPosition(grabLocation);
    }

    $.get(urlBase + '?type=users', function (data) {
        data.forEach(element => {
            console.log(element.username);
            $('#users').append('<option>' + element.username + '</option>');
        });
    });
}

function grabLocation(location) {
    latitude = location.coords.latitude;
    longitude = location.coords.longitude;
}

