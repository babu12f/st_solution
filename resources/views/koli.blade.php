<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trac Location</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- <script src="https://maps.google.com/maps/api/js?sensor=true"></script> -->
    <script>
    </script>
     <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
          width:80%;
          height: 80%;
          margin: 0px auto;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        width: 100%;
        height:100%;
        margin: 0;
        padding: 0;
      }
    </style>
</head>

<body>
    <p></p>
    <div id="map"></div>
    <button id="btn_start">Start</button> | <button id="btn_stop">Stop</button> 

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCYu6NJCSX-b4P7SfPua0CA4vwhxiQrT0w&sensor=true">
    </script>


    <script>

        // get permission
        
        function handlePermission() {
            navigator.permissions.query({name:'geolocation'})
            .then(function(result) {
                if (result.state == 'granted') {
                report(result.state);
                } else if (result.state == 'prompt') {
                report(result.state);
                } else if (result.state == 'denied') {
                report(result.state);
                }
                result.onchange = function() {
                    report(result.state);
                }
            });
        }

        function report(state) {
            console.log('Permission ' + state);
        }

        handlePermission();

        // end permission

        $(function(){

            var start_tracking = false;
            var stop_tracking = true;
            var tracking_points = [];
            var myVar = null;
            var map = null;

            //setInterval(function(){ alert("Hello"); }, 3000);

            function start_tracking_location(){
                myVar = setInterval(myTimer, 3000);
                console.log('start track');
                $("p").html("start");
            }

            //var myVar = setInterval(myTimer, 1000);

            function myTimer() {
                if(!start_tracking){
                    myStopFunction();
                    return;
                }
                navigator.geolocation.getCurrentPosition(function(pos){
                    console.log('inside geolocation');
                    tracking_points.push({lat: pos.coords.latitude, lng: pos.coords.longitude})
                }, error);

            }

            function myStopFunction() {
                console.log('stop tracking');
                clearInterval(myVar);
                myVar = null;
                console.log(tracking_points);

                var flightPlanCoordinates = [
                {lat: 23.748259, lng: 90.403821},
                {lat: 23.787001, lng: 90.399762},
                {lat: 23.816831, lng: 90.406231},
                {lat: 23.824947, lng: 90.420447}
                ];

                var flightPath = new google.maps.Polyline({
                    path: tracking_points,
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });

                flightPath.setMap(map);

                tracking_points = [];
            }


            $('#btn_start').on('click', function(e){
                start_tracking = true;
                start_tracking_location();
            });

            $('#btn_stop').on('click', function(e){
                start_tracking = false;
            });

            var geo_options = {
                enableHighAccuracy: true, 
                maximumAge        : 30000, 
                timeout           : 27000
            };

            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(success, error, geo_options);
            }else{
                $('p').html('browser not suppoet geolocation');
            }

            function error(error){
                var errtype = {
                    0: "Unknown Error",
                    1: "Peermission denied by user",
                    2: "Position of user are not avilable",
                    3: "Request timeout"
                };

                console.log(error);

                var error_message = errtype[error.code];

                if(error.code == 0 || error.code == 2){
                    error_message = error_message +" - "+error.message;
                }

                $('p').html(error_message);
            }

            function success(pos){
                console.log(pos);
                //$('p').html('Lat : '+pos.coords.latitude+'<br>Long : '+pos.coords.longitude+'<br>Acc : '+pos.coords.accuracy);
                
                var googleLatLng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);

                var mapOpt = {
                    zoom: 18,
                    center: googleLatLng,
                    mapTypeId: google.maps.MapTypeId.ROAD
                };

                var map_dom = document.getElementById("map");

                map = new google.maps.Map(map_dom, mapOpt);

                addMarker(map, googleLatLng, "babor");

            }

            function addMarker(map, googleLatLng, title){
                var marker_opt = {
                    position: googleLatLng,
                    map: map,
                    title: title
                };

                var marker = new google.maps.Marker(marker_opt);
            }

        });

        
    </script>

</body>

</html>