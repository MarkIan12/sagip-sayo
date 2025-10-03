@extends('layouts.header')

@section('content')
<div class="row mb-4">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Mandaluyong Traffic Map</h5>
                <span class="text-muted">Real-time Traffic & Incidents</span>
            </div>
            <div class="card-body p-0">
                <!-- Map Container -->
                <div id="map" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeIzjHN5haDfX4BckC7u-jzc8fok1MtA"></script>

<script>
let map;

// Map TomTom iconCategory → Google Maps marker colors & description
const categoryIcons = {
    0: {color: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png", label: "Unknown"},
    1: {color: "http://maps.google.com/mapfiles/ms/icons/red-dot.png", label: "Accident"},
    2: {color: "http://maps.google.com/mapfiles/ms/icons/ltblue-dot.png", label: "Fog"},
    3: {color: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png", label: "Dangerous Conditions"},
    4: {color: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png", label: "Rain"},
    5: {color: "http://maps.google.com/mapfiles/ms/icons/cyan-dot.png", label: "Ice"},
    6: {color: "http://maps.google.com/mapfiles/ms/icons/orange-dot.png", label: "Jam"},
    7: {color: "http://maps.google.com/mapfiles/ms/icons/purple-dot.png", label: "Lane Closed"},
    8: {color: "http://maps.google.com/mapfiles/ms/icons/black-dot.png", label: "Road Closed"},
    9: {color: "http://maps.google.com/mapfiles/ms/icons/green-dot.png", label: "Road Works"},
    10:{color: "http://maps.google.com/mapfiles/ms/icons/pink-dot.png", label: "Wind"},
    11:{color: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png", label: "Flooding"},
    14:{color: "http://maps.google.com/mapfiles/ms/icons/red-dot.png", label: "Broken Down Vehicle"}
};
// Map TomTom magnitudeOfDelay → description
const delayLevels = {
    0: "Unknown",
    1: "Minor",
    2: "Moderate",
    3: "Major",
    4: "Undefined"
};
function initMap() {
    const mandaluyong = { lat: 14.5771621, lng: 121.0346741 };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: mandaluyong,
    });

    // Add Traffic Layer
    const trafficLayer = new google.maps.TrafficLayer();
    trafficLayer.setMap(map);

    // Add Legend
    const legend = document.createElement('div');
    legend.id = "legend";
    legend.style.background = "white";
    legend.style.padding = "10px";
    legend.style.margin = "10px";
    legend.style.border = "1px solid black";
    legend.style.fontSize = "12px";

    let legendHTML = "<strong>Incident Legend</strong><br>";
    for (const key in categoryIcons) {
        legendHTML += `<img src="${categoryIcons[key].color}" style="width:16px;height:16px;"> ${categoryIcons[key].label}<br>`;
    }
    legend.innerHTML = legendHTML;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(legend);

    // Fetch TomTom incidents from Laravel proxy
    fetch("{{ route('traffic.incidents') }}")
        .then(res => res.json())
        .then(data => {
            if (data && data.incidents) {
                data.incidents.forEach(incident => {
                    if (incident.geometry && incident.geometry.coordinates) {
                        const coords = incident.geometry.coordinates[0];
                        const position = { lat: coords[1], lng: coords[0] };

                        const iconCategory = incident.properties.iconCategory || 0;
                        const markerIcon = categoryIcons[iconCategory].color;

                        const marker = new google.maps.Marker({
                            position: position,
                            map: map,
                            icon: markerIcon,
                            title: `Incident: ${categoryIcons[iconCategory].label}`
                        });

                        const description = (incident.properties.events && incident.properties.events[0]) 
                            ? incident.properties.events[0].description 
                            : 'N/A';

                        const info = new google.maps.InfoWindow({
                            content: `
                                <strong>Type:</strong> ${incident.type} <br>
                                <strong>Category:</strong> ${categoryIcons[iconCategory].label} <br>
                                <strong>Description:</strong> ${description} <br>
                                <strong>Road:</strong> ${incident.properties.roadNumbers || 'Unknown'} <br>
                                <strong>Delay:</strong> ${delayLevels[incident.properties.magnitudeOfDelay] || 'Unknown'}
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
