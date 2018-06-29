function createMap(lat,lgn,address){
    var position = {lat: Number(lat), lng: Number(lgn)};
    var map = new google.maps.Map(
        document.getElementById('map'), 
        {   
            zoom: 15, 
            center: position, 
            mapTypeControl: false, 
            streetViewControl: false, 
            fullscreenControl: false
        }
    );
    var marker = new google.maps.Marker(
        {
            position: position, 
            map: map
        }
    );
    var infowindow = new google.maps.InfoWindow({
        content: address
    });
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
    infowindow.open(map, marker);
}


var default_lat = 0;
var default_long = 0;
var defaul_address = "";

function setDefaultPosition(lat, long, address) {
    default_lat = lat;
    default_long = long;
    defaul_address = address;
}

function initMap() {
    if($('#indirizzo').val()==''){
        createMap(default_lat,default_long, defaul_address);
        var info = {'lat':default_lat, 'lng':default_long, 'address':defaul_address};
        console.log(info);
        $('#lat').val(default_lat);
        $('#lng').val(default_long);
        $('#address').val(defaul_address);
        return info;
    } else {
        var address = $('#indirizzo').val();
        createMapFromAddress(address);
    }
}

function createMapFromAddress(address) {
    $.getJSON(
        "https://maps.googleapis.com/maps/api/geocode/json?&key=AIzaSyDG1sLHUnPTXltEtkhUPVXxTPbvg-Kali8", 
        { 'address':address , 'language':'it'},
        function(data) {
            var results = data['results'];
            console.log(results);
            if(results[0]) {
                console.log(results);
                var lat = results[0].geometry.location.lat;
                var lng = results[0].geometry.location.lng;
                var address = results[0].formatted_address;
                createMap(lat, lng, address);
                var info = {'lat':lat, 'lng':lng, 'address':address};
                $('#lat').val(lat);
                $('#lng').val(lng);
                $('#address').val(address);
                $("#address_error").hide();
                $("#address_error").children("input").val("");
                return info;
            } else {
                console.log( "error" );
                $("#address_error").show();
                $("#address_error").children("span").text("Indirizzo non valido");
                $("#address_error").children("input").val("error");
                
                return null;
            }
        }
    )
}