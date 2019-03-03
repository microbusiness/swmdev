<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
</head>
<body class="index-page">
<h1>Test map</h1>
<style>
    #test-map {
        height: 100vh;
    }
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div id="test-map"></div>
<script>
    var bbox=[];
    var bboxPoligon=null;
    function initMap() {
        map = new google.maps.Map(document.getElementById('test-map'), {
            center: {lat: 0, lng:0},
            zoom: 3,
            mapTypeControl: false
        });
        map.addListener('click', function(e) {
            placeMarker(e.latLng, map);
        });
    }

    function placeMarker(position, map) {
        if (bbox.length==0){
            bbox[0] = new google.maps.Marker({
                position: position,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    fillColor: 'red',
                    fillOpacity: .9,
                    scale: 4.5,
                    strokeColor: 'white',
                    strokeWeight: 1
                },
                map: map
            });
        } else {
            if (bbox.length==1){
                bbox[1] = new google.maps.Marker({
                    position: position,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: 'red',
                        fillOpacity: .9,
                        scale: 4.5,
                        strokeColor: 'white',
                        strokeWeight: 1
                    },
                    map: map
                });
                var pos2= new google.maps.LatLng(bbox[1].getPosition().lat(),bbox[0].getPosition().lng());
                bbox[2] = new google.maps.Marker({
                    position: pos2,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: 'red',
                        fillOpacity: .9,
                        scale: 4.5,
                        strokeColor: 'white',
                        strokeWeight: 1
                    },
                    map: map
                });

                var pos3= new google.maps.LatLng(bbox[0].getPosition().lat(),bbox[1].getPosition().lng());
                bbox[3] = new google.maps.Marker({
                    position: pos3,
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: 'white',
                        fillOpacity: .1,
                        scale: 4.5,
                        strokeColor: 'white',
                        strokeWeight: 1
                    },
                    map: map
                });

                var coords = [
                    {lat: bbox[0].getPosition().lat(), lng: bbox[0].getPosition().lng()},
                    {lat: bbox[2].getPosition().lat(), lng: bbox[2].getPosition().lng()},
                    {lat: bbox[1].getPosition().lat(), lng: bbox[1].getPosition().lng()},
                    {lat: bbox[3].getPosition().lat(), lng: bbox[3].getPosition().lng()},
                    {lat: bbox[0].getPosition().lat(), lng: bbox[0].getPosition().lng()},
                ];

                bboxPoligon = new google.maps.Polygon({
                    paths: coords,
                    strokeColor: '#FF0000',
                    strokeOpacity: 0.1,
                    strokeWeight: 2,
                    fillColor: '#FFFFFF',
                    fillOpacity: 0.35
                });
                bboxPoligon.setMap(map);

                var image='https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';

                var minx=0;
                var miny=0;
                var maxx=0;
                var maxy=0;
                for (var i = 0; i < bbox.length; i++) {
                    if (minx==0){
                        minx=bbox[i].getPosition().lat();
                    } else {
                        if (bbox[i].getPosition().lat()<minx){
                            minx=bbox[i].getPosition().lat();
                        }
                    }
                    if (maxx==0){
                        maxx=bbox[i].getPosition().lat();
                    } else {
                        if (bbox[i].getPosition().lat()>maxx){
                            maxx=bbox[i].getPosition().lat();
                        }
                    }
                    if (miny==0){
                        miny=bbox[i].getPosition().lng();
                    } else {
                        if (bbox[i].getPosition().lng()<miny){
                            miny=bbox[i].getPosition().lng();
                        }
                    }
                    if (maxy==0){
                        maxy=bbox[i].getPosition().lng();
                    } else {
                        if (bbox[i].getPosition().lng()>maxy){
                            maxy=bbox[i].getPosition().lng();
                        }
                    }
                }

                map.data.loadGeoJson('/api/usersmap/?geo_location[nw][lat]='+maxy+'&geo_location[nw][lng]='+maxx+'&geo_location[se][lat]='+miny+'&geo_location[se][lng]='+minx);
                map.data.setStyle({
                    fillColor: 'green',
                    strokeWeight: 1,
                    icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
                });

            } else {
                for (var i = 0; i < bbox.length; i++) {
                    bbox[i].setMap(null);
                }
                bbox=[];
                bboxPoligon.setMap(null);
                bboxPoligon=null;
                map.data.forEach(function(feature) {
                    map.data.remove(feature);
                });
            }
        }


    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ $mapskey }}&callback=initMap"></script>
</body>
</html>

