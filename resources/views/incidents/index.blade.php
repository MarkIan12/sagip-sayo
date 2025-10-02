@extends('layouts.header')

@section('css')
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Incidents</h5>
              
            </div>

            <div class="card-body">

                <!-- Filters -->
                <form method="GET" action="{{ url('incidents') }}" class="row g-3 mb-3">
                    <div class="col-md-3">
                        <select name="barangay" class="form-control">
                            <option value="">-- All Barangays --</option>
                            @foreach($barangays as $b)
                                <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="street" class="form-control">
                            <option value="">-- All Streets --</option>
                            @foreach($streets as $s)
                                <option value="{{ $s->id }}" {{ request('street') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search...">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ url('incidents') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <!-- Table -->
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Barangay</th>
                            <th>Street</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Persons Involved</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td>{{ $incident->date_time }}</td>
                                <td>{{ $incident->barangay }}</td>
                                <td>{{ $incident->street }}</td>
                                <td>{{ $incident->type_of_incident }}</td>
                                <td>{{ Str::limit($incident->description, 50) }}</td>
                                <td>
                                    @foreach($incident->persons as $p)
                                        <div>{{ $p->name }} ({{ $p->is_main ? 'Main' : 'Passenger' }})</div>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No incidents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $incidents->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
