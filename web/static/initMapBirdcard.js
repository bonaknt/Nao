var geoArray = (function getGeoDataArray() {
    var $data = $('#data').find('div');
    var geodataArray = [];
    for (var i = 0; i < $data.length; i++) {
        var lat = $($data[i]).data('latitude');
        var lng = $($data[i]).data('longitude');
        var geodata = [lat, lng];
        geodataArray.push(geodata);
    }
    return geodataArray;
})();

console.log(geoArray)


function initMap() {
    var paris = {lat: 48.864716, lng: 2.349014};
    var map = new google.maps.Map(document.getElementById('map-birdcard'), {
        zoom: 5,
        center: paris
    });

    for (var i = 0; i < geoArray.length; i++) {
        var geo = geoArray[i];
        var marker = new google.maps.Marker({
            position: {lat: geo[0], lng: geo[1]},
            map: map,
        });
    }



}