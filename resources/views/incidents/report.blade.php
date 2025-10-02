@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
       <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <form method="GET" action="{{ route('incidents.report') }}" class="row g-3">
            <div class="col-md-2">
                <label>Date From</label>
                <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
            </div>
            <div class="col-md-2">
                <label>Date To</label>
                <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
            </div>
            <div class="col-md-2">
                <label>Barangay</label>
                <select name="barangay" class="form-select select2">
                    <option value="">All</option>
                    @foreach($barangays as $b)
                        <option value="{{ $b->id }}" @if(($barangay ?? '') == $b->id) selected @endif>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Street</label>
                <select name="street" class="form-select select2">
                    <option value="">All</option>
                    @foreach($streets as $s)
                        <option value="{{ $s->id }}" @if(($street ?? '') == $s->id) selected @endif>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Type of Incident</label>
                <select name="type" class="form-select select2">
                    <option value="">All</option>
                    @foreach($types as $t)
                        <option value="{{ $t->id }}" @if(($type ?? '') == $t->id) selected @endif>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Incidents Bar Chart</h5>
                {{-- <div>
                    <a href="{{ url('incidents.exportExcel', request()->query()) }}" class="btn btn-sm btn-success">Export Excel</a>
                    <a href="{{ url('incidents.exportPDF', request()->query()) }}" class="btn btn-sm btn-danger">Export PDF</a>
                </div> --}}
            </div>
            <div class="card-body">
                <div id="barChart"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5>Incident Type Pie Chart</h5>
            </div>
            <div class="card-body">
                <div id="pieChart"></div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Incident Map</h5>
            </div>
            <div class="card-body">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Raw Data</h5>
            </div>
            <div class="card-body">
                <table id="incidentTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Created By</th>
                            <th>Address <br> Lat / Long</th>
                            <th>Type</th>
                            <th>Persons Involved</th>
                            <th>Attachments</th>
                            <th>Enforcer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td>{{ $incident->date }} {{ $incident->time }}</td>
                                <td>{{ $incident->user->name }}</td>
                             
                                <td>
                                    {{ $incident->province }}, {{ $incident->city }},
                                    {{ $incident->barangay->name ?? '' }},
                                    {{ $incident->street->name ?? '' }}
                                    @if($incident->street_position)
                                        ({{ ucfirst($incident->street_position) }})
                                    @endif
                                    @if($incident->cornerStreet)
                                        & {{ $incident->cornerStreet->name }}
                                    @endif
                                    <br>
                                    <small>{{ $incident->lat }}, {{ $incident->lng }}</small>
                                </td>
                                   <td>{{ $incident->incident_types->name}}
                                </td>
                                <td>
                                    @foreach($incident->persons as $p)
                                        <div>{{ $p->name }} ({{ $p->is_main ? 'Main' : 'Passenger' }})</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($incident->attachments as $a)
                                        <div><a href="{{ asset($a->file_path) }}" target="_blank">{{ $a->file_name }}</a></div>
                                    @endforeach
                                </td>
                                <td>{{$incident->enforcer_name}}</td>
                               
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No incidents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- DataTables JS -->
    <!-- Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <!-- JSZip for Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- pdfmake for PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
          $('.select2').select2();
            $('#incidentTable').DataTable({
                dom: 'Bfrtip', // Add buttons container
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Incident Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Incident Report',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ]
            });
    });

    // Bar Chart
    var optionsBar = {
        chart: { type: 'bar', height: 350 },
        series: [{ name: 'Incidents', data: @json($barData['counts'] ?? []) }],
        xaxis: { categories: @json($barData['labels'] ?? []) },
        dataLabels: { enabled: true }
    };
    var chartBar = new ApexCharts(document.querySelector("#barChart"), optionsBar);
    chartBar.render();

    // Pie Chart
    var optionsPie = {
        chart: { type: 'pie', height: 350 },
        series: @json($pieData['counts'] ?? []),
        labels: @json($pieData['labels'] ?? [])
    };
    var chartPie = new ApexCharts(document.querySelector("#pieChart"), optionsPie);
    chartPie.render();

    // Map
    var map = L.map('map').setView([14.5777316, 121.0331877], 15); // default center
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© RushPoint'
    }).addTo(map);

    @foreach($incidents as $i)
        @if($i->lat && $i->lng)
            L.marker([{{ $i->lat }}, {{ $i->lng }}]).addTo(map)
                .bindPopup('<b>{{ $i->typeOfIncident->name ?? 'N/A' }}</b><br>{{ $i->barangay->name ?? '' }}, {{ $i->street->name ?? '' }}<br>{{ $i->date }}');
        @endif
    @endforeach
</script>
@endsection
