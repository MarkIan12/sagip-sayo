<div class="modal fade" id="editUser{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="addUserData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{url('update_user/'.$user->id)}}" onsubmit="show()" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name}}">
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{$user->email}}">
                        </div>
                        <div class="col-md-12 form-group mb-2">
                            <label>Role</label>
                            <select class="form-select" name="role" required>
                                <option value="" selected disabled>Select Role</option>
                                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Encoder" {{ $user->role == 'Encoder' ? 'selected' : '' }}>Encoder</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>