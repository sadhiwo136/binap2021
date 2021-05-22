@extends('layouts.master')

@section('title')
    Coordinates | PSU App Prototype
@endsection()

@section('content')
<div class="row">
    <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" id="target">Coordinates</h4>
            <p></p>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
        <style>
            .w-10p
            {
                width: 10% !important;
            }

            #mapid
            { 
                width: 700px; 
                height: 360px;
                margin: auto;
                padding: 10px;
            }
                        
        </style>
        <div id="mapid">

        </div>
        <div class="card-body">
            <div class="table-responsive" style="text-align:center;">
            <form action="/save-coordinates" autocomplete="off" method="POST">
                {{ csrf_field() }}
                <input id="userLat" type="text" name="val-lat" value="User Latitude" />
                <input id="userLng" type="text" name="val-lng" value="User Longitude" />
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
                <table id="mytable" class="table table-striped">
                    <thead class=" text-primary">                        
                        <th class="w-10p">Latitude</th>
                        <th class="w-10p">Longitude</th>
                        <th class="text-center w-10p" colspan="2">Actions</th>
                    </thead>
                    <tbody>
                        @foreach($coordinates as $data)
                        <tr>                            
                            <td>{{ $data->lat }}</td>
                            <td>{{ $data->long }}</td>                            
                            <td class="text-center">                                
                                <a href="#target" class="btn btn-info" onclick='myFunction({{ $data->lat }}, {{ $data->long }})'>Show</a>
                            <td class="text-center">
                                <form action="{{ url('del-cor/'.$data->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure?")'>Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach                
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>    
@endsection()

@section('scripts')
<script>
    /*var locations = [
        ["LOCATION_1", -7.2770121543125, 112.80358314514],
        ["LOCATION_2", -7.2834997257368, 112.71766662598],
        ["LOCATION_3", -7.3295059995003, 112.76161193848],
        ["LOCATION_4", -7.2794471323839, 112.87628173828]
    ];*/

    var markers = new Array();
    var newMarker, latlong;
    var mymap = L.map('mapid').setView([-7.2839, 112.7965], 12);
    $(function(){
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);
        //newMarkerGroup = new L.LayerGroup();
        mymap.on('click', addMarker);        
    });

    /*for (var i = 0; i < locations.length; i++) {
        marker = new L.marker([locations[i][1], locations[i][2]])
            .bindPopup(locations[i][0])
            .addTo(mymap);
    }*/

    <?php foreach($coordinates as $data => $value) { ?>
        //marker = new L.marker([-7.2770121543125, 112.80358314514])
        marker = new L.marker([ <?= $value->lat ?> , <?= $value->long ?> ])
            .bindPopup("<input type='button' value='Delete this marker.' class='marker-delete-button'/>")
            .on("popupopen", onPopupOpen)
            .addTo(mymap);
        markers.push(marker); 
    <?php } ?>

    function addMarker(e){
        // Add marker to map at click location; add popup window
        newMarker = new L.marker(e.latlng, {draggable:true}).addTo(mymap);
        mymap.addLayer(newMarker);
        newMarker.bindPopup("<input type='button' value='Delete this marker.' class='marker-delete-button'/>");
        newMarker.on("popupopen", onPopupOpen);

        latlong = newMarker.getLatLng();
        document.querySelector('#userLat').value = latlong.lat;
        document.querySelector('#userLng').value = latlong.lng;
    }

    function onPopupOpen() {
        var tempMarker = this;

        // To remove marker on click of delete button in the popup of marker
        $(".marker-delete-button:visible").click(function () {
            mymap.removeLayer(tempMarker);
        });

    }

    function m2()
    {
        alert('unfinished :(');
    }

    function markerDelAgain() {
        for(i=0;i<markers.length;i++) {
            mymap.removeLayer(markers[i]);
        }  
    }

    function myFunction(a, b) {
        //alert('hello!');        
        markerDelAgain();                
        m = new L.marker([a, b]).addTo(mymap);        
        m.bindPopup("<input type='button' value='Delete this marker.' class='marker-delete-button'/>");
        m.on("popupopen", onPopupOpen);
        markers.push(m);

        getfocus();
    }

    function getfocus() {
        //document.getElementById("target").focus();
        //document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script> 
@endsection()