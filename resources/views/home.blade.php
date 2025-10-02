@extends('layouts.header')

@section('css')
@endsection

@section('content')
<div class="row">
    <!-- KPIs -->
   
                <!-- Total Incidents -->
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Incidents</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold">
                                        <span class="counter-value" data-target="{{ $totalIncidents }}">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted text-truncate">
                                        <span class="badge bg-light text-success mb-0"> <i class="ri-arrow-up-line align-middle"></i> vs. last year </span>
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="alert-circle" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- This Month -->
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">This Month</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold">
                                        <span class="counter-value" data-target="{{ $thisMonthIncidents }}">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted text-truncate">
                                        <span class="badge bg-light text-danger mb-0"><i class="ri-arrow-down-line align-middle"></i> vs. last month</span>
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="calendar" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
                <!-- Average per Month -->
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Avg. Incidents / Month</p>
                                    <h2 class="mt-4 ff-secondary cfs-22 fw-semibold">
                                        <span class="counter-value" data-target="{{ $avgPerMonth }}">0</span>
                                    </h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                            <i data-feather="trending-up" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Placeholder Card (can be used for last week or type count) -->
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body text-center">
                            <p class="fw-medium text-muted mb-0">Incident Growth</p>
                            <h2 class="mt-4 ff-secondary cfs-22 fw-semibold">
                                <span class="counter-value" data-target="{{ $totalIncidents }}">0</span>
                            </h2>
                        </div>
                    </div>
                </div>

    <!-- Charts -->
    <div class="col-xxl-12">
        <div class="row h-100">
            <!-- Barangay Incidents Chart -->
            <div class="col-xl-12">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Mandaluyong City</h4>
                        <div class="flex-shrink-0">
                            <button type="button" class="btn btn-soft-primary btn-sm material-shadow-none">
                                Export Report
                            </button>
                        </div>
                    </div><!-- end card header -->

                    <!-- card body -->
                    <div class="card-body">
                        <div id="barangays_incidents_chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Incidents Chart -->
<div class="row mt-3">
    <div class="col-xl-12">
        <div class="card card-height-100">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Monthly Incidents</h4>
            </div>
            <div class="card-body">
                <div id="monthly_incidents_chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>

<!-- Incident Types and Latest Incidents -->
<div class="row mt-3">
    <!-- Incident Types -->
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header">
                <h4 class="card-title mb-0">Incident Types</h4>
            </div>
            <div class="card-body">
                <div id="incident_types_chart" class="apex-charts" dir="ltr"></div>
                <div class="table-responsive mt-3">
                    <table class="table table-borderless table-sm table-centered align-middle mb-0">
                        <tbody>
                            @foreach($incidentTypes as $type)
                            <tr>
                                <td>{{ $type->name }}</td>
                                <td class="text-end">{{ $type->incidents_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Incidents -->
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header">
                <h4 class="card-title mb-0">Latest Incidents</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-borderless table-centered mb-0">
                        <thead class="text-muted table-light">
                            <tr>
                                <th>Incident</th>
                                <th>Type</th>
                                <th>Barangay</th>
                                <th>Date</th>
                                <th>Encoded By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestIncidents as $incident)
                            <tr>
                                <td>{{ $incident->id }}</td>
                                <td>{{ $incident->type->name ?? 'N/A' }}</td>
                                <td>{{ $incident->barangay->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($incident->date)->format('M d, Y') }}</td>
                                <td>{{ $incident->user->name ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('inside_css/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<script>
// Barangay Incidents Chart
var barangayChart = new ApexCharts(document.querySelector("#barangays_incidents_chart"), {
    chart: { type: 'bar', height: 350 },
    plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4, dataLabels: { position: 'top' } } },
    dataLabels: { enabled: true, style: { colors: ["#adb5bd"] } },
    series: [{ data: @json($barangayCounts->pluck('incidents_count')) }],
    xaxis: { categories: @json($barangayCounts->pluck('name')) }
});
barangayChart.render();

// Monthly Incidents Chart
var monthlyChart = new ApexCharts(document.querySelector("#monthly_incidents_chart"), {
    chart: { type: 'line', height: 350 },
    series: [{ name: 'Incidents', data: @json($monthlyIncidents->pluck('count')) }],
    xaxis: { categories: @json($monthlyIncidents->pluck('month')) }
});
monthlyChart.render();

// Incident Types Pie Chart
var incidentTypeChart = new ApexCharts(document.querySelector("#incident_types_chart"), {
    chart: { type: 'pie', height: 350 },
    series: @json($incidentTypes->pluck('incidents_count')),
    labels: @json($incidentTypes->pluck('name')),
    responsive: [{ breakpoint: 480, options: { chart: { width: 300 }, legend: { position: 'bottom' } } }]
});
incidentTypeChart.render();
</script>
@endsection
