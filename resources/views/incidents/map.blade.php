@extends('layouts.header')

@section('content')
<div class="row g-2 mt-3">
    <div id="map" style="height: 600px; width: 100%;"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeIzjHN5haDfX4BckC7u-jzc8fok1MtA"></script>

<script>
let map;

function initMap() {
    const mandaluyong = { lat: 14.5771621, lng: 121.0346741 };

    // Init Google Map
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: mandaluyong,
    });

    // Add Traffic Layer
    const trafficLayer = new google.maps.TrafficLayer();
    trafficLayer.setMap(map);

    // Fetch TomTom incidents from Laravel proxy
    fetch("{{ route('traffic.incidents') }}")
        .then(res => res.json())
        .then(data => {
            if (data && data.incidents) {
                data.incidents.forEach(incident => {
                    if (incident.geometry && incident.geometry.coordinates) {
                        const coords = incident.geometry.coordinates[0];
                        const position = { lat: coords[1], lng: coords[0] };

                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            icon: "https://maps.google.com/mapfiles/ms/icons/red-dot.png",
                            title: incident.properties.description || "Incident"
                        });
                        console.log(incident);
                        const info = new google.maps.InfoWindow({
                            content: `
                                <strong>Type:</strong> ${incident.type} <br>
                                <strong>Description:</strong> ${incident.properties.events[0].description || 'N/A'} <br>
                                <strong>Road:</strong> ${incident.properties.roadNumbers || 'Unknown'} <br>
                                <strong>Delay:</strong> ${incident.properties.magnitudeOfDelay || 'N/A'}
                            `
                        });

                        marker.addListener("click", () => info.open(map, marker));
                    }
                });
            }
        })
        .catch(err => console.error("Error fetching incidents:", err));
}

window.onload = initMap;
</script>
@endsection
