var $latInput = $('.latitude');
var $lngInput = $('.longitude');
function initMap() {
    var paris = {lat: 48.864716, lng: 2.349014};
    var map = new google.maps.Map(document.getElementById('map-newobservation'), {
        zoom: 5,
        center: paris
    });

    var obs;
    map.addListener('click', function(e) {
        var lat = e.latLng.lat();
        var lng = e.latLng.lng();
        $latInput.val(lat);
        $lngInput.val(lng);
        if (obs) obs.setMap(null);
        obs = new google.maps.Marker({
            position: {lat: lat, lng: lng},
            map: map
        });
    })
}