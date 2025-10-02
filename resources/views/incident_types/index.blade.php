@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between mb-3">
                Incident Type List
                <button type="button" class="btn btn-md btn-primary" id="addIncidentTypeBtn" data-bs-toggle="modal" data-bs-target="#formIncidentType">
                    Add Incident Type
                </button>
            </h4>
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="{{ route('incident_types') }}" class="custom_form mb-3" enctype="multipart/form-data" onsubmit="show()">
                    <div class="row height d-flex justify-content-end align-items-end">
                        <div class="col-md-9">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="Search Incident Type" name="search" value="{{ request('search') }}"> 
                                <button class="btn btn-sm btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th width="12%">Action</th>
                        <th width="25%">Name</th>
                        <th width="25%">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incident_types as $incident_type)
                        <tr>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Edit incident_type" data-bs-toggle="modal" data-bs-target="#editincident_type{{$incident_type->id}}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <form method="POST" class="d-inline-block" action="{{url('delete_incident_type/'.$incident_type->id)}}" onsubmit="show()" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $incident_type->name }}</td>
                            <td>{{ $incident_type->createdBy->name }}</td>
                        </tr>
                        @include('incident_types.edit')
                    @endforeach
                </tbody>
            </table>

            {{ $incident_types->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="formIncidentType" tabindex="-1" role="dialog" aria-labelledby="addIncidentTypeData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Incident Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/new_incident_type') }}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .search {
        position: relative;
        box-shadow: 0 0 20px rgba(51, 51, 51, .1);
    }
    .search button {
        position: absolute;
        top: 4px;
        right: 5px;
        width: 80px;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- include SweetAlert2 (must be included BEFORE you call Swal) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $(".deleteBtn").on('click', function() {
            var form = $(this).closest('form')

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit()
                }
            });
        })
    });
</script>
@endsection