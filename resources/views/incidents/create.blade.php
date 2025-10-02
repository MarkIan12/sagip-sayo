@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    #map {
        height: 300px;
        width: 100%;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Create Incident</h5>
            </div>

            <div class="card-body">
                <form action="{{ url('incidents/store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Date/Time -->
                        <div class="col-md-4">
                            <label>Date & Time</label>
                            <input type="datetime-local" name="date_time" class="form-control" required>
                        </div>

                        <!-- Designation Office -->
                        <div class="col-md-4">
                            <label>Designation Office</label>
                            <input type="text" name="designation_office" class="form-control" required>
                        </div>

                        <!-- Unit Shift -->
                        <div class="col-md-4">
                            <label>Unit Shift</label>
                            <input type="text" name="unit_shift" class="form-control">
                        </div>

                        <!-- Type of Incident -->
                        <div class="col-md-6">
                            <label>Type of Incident</label>
                            <input type="text" name="type_of_incident" class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                        <!-- Enforcer + Police -->
                        <div class="col-md-6">
                            <label>Enforcer Name</label>
                            <input type="text" name="enforcer_name" class="form-control" placeholder="Enter Enforcer Name">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <label class="me-3">Police Notified?</label>
                            <input type="checkbox" name="police_notified" value="1">
                        </div>

                        <!-- Province -->
                        <div class="col-md-3">
                            <label>Province</label>
                            <input type="text" name="province" class="form-control" value="Metro Manila" readonly>
                        </div>

                        <!-- City -->
                        <div class="col-md-3">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="Mandaluyong" readonly>
                        </div>

                        <!-- Barangay -->
                        <div class="col-md-3">
                            <label>Barangay</label>
                            <select name="barangay_id" id="barangay" class="form-control select2" required>
                                <option value="">-- Select Barangay --</option>
                                @foreach($barangays as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Street -->
                        <div class="col-md-3">
                            <label>Street</label>
                            <select name="street_id" id="street" class="form-control select2" required>
                                <option value="">-- Select Street --</option>
                                @foreach($streets as $s)
                                    <option value="{{ $s->id }}" data-barangay="{{ $s->barangay_id }}" data-name="{{ $s->name }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Map -->
                        <div class="col-md-12">
                            <label>Location Map (Click to drop pin)</label>
                            <div id="map"></div>
                        </div>

                        <!-- Lat & Lng -->
                        <div class="col-md-3">
                            <label>Latitude</label>
                            <input type="text" id="lat" name="lat" class="form-control" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Longitude</label>
                            <input type="text" id="lng" name="lng" class="form-control" readonly>
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-6">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
                        </div>

                        <!-- Attachment -->
                        <div class="col-md-6">
                            <label>Attachment</label>
                            <input type="file" name="attachment" class="form-control">
                        </div>
                    </div>

                    <hr>

                    <!-- Persons Involved -->
                    <h6>Persons Involved</h6>
                    <div id="persons-wrapper">
                        <div class="row g-3 person-item mb-2">
                            <div class="col-md-3">
                                <input type="text" name="persons[0][name]" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="persons[0][address]" class="form-control" placeholder="Address">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="persons[0][contact]" class="form-control" placeholder="Contact">
                            </div>
                            <div class="col-md-2">
                                <select name="persons[0][is_main]" class="form-control">
                                    <option value="1">Main</option>
                                    <option value="0">Passenger</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-person">X</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-person" class="btn btn-secondary btn-sm">+ Add Person</button>

                    <hr>

                    <button type="submit" class="btn btn-primary">Save Incident</button>
                    <a href="{{ url('incidents') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeIzjHN5haDfX4BckC7u-jzc8fok1MtA"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();

    let map, marker, geocoder;
    function initMap() {
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 14.5836, lng: 121.0409 },
            zoom: 14
        });

        map.addListener("click", (e) => {
            placeMarker(e.latLng);
        });
    }

    function placeMarker(location) {
        if (marker) marker.setMap(null);
        marker = new google.maps.Marker({
            position: location,
            map: map
        });
        $('#lat').val(location.lat());
        $('#lng').val(location.lng());
    }

    initMap();

    // filter streets by barangay
    $('#barangay').on('change', function () {
        let barangayId = $(this).val();
        $('#street option').each(function () {
            if (!$(this).val()) return;
            $(this).toggle($(this).data('barangay') == barangayId);
        });
        $('#street').val('').trigger('change');
    });

    // when street is selected, focus map
    $('#street').on('change', function () {
        let streetName = $("#street option:selected").data('name');
        let barangayName = $("#barangay option:selected").text();
        let city = "Mandaluyong, Metro Manila, Philippines";

        if (streetName && barangayName) {
            let fullAddress = streetName + ", " + barangayName + ", " + city;

            geocoder.geocode({ 'address': fullAddress }, function(results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(18);
                    placeMarker(results[0].geometry.location);
                } else {
                    alert('Geocode failed: ' + status);
                }
            });
        }
    });

    // dynamic persons
    let personIndex = 1;
    $('#add-person').click(function () {
        $('#persons-wrapper').append(`
            <div class="row g-3 person-item mb-2">
                <div class="col-md-3">
                    <input type="text" name="persons[${personIndex}][name]" class="form-control" placeholder="Name">
                </div>
                <div class="col-md-3">
                    <input type="text" name="persons[${personIndex}][address]" class="form-control" placeholder="Address">
                </div>
                <div class="col-md-2">
                    <input type="text" name="persons[${personIndex}][contact]" class="form-control" placeholder="Contact">
                </div>
                <div class="col-md-2">
                    <select name="persons[${personIndex}][is_main]" class="form-control">
                        <option value="1">Main</option>
                        <option value="0">Passenger</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-person">X</button>
                </div>
            </div>
        `);
        personIndex++;
    });

    $(document).on('click', '.remove-person', function () {
        $(this).closest('.person-item').remove();
    });
});
</script>
@endsection
