@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
@include('error')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Incidents <a href='{{url('incidents/create')}}'><button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addActivity">
                            <i class="ri-add-line align-bottom"></i>
                        </button></a></h5>
              
            </div>

            <div class="card-body">

                <!-- Filters -->
                <form method="GET" action="{{ url('incidents') }}" class="row g-3 mb-3 ">
                    <div class="col-md-2">
                        <select name="barangay" class="form-control select2">
                            <option value="">-- All Barangays --</option>
                            @foreach($barangays as $b)
                                <option value="{{ $b->id }}" {{ request('barangay') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="street" class="form-control select2">
                            <option value="">-- All Streets --</option>
                            @foreach($streets as $s)
                                <option value="{{ $s->id }}" {{ request('street') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
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
                            <th>Created By</th>
                            <th>Address <br> Lat / Long</th>
                            <th>Type</th>
                            <th>Persons Involved</th>
                            <th>Attachments</th>
                            <th>Enforcer</th>
                            <th>Actions</th>
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
                                <td>
                                   
                                    <a href="{{ url('incidents/'.$incident->id.'/edit') }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ri-pencil-fill"></i>
                                    </a>
                                </td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
    
    // Initialize Select2 inside modals
       
            $('.select2').select2();
  

   
    });
</script>
@endsection
