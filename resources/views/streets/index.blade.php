@extends('layouts.header')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between mb-3">
                Streets List
                <button type="button" class="btn btn-md btn-primary" id="addStreetBtn" data-bs-toggle="modal" data-bs-target="#formStreet">
                    Add Street
                </button>
            </h4>
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="{{ route('streets') }}" class="custom_form mb-3" enctype="multipart/form-data" onsubmit="show()">
                    <div class="row height d-flex justify-content-end align-items-end">
                        <div class="col-md-9">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="Search Streets" name="search" value="{{ request('search') }}"> 
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
                        <th width="25%">Barangay</th>
                        <th width="25%">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($streets as $street)
                        <tr>
                            <td>
                                {{-- <button class="btn btn-outline-info btn-sm" title="Edit street" data-bs-toggle="modal" data-bs-target="#editStreet{{$street->id}}">
                                    <i class="mdi mdi-pencil"></i>
                                </button> --}}
                                <form method="POST" class="d-inline-block" action="{{url('delete_street/'.$street->id)}}" onsubmit="show()" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $street->name }}</td>
                            <td>{{ optional($street->barangay)->name }}</td>
                            <td>{{ optional($street->createdBy)->name }}</td>
                        </tr>
                        @include('streets.edit')
                    @endforeach
                </tbody>
            </table>
            {{ $streets->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="formStreet" tabindex="-1" role="dialog" aria-labelledby="addStreetData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Street</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/new_street') }}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Barangay</label>
                            <select name="barangay_id" id="barangay" class="form-control select2" required>
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- include SweetAlert2 (must be included BEFORE you call Swal) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select Barangay',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#formStreet') 
        });

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