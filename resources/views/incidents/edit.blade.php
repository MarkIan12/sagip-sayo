@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 300px;
        width: 100%;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
    .required::after {
        content: " *";
        color: red;
    }
    .optional {
        font-style: italic;
        font-size: 0.9em;
        color: #666;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Edit Incident</h5>
            </div>

            <div class="card-body">
                <form action="{{ url('incidents/update/'.$incident->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- Date/Time -->
                        <div class="col-md-2">
                            <label class="required">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $incident->date }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="required">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ $incident->time }}" required>
                        </div>

                        <!-- Designation Office -->
                        <div class="col-md-4">
                            <label class="required">Designation Office</label>
                            <input type="text" name="designation_office" class="form-control" value="{{ $incident->designation_office }}" required>
                        </div>

                        <!-- Unit Shift -->
                        <div class="col-md-4">
                            <label>Unit Shift <span class="optional">(optional)</span></label>
                            <input type="text" name="unit_shift" class="form-control" value="{{ $incident->unit_shift }}">
                        </div>

                        <!-- Type of Incident -->
                        <div class="col-md-3">
                            <label for="type_of_incident" class="required">Type of Incident</label>
                            <select name="type_of_incident" id="type_of_incident" class="form-control select2" required>
                                <option value="">-- Select Incident Type --</option>
                                @foreach($incident_types as $type)
                                    <option value="{{ $type->id }}" {{ $incident->type_of_incident == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                                <option value="others" {{ !in_array($incident->type_of_incident, $incident_types->pluck('id')->toArray()) ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="other_incident_div" style="{{ !in_array($incident->type_of_incident, $incident_types->pluck('id')->toArray()) ? 'display:block;' : 'display:none;' }}">
                            <label for="other_incident" class="required">Specify Other Incident</label>
                            <input type="text" name="other_incident" id="other_incident" class="form-control" value="{{ !in_array($incident->type_of_incident, $incident_types->pluck('id')->toArray()) ? $incident->incident_types->name : '' }}">
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label>Description <span class="optional">(optional)</span></label>
                            <textarea name="description" class="form-control">{{ $incident->description }}</textarea>
                        </div>

                        <!-- Enforcer + Police -->
                        <div class="col-md-6">
                            <label>Enforcer Name <span class="optional">(optional)</span></label>
                            <input type="text" name="enforcer_name" class="form-control" value="{{ $incident->enforcer_name }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <label class="me-3">Police Notified? <span class="optional">(optional)</span></label>
                            <input type="checkbox" name="police_notified" value="1" {{ $incident->police_notified ? 'checked' : '' }}>
                        </div>
                    </div>
                    <hr>

                    <!-- Address & Map -->
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="required">Province</label>
                                    <input type="text" name="province" class="form-control" value="{{ $incident->province }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="required">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ $incident->city }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="required">Barangay</label>
                                    <select name="barangay_id" id="barangay" class="form-control select2" required>
                                        <option value="">-- Select Barangay --</option>
                                        @foreach($barangays as $b)
                                            <option value="{{ $b->id }}" {{ $incident->barangay_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="required">Street</label>
                                    <select name="street_id" id="street" class="form-control select2" required>
                                        <option value="">-- Select Street --</option>
                                        @foreach($streets as $s)
                                            <option value="{{ $s->id }}" data-barangay="{{ $s->barangay_id }}" data-name="{{ $s->name }}" {{ $incident->street_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="required">Position</label>
                                    <select name="street_position" id="street_position" class="form-control" required>
                                        <option value="along" {{ $incident->street_position == 'along' ? 'selected' : '' }}>Along</option>
                                        <option value="corner" {{ $incident->street_position == 'corner' ? 'selected' : '' }}>Corner</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="corner_street_div" style="{{ $incident->street_position == 'corner' ? 'display:block;' : 'display:none;' }}">
                                    <label class="required">Corner With</label>
                                    <select name="corner_street_id" id="corner_street" class="form-control select2">
                                        <option value="">-- Select Corner Street --</option>
                                        @foreach($streets as $s)
                                            <option value="{{ $s->id }}" data-barangay="{{ $s->barangay_id }}" data-name="{{ $s->name }}" {{ $incident->corner_street_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="required">Latitude</label>
                                    <input type="text" id="lat" name="lat" class="form-control" value="{{ $incident->lat }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="required">Longitude</label>
                                    <input type="text" id="lng" name="lng" class="form-control" value="{{ $incident->lng }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label>Attachments <span class="optional">(optional)</span></label>
                                    <input type="file" name="attachment[]" multiple class="form-control">
                                    @foreach($incident->attachments as $a)
                                        <div><a href="{{ asset($a->file_path) }}" target="_blank">{{ $a->file_name }}</a></div>
                                    @endforeach
                                </div>
                                <div class="col-md-12">
                                    <label>Remarks <span class="optional">(optional)</span></label>
                                    <textarea name="remarks" class="form-control">{{ $incident->remarks }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="col-md-12">
                                <label>Location Map (Click to drop pin)</label>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- Persons Involved -->
                    <h6>Persons Involved</h6>
                    <div id="persons-wrapper">
                        @foreach($incident->persons as $i => $p)
                        <div class="row g-3 person-item mb-2">
                            <div class="col-md-3">
                                <input type="text" name="persons[{{ $i }}][name]" class="form-control" placeholder="Name" value="{{ $p->name }}" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="persons[{{ $i }}][address]" class="form-control" placeholder="Address" value="{{ $p->address }}" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="persons[{{ $i }}][contact]" class="form-control" placeholder="Contact" value="{{ $p->contact }}" required>
                            </div>
                            <div class="col-md-2">
                                <select name="persons[{{ $i }}][is_main]" class="form-control" required>
                                    <option value="1" {{ $p->is_main ? 'selected' : '' }}>Main</option>
                                    <option value="0" {{ !$p->is_main ? 'selected' : '' }}>Passenger</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                @if($i != 0)
                                <button type="button" class="btn btn-danger remove-person">X</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-person" class="btn btn-secondary btn-sm">+ Add Person</button>

                    <hr>

                    <button type="submit" class="btn btn-primary">Update Incident</button>
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
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2();

    let lat = parseFloat($('#lat').val()) || 14.5777316;
    let lng = parseFloat($('#lng').val()) || 121.0331877;

    let map = L.map('map').setView([lat, lng], 18);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([lat, lng], {draggable:true}).addTo(map);

    marker.on('dragend', function(e){
        let pos = marker.getLatLng();
        $('#lat').val(pos.lat.toFixed(6));
        $('#lng').val(pos.lng.toFixed(6));
        map.setView(pos);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        $('#lat').val(e.latlng.lat.toFixed(6));
        $('#lng').val(e.latlng.lng.toFixed(6));
    });

    $('#lat, #lng').on('change keyup', function() {
        let lat = parseFloat($('#lat').val());
        let lng = parseFloat($('#lng').val());
        if(!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng]);
        }
    });

    // Toggle corner field
    $('#street_position').on('change', function() {
        if ($(this).val() === 'corner') {
            $('#corner_street_div').show();
            $('#corner_street').attr('required', true);
        } else {
            $('#corner_street_div').hide();
            $('#corner_street').removeAttr('required');
        }
    });

    // Filter streets by barangay
    $('#barangay').on('change', function () {
        let barangayId = $(this).val();
        $('#street option, #corner_street option').each(function () {
            if(!$(this).val()) return;
            $(this).toggle($(this).data('barangay') == barangayId);
        });
        $('#street, #corner_street').val('').trigger('change');
    });

    // Dynamic persons
    let personIndex = {{ $incident->persons->count() }};
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

    // Type of incident toggle
    $('#type_of_incident').on('change', function() {
        if ($(this).val() === 'others') {
            $('#other_incident_div').show();
            $('#other_incident').attr('required', true);
        } else {
            $('#other_incident_div').hide();
            $('#other_incident').removeAttr('required');
        }
    });
});
</script>
@endsection
