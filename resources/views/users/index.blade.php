@extends('layouts.header')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-between mb-3">
                Users List
                <button type="button" class="btn btn-md btn-primary" id="addUserBtn" data-bs-toggle="modal" data-bs-target="#formUser">
                    Add User
                </button>
            </h4>
            <div class="col-md-6 offset-md-6">
                <form method="GET" action="{{ route('users') }}" class="custom_form mb-3" enctype="multipart/form-data" onsubmit="show()">
                    <div class="row height d-flex justify-content-end align-items-end">
                        <div class="col-md-9">
                            <div class="search">
                                <input type="text" class="form-control" placeholder="Search Users" name="search" value="{{ request('search') }}"> 
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
                        <th width="25%">Email</th>
                        <th width="20%">Role</th>
                        <th width="18%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Edit User" data-bs-toggle="modal" data-bs-target="#editUser{{$user->id}}">
                                    <i class="mdi mdi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePassword-{{$user->id}}" title="Change Password">
                                    <i class="mdi mdi-account-key"></i>
                                </button>
                                <form method="POST" action="{{url('deactivate/'.$user->id)}}" class="d-inline-block" enctype="multipart/form-data" onsubmit="show()">
                                    @csrf
                                    <button type="button" class="deactivate btn btn-sm btn-outline-danger" title="Deactivate"><i class="mdi mdi-account-lock"></i></button>
                                </form>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->status }}</td>
                        </tr>
                        @include('users.edit')
                        @include('users.change_password')
                    @endforeach
                </tbody>
            </table>

            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formUser" tabindex="-1" role="dialog" aria-labelledby="addUserData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/new_user') }}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Role</label>
                            <select class="form-select" name="role" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Encoder">Encoder</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>

                        <div class="col-md-12 form-group mb-2"> 
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="********" required>
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
    $(document).ready(function () {
        // Delegate click handler so it works for dynamic rows as well
        $(document).on('click', '.deactivate', function (e) {
            e.preventDefault();

            // find the form that contains this button
            var form = $(this).closest('form');

            // show confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will deactivate the user account.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, deactivate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
