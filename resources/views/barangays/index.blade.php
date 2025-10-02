@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between mb-3">
                Barangays List
                <button type="button" class="btn btn-md btn-primary" id="addBarangayBtn" data-bs-toggle="modal" data-bs-target="#formBarangay">
                    Add Barangay
                </button>
            </h4>
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="{{ route('barangays') }}" class="custom_form mb-3" enctype="multipart/form-data" onsubmit="show()">
                    <div class="row height d-flex justify-content-end align-items-end">
                        <div class="col-md-9">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="Search Barangays" name="search" value="{{ request('search') }}"> 
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
                    @foreach ($barangays as $barangay)
                        <tr>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Edit Barangay" data-bs-toggle="modal" data-bs-target="#editBarangay{{$barangay->id}}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                 <form method="POST" class="d-inline-block" action="{{url('delete_barangay/'.$barangay->id)}}" onsubmit="show()" enctype="multipart/form-data">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-outline-danger deleteBtn">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{ $barangay->name }}</td>
                            <td>{{ $barangay->createdBy->name }}</td>
                        </tr>
                        @include('barangays.edit')
                    @endforeach
                </tbody>
            </table>

            {{ $barangays->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<div class="modal fade" id="formBarangay" tabindex="-1" role="dialog" aria-labelledby="addBarangayData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Barangay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/new_barangay') }}" onsubmit="show()" enctype="multipart/form-data">
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